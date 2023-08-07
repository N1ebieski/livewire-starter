<?php

declare(strict_types=1);

namespace App\Queries;

class Paginate
{
    public function __construct(public readonly int $perPage)
    {
    }
}
