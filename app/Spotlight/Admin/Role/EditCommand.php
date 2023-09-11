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
use Illuminate\Contracts\Translation\Translator;
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
    public function __construct(
        protected Gate $gate,
        protected BaseGuard $guard,
        protected Translator $translator,
        private QueryBus $queryBus,
        private Role $role,
        private SearchFactory $searchFactory,
        private RolePolicy $rolePolicy
    ) {
        $this->name = "{$this->translator->get('role.pages.index.title')}: {$this->translator->get('default.edit')}";
    }

    public function dependencies(): ?SpotlightCommandDependencies
    {
        return SpotlightCommandDependencies::collection()
            ->add(
                // In this example we will register a 'team' dependency
                SpotlightCommandDependency::make('role')
                // The default Spotlight placeholder will be changed to your dependency place holder
                ->setPlaceholder("{$this->translator->get('role.pages.search.title')}...")
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

    public function searchRole(string $query): Collection
    {
        $search = $this->getFilterSearch($query);

        if (is_null($search)) {
            return new Collection();
        }

        $filters = new RoleFilter(search: $search);

        /** @var EloquentCollection */
        $roles = $this->queryBus->execute(new GetByFilterQuery(
            role: $this->role,
            filters: $filters,
            result: new Get(take: 25)
        ));

        return $roles->filter(function (Role $role) {
            return $this->guard->user() ?
                $this->rolePolicy->edit($this->guard->user(), $role) : false;
        })
        ->map(function (Role $role) {
            return new SpotlightSearchResult(
                id: $role->id,
                name: $role->name,
                description: null
            );
        });
    }

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

    public function shouldBeShown(): bool
    {
        return $this->guard->user()?->hasRole(DefaultName::SUPER_ADMIN->value) ?? false;
    }
}
