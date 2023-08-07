<?php

declare(strict_types=1);

namespace App\Filters\User;

use App\Filters\Filter;
use App\Queries\Search;

class UserFilter extends Filter
{
    public function __construct(
        public readonly ?bool $status_email = null,
        public readonly ?Search $search = null,
        public readonly ?array $except = null,
    ) {
    }
}
