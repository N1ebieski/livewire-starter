<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\DataTable\Role;

use App\Queries\Order;
use App\Queries\Search;
use App\Queries\OrderBy;
use App\Models\Role\Role;
use App\Models\User\User;
use App\Queries\Paginate;
use App\Queries\QueryBus;
use App\Queries\SearchFactory;
use App\Filters\Role\RoleFilter;
use Livewire\Attributes\Computed;
use App\Livewire\Components\Component;
use App\Livewire\Components\HasComponent;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Components\Modal\ModalComponent;
use App\Livewire\Components\DataTable\HasDataTable;
use App\View\Components\Modal\Modal as BootstrapModal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Livewire\Forms\Admin\DataTable\Role\DataTableForm;
use App\Queries\Role\PaginateByFilter\PaginateByFilterQuery;

/**
 * @property Collection $roles
 */
final class DataTableComponent extends Component
{
    use HasComponent;
    use HasDataTable;

    private Role $role;

    private QueryBus $queryBus;

    private SearchFactory $searchFactory;

    public DataTableForm $form;

    public function boot(
        Role $role,
        QueryBus $queryBus,
        SearchFactory $searchFactory
    ): void {
        $this->role = $role;
        $this->queryBus = $queryBus;
        $this->searchFactory = $searchFactory;
    }

    #[Computed]
    public function roles(): LengthAwarePaginator
    {
        $filters = new RoleFilter(
            search: $this->getFilterSearch()
        );

        /** @var LengthAwarePaginator<Role> */
        $roles = $this->queryBus->execute(new PaginateByFilterQuery(
            role: $this->role,
            filters: $filters,
            orderby: $this->getFilterOrderBy(),
            paginate: $this->getFilterPaginate()
        ));

        return $roles;
    }

    private function getFilterPaginate(): ?Paginate
    {
        return new Paginate($this->form->paginate);
    }

    private function getFilterOrderBy(): ?OrderBy
    {
        if (is_string($this->form->orderby)) {
            [$attribute, $order] = explode('|', $this->form->orderby);

            return new OrderBy(
                attribute: $attribute,
                order: Order::from($order)
            );
        }

        return null;
    }

    private function getFilterSearch(): ?Search
    {
        return is_string($this->form->search) && mb_strlen($this->form->search) > 2 ?
            $this->searchFactory->make(
                search: $this->form->search,
                model: $this->role
            ) : null;
    }

    protected function getSorts(): array
    {
        return $this->role->sortable;
    }

    protected function getAvailableColumns(): array
    {
        return [
            'id' => 'ID',
            'created_at' => $this->translator->get('default.created_at'),
            'updated_at' => $this->translator->get('default.updated_at'),
        ];
    }

    protected function getShowingColumns(): array
    {
        return array_merge(['name'], array_keys($this->availableColumns));
    }

    protected function getHidingColumns(): array
    {
        return array_merge_recursive([
            'sm' => ['created_at', 'updated_at'],
        ], $this->hidingColumns);
    }

    protected function arePropertiesDirty(): bool
    {
        return $this->isDirty([
            'form.orderby',
            'form.search'
        ]);
    }

    public function create(): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.role.create-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            )
        )->to(ModalComponent::class);
    }

    public function edit(Role $role): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.role.edit-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            role: $role->id
        )->to(ModalComponent::class);
    }

    public function delete(Role $role): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.role.delete-component',
            modal: new BootstrapModal(),
            role: $role->id
        )->to(ModalComponent::class);
    }

    public function deleteMulti(array $ids): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.role.delete-multi-component',
            modal: new BootstrapModal(),
            ids: $ids
        )->to(ModalComponent::class);
    }

    public function render()
    {
        $this->gate->authorize("admin.role.view");

        return $this->viewFactory->make('livewire.admin.data-table.role.data-table-component');
    }
}
