<?php

declare(strict_types=1);

namespace App\Queries\User\PaginateByFilter;

use App\Queries\OrderBy;
use App\Models\User\User;
use App\Queries\Paginate;
use App\Filters\User\UserFilter;

final class PaginateByFilterQuery
{
    public function __construct(
        public readonly User $user,
        public readonly UserFilter $filters,
        public readonly ?OrderBy $orderby = null,
        public readonly ?Paginate $paginate = null
    ) {
    }
}
