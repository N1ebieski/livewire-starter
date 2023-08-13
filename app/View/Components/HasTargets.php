<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

trait HasTargets
{
    public function withAttributes(array $attributes): self
    {
        $wire = (new Collection($attributes))
            ->first(fn ($value, string $key) => Str::startsWith($key, 'wire:click'));

        if ($wire) {
            $this->targets = array_merge([$wire], $this->targets);
        }

        return parent::withAttributes($attributes);
    }

    public function getTargetsAsString(): string
    {
        return implode(',', $this->targets);
    }
}
