<?php

namespace App\Spotlight\Admin\User;

use App\Queries\Get;
use App\Queries\Search;
use App\Models\User\User;
use App\Queries\QueryBus;
use App\Spotlight\Command;
use App\Queries\SearchFactory;
use App\Filters\User\UserFilter;
use App\Policies\User\UserPolicy;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Contracts\Auth\Access\Gate;
use LivewireUI\Spotlight\SpotlightSearchResult;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use App\Livewire\Components\Modal\ModalComponent;
use Illuminate\Contracts\Auth\Guard as BaseGuard;
use App\Queries\User\GetByFilter\GetByFilterQuery;
use LivewireUI\Spotlight\SpotlightCommandDependency;
use App\View\Components\Modal\Modal as BootstrapModal;
use LivewireUI\Spotlight\SpotlightCommandDependencies;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @property-read Guard $guard
 */
class EditCommand extends Command
{
    /**
     * This is the name of the command that will be shown in the Spotlight component.
     */
    protected string $name = 'Użytkownicy: Edycja';

    /**
     * This is the description of your command which will be shown besides the command name.
     */
    // protected string $description = 'Redirect to user';

    /**
     * You can define any number of additional search terms (also known as synonyms)
     * to be used when searching for this command.
     */
    protected array $synonyms = [];

    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
        private QueryBus $queryBus,
        private User $user,
        private SearchFactory $searchFactory,
        private UserPolicy $userPolicy
    ) {
    }

    /**
     * Defining dependencies is optional. If you don't have any dependencies you can remove this method.
     * Dependencies are asked from your user in the order you add the dependencies.
     */
    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                // In this example we will register a 'team' dependency
                SpotlightCommandDependency::make('user')
                // The default Spotlight placeholder will be changed to your dependency place holder
                ->setPlaceholder('Szukaj użytkownika...')
            );
    }

    private function getFilterSearch(string $query): ?Search
    {
        return is_string($query) && mb_strlen($query) > 2 ?
            $this->searchFactory->make(
                search: $query,
                model: $this->user
            ) : null;
    }

    /**
     * Spotlight will resolve dependencies by calling the search method followed by your dependency name.
     * The method will receive the search query as the parameter.
     */
    public function searchUser(string $query): Collection
    {
        $filters = new UserFilter(search: $this->getFilterSearch($query));

        /** @var EloquentCollection */
        $users = $this->queryBus->execute(new GetByFilterQuery(
            user: $this->user,
            filters: $filters,
            result: new Get(take: 25)
        ));

        return $users->filter(function (User $user) {
            return $this->userPolicy->edit($this->guard->user(), $user);
        })
        ->map(function (User $user) {
            return new SpotlightSearchResult(
                id: $user->id,
                name: $user->name,
                description: null
            );
        });
    }

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight, User $user): void
    {
        $spotlight->dispatch(
            'create-modal',
            alias: 'admin.user.edit-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            user: $user->id
        )->to(ModalComponent::class);
    }

    /**
     * You can provide any custom logic you want to determine whether the
     * command will be shown in the Spotlight component. If you don't have any
     * logic you can remove this method. You can type-hint any dependencies you
     * need and they will be resolved from the container.
     */
    public function shouldBeShown(): bool
    {
        return $this->guard->user()?->hasRole(DefaultName::SUPER_ADMIN->value) ?? false;
    }
}
