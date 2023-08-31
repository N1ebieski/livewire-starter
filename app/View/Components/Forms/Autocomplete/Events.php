<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Autocomplete;

final class Events
{
    public function __construct(
        public readonly Input $input = new Input(),
    ) {
    }
}
