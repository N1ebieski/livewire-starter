<?php

declare(strict_types=1);

namespace App\Queries;

class OrderBy
{
    public function __construct(
        public readonly string $attribute,
        public readonly Order $order
    ) {
    }
}
