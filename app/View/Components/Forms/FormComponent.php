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

        if ($wire) {
            $attributes['id'] = $this->getId($wire);
            $attributes['name'] = $wire;
        } else {
            if (!array_key_exists('name', $attributes)) {
                $attributes['name'] = $attributes['id'];
            }
        }

        return parent::withAttributes($attributes);
    }

    public function getId(string $name): string
    {
        /** @var string */
        return Str::replace('.', '-', $name);
    }
}
