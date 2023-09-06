<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\DataTables\User;

final class Attribute
{
    public function __construct(
        public readonly string $name,
        public readonly mixed $from,
        public readonly mixed $to
    ) {
    }
}
