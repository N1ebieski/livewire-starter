<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\DataTables\User;

use App\Queries\Order;
use App\Queries\Search;
use App\Queries\OrderBy;
use App\Models\Role\Role;
use App\Models\User\User;
use App\Queries\Paginate;
use App\Queries\QueryBus;
use Livewire\Attributes\On;
use App\Commands\CommandBus;
use App\Queries\SearchFactory;
use App\Filters\User\UserFilter;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use App\Livewire\Components\Component;
use App\ValueObjects\User\StatusEmail;
use App\Livewire\Components\HasComponent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Translation\Translator;
use App\Livewire\Components\Modal\ModalComponent;
use App\Livewire\Components\DataTable\HasDataTable;
use App\View\Components\Modal\Modal as BootstrapModal;
use App\Livewire\Components\DataTable\DataTableInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Livewire\Forms\Admin\DataTables\User\DataTableForm;
use App\Queries\User\PaginateByFilter\PaginateByFilterQuery;
use App\Commands\User\EditStatusEmail\EditStatusEmailCommand;

/**
 * @property Collection $users
 * @property DataTableForm $form
 */
final class DataTableComponent extends Component implements DataTableInterface
{
    use HasComponent;
    use HasDataTable;

    private User $user;

    private Role $role;

    private QueryBus $queryBus;

    private SearchFactory $searchFactory;

    public DataTableForm $form;

    public function boot(
        User $user,
        Role $role,
        QueryBus $queryBus,
        SearchFactory $searchFactory
    ): void {
        $this->user = $user;
        $this->role = $role;
        $this->queryBus = $queryBus;
        $this->searchFactory = $searchFactory;
    }

    #[Computed]
    public function users(): LengthAwarePaginator
    {
        $filters = new UserFilter(
            status_email: $this->getFilterStatusEmail(),
            role: $this->getFilterRole(),
            search: $this->getFilterSearch()
        );

        /** @var LengthAwarePaginator<User> */
        $users = $this->queryBus->execute(new PaginateByFilterQuery(
            user: $this->user,
            filters: $filters,
            orderby: $this->getFilterOrderBy(),
            paginate: $this->getFilterPaginate()
        ));

        return $users;
    }

    #[Computed(persist: true)]
    public function roles(): Collection
    {
        return $this->role->all();
    }

    private function getFilterRole(): ?Role
    {
        return !is_null($this->form->role) ?
            $this->role->find($this->form->role) : null;
    }

    private function getFilterPaginate(): Paginate
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
                model: $this->user
            ) : null;
    }

    private function getFilterStatusEmail(): ?bool
    {
        return StatusEmail::tryFrom($this->form->status_email ?? '')?->getAsBool();
    }

    protected function getSorts(): array
    {
        return $this->user->sortable;
    }

    protected function getFilters(): array
    {
        return ['search', 'status_email', 'role', 'columns', 'paginate'];
    }

    protected function getAvailableColumns(): array
    {
        return [
            'id' => 'ID',
            'email' => $this->translator->get('user.email.label'),
            'roles' => $this->translator->get('user.roles.label'),
            'email_verified_at' => $this->translator->get('user.email_verified_at'),
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
            'sm' => ['roles', 'email_verified_at', 'created_at', 'updated_at'],
        ], $this->hidingColumns);
    }

    protected function arePropertiesDirty(): bool
    {
        return $this->isDirty([
            'form.orderby',
            'form.search',
            'form.status_email',
            'form.role'
        ]);
    }

    public function toggleStatusEmail(
        CommandBus $commandBus,
        Translator $translator,
        User $user
    ): void {
        $this->gate->authorize('toggleStatusEmail', $user);

        /** @var StatusEmail */
        $status = $user->status_email->toggle();

        $commandBus->execute(new EditStatusEmailCommand(
            user: $user,
            status: $status
        ));

        if ($status->isEquals(StatusEmail::VERIFIED)) {
            $this->dispatch(
                'create-toast',
                body: $translator->get('user.actions.toggle_status_email.' . $status->value, [
                    'email' => $user->email,
                    'name' => $user->name
                ])
            );
        }

        $this->dispatch(
            'highlight',
            ids: [$user->id],
            action: $status->getAction()
        );
    }

    public function create(): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.user.create-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            role: $this->form->role
        )->to(ModalComponent::class);
    }

    public function edit(User $user): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.user.edit-component',
            modal: new BootstrapModal(
                static: true,
                scrollable: true
            ),
            user: $user->id
        )->to(ModalComponent::class);
    }

    public function delete(User $user): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.user.delete-component',
            modal: new BootstrapModal(),
            user: $user->id
        )->to(ModalComponent::class);
    }

    public function deleteMulti(array $ids): void
    {
        $this->dispatch(
            'create-modal',
            alias: 'admin.user.delete-multi-component',
            modal: new BootstrapModal(),
            ids: $ids
        )->to(ModalComponent::class);
    }

    #[On('created-user')]
    public function updateSearch(User $user): void
    {
        $this->form->search = "attr:id:\"{$user->id}\"";
    }

    public function render(): View
    {
        $this->gate->authorize("admin.user.view");

        return $this->viewFactory->make('livewire.admin.data-tables.user.data-table-component');
    }
}
