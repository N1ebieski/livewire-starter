<?php

declare(strict_types=1);

namespace App\Queries\Role\PaginateByFilter;

use App\Queries\OrderBy;
use App\Models\Role\Role;
use App\Queries\Paginate;
use App\Filters\Role\RoleFilter;

final class PaginateByFilterQuery
{
    public function __construct(
        public readonly Role $role,
        public readonly RoleFilter $filters,
        public readonly ?OrderBy $orderby = null,
        public readonly ?Paginate $paginate = null
    ) {
    }
}
