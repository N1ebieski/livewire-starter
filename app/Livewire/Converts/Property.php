<?php

declare(strict_types=1);

namespace App\Livewire\Converts;

class Property
{
    public function __construct(
        public string $name,
        public mixed $value
    ) {
    }
}
