<?php

namespace App\Spotlight\Admin\Role;

use App\Queries\Get;
use App\Queries\Search;
use App\Models\Role\Role;
use App\Queries\QueryBus;
use App\Spotlight\Command;
use App\Queries\SearchFactory;
use App\Filters\Role\RoleFilter;
use App\Policies\Role\RolePolicy;
use Illuminate\Support\Collection;
use LivewireUI\Spotlight\Spotlight;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Contracts\Auth\Access\Gate;
use LivewireUI\Spotlight\SpotlightSearchResult;
use App\Extends\Illuminate\Contracts\Auth\Guard;
use App\Livewire\Components\Modal\ModalComponent;
use Illuminate\Contracts\Auth\Guard as BaseGuard;
use App\Queries\Role\GetByFilter\GetByFilterQuery;
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
    protected string $name = 'Role i uprawnienia: Edycja';

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
        private Role $role,
        private SearchFactory $searchFactory,
        private RolePolicy $rolePolicy
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
                SpotlightCommandDependency::make('role')
                // The default Spotlight placeholder will be changed to your dependency place holder
                ->setPlaceholder('Szukaj roli...')
            );
    }

    private function getFilterSearch(string $query): ?Search
    {
        return is_string($query) && mb_strlen($query) > 2 ?
            $this->searchFactory->make(
                search: $query,
                model: $this->role
            ) : null;
    }

    /**
     * Spotlight will resolve dependencies by calling the search method followed by your dependency name.
     * The method will receive the search query as the parameter.
     */
    public function searchRole(string $query): Collection
    {
        $filters = new RoleFilter(search: $this->getFilterSearch($query));

        /** @var EloquentCollection */
        $roles = $this->queryBus->execute(new GetByFilterQuery(
            role: $this->role,
            filters: $filters,
            result: new Get(take: 25)
        ));

        return $roles->filter(function (Role $role) {
            return $this->rolePolicy->edit($this->guard->user(), $role);
        })
        ->map(function (Role $role) {
            return new SpotlightSearchResult(
                id: $role->id,
                name: $role->name,
                description: null
            );
        });
    }

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight, Role $role): void
    {
        $spotlight->dispatch(
            'create-modal',
            alias: 'admin.role.edit-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            role: $role->id
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
