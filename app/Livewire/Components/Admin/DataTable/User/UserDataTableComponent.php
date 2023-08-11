<?php

declare(strict_types=1);

namespace App\Livewire\Components\Admin\DataTable\User;

use App\Queries\Order;
use App\Queries\Search;
use App\Queries\OrderBy;
use App\Models\User\User;
use App\Queries\Paginate;
use App\Queries\QueryBus;
use App\Queries\SearchFactory;
use App\Filters\User\UserFilter;
use App\Filters\User\StatusEmail;
use Livewire\Attributes\Computed;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use App\Livewire\Components\DataTable\DataTableComponent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Queries\User\PaginateByFilter\PaginateByFilterQuery;
use App\Livewire\Forms\Admin\DataTable\User\UserDataTableForm;

final class UserDataTableComponent extends DataTableComponent
{
    private User $user;

    private QueryBus $queryBus;

    private SearchFactory $searchFactory;

    public UserDataTableForm $form;

    public function boot(
        User $user,
        QueryBus $queryBus,
        SearchFactory $searchFactory
    ): void {
        $this->user = $user;
        $this->queryBus = $queryBus;
        $this->searchFactory = $searchFactory;
    }

    #[Computed]
    public function users(): Collection|LengthAwarePaginator
    {
        if ($this->lazy) {
            return new Collection(array_fill(0, 25, $this->user));
        }

        $filters = new UserFilter(
            status_email: $this->getFilterStatusEmail(),
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

    protected function getAvailableColumns(): array
    {
        return [
            'id' => 'ID',
            'name' => $this->trans->get('user.name.label'),
            'email' => $this->trans->get('user.email.label'),
            'email_verified_at' => $this->trans->get('user.email_verified_at'),
            'created_at' => $this->trans->get('default.created_at'),
            'updated_at' => $this->trans->get('default.updated_at'),
        ];
    }

    protected function getShowingColumns(): array
    {
        return array_keys($this->availableColumns);
    }

    protected function getHidingColumns(): array
    {
        return array_merge_recursive([
            'sm' => ['email_verified_at', 'created_at', 'updated_at'],
        ], $this->hidingColumns);
    }

    protected function arePropertiesDirty(): bool
    {
        return $this->isDirty([
            'form.orderby',
            'form.search',
            'form.status_email'
        ]);
    }

    public function render(): View
    {
        // $this->gate->authorize("admin.user.view");

        return $this->viewFactory->make('livewire.admin.data-table.user.user-data-table-component');
    }
}
