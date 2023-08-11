<?php

declare(strict_types=1);

namespace App\View\Components\Forms;

use Illuminate\Support\Str;
use App\View\Components\Component;
use Illuminate\Support\Collection;

abstract class FormComponent extends Component
{
    public function withAttributes(array $attributes): self
    {
        $wire = (new Collection($attributes))
            ->first(fn ($value, string $key) => Str::startsWith($key, 'wire:model'));

        return parent::withAttributes(array_merge([
            'id' => $wire ? $this->getId($wire) : $attributes['id'],
            'name' => $wire ? $wire : $attributes['name'],
        ], $attributes));
    }

    public function getId(string $name): string
    {
        return Str::replace('.', '-', $name);
    }
}
