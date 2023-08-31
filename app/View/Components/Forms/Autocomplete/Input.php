<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Autocomplete;

final class Input
{
    public function __construct(
        public readonly ?string $selection = null,
    ) {
    }
}
