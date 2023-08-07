<?php

declare(strict_types=1);

namespace App\Queries\User\PaginateByFilter;

use App\Queries\Handler;
use App\Models\User\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginateByFilterHandler extends Handler
{
    public function handle(PaginateByFilterQuery $query): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator */
        $users = $query->user->newQuery()
            ->selectRaw("`{$query->user->getTable()}`.*")
            ->when(!is_null($query->filters->search), function (Builder|User $builder) use ($query) {
                return $builder->filterSearch($query->filters->search)
                    ->filterSearchAttributes($query->filters->search);
            })
            ->filterStatusEmail($query->filters->status_email)
            ->filterExcept($query->filters->except)
            ->when(is_null($query->orderby), function (Builder|User $builder) use ($query) {
                return $builder->filterOrderBySearch($query->filters->search);
            }, function (Builder|User $builder) use ($query) {
                return $builder->filterOrderBy($query->orderby);
            })
            ->orderBy("{$query->user->getTable()}.created_at", 'desc')
            ->orderBy("{$query->user->getTable()}.id", 'desc')
            ->filterPaginate($query->paginate);

        return $users;
    }
}
