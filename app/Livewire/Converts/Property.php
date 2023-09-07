<?php

declare(strict_types=1);

namespace App\Livewire\Converts;

final class Property
{
    public function __construct(
        public string $name,
        public mixed $value
    ) {
    }
}
