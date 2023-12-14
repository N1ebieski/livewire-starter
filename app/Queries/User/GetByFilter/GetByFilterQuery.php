<?php

declare(strict_types=1);

namespace App\Queries\User\GetByFilter;

use App\Queries\Get;
use App\Queries\Query;
use App\Queries\OrderBy;
use App\Models\User\User;
use App\Queries\Paginate;
use App\Filters\User\UserFilter;

final class GetByFilterQuery extends Query
{
    public function __construct(
        public readonly User $user,
        public readonly UserFilter $filters,
        public readonly ?OrderBy $orderby = null,
        public readonly Paginate|Get|null $result = null
    ) {
    }
}
