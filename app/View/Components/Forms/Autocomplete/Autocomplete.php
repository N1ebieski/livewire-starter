<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Autocomplete;

final class Autocomplete
{
    public function __construct(
        public readonly Data $data = new Data(),
        public readonly ?string $query = null,
        public readonly Events $events = new Events()
    ) {
    }
}
