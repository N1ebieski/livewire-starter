<?php

declare(strict_types=1);

namespace App\Queries\Role\PaginateByFilter;

use App\Queries\Handler;
use App\Models\Role\Role;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PaginateByFilterHandler extends Handler
{
    public function handle(PaginateByFilterQuery $query): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator */
        $roles = $query->role->newQuery()
            ->selectRaw("`{$query->role->getTable()}`.*")
            ->when(!is_null($query->filters->search), function (Builder|Role $builder) use ($query) {
                return $builder->filterSearch($query->filters->search)
                    ->filterSearchAttributes($query->filters->search);
            })
            ->filterExcept($query->filters->except)
            ->when(is_null($query->orderby), function (Builder|Role $builder) use ($query) {
                return $builder->filterOrderBySearch($query->filters->search);
            }, function (Builder|Role $builder) use ($query) {
                return $builder->filterOrderBy($query->orderby);
            })
            ->orderBy("{$query->role->getTable()}.created_at", 'desc')
            ->orderBy("{$query->role->getTable()}.id", 'desc')
            ->withAllRelations()
            ->filterPaginate($query->paginate);

        return $roles;
    }
}
