<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Autocomplete;

final class Data
{
    public function __construct(
        public readonly array $src = [],
        public readonly ?array $keys = null,
        public readonly bool $cache = false,
    ) {
    }
}
