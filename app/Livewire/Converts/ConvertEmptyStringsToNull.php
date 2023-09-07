<?php

declare(strict_types=1);

namespace App\Livewire\Converts;

use Closure;
use App\Livewire\Converts\HandlerInterface;

final class ConvertEmptyStringsToNull implements HandlerInterface
{
    private array $except = [];

    public function handle(Property $property, Closure $next): mixed
    {
        if (!is_string($property->value) || in_array($property->name, $this->except)) {
            return $next($property);
        }

        $property->value = trim($property->value);
        $property->value = $property->value === '' ? null : $property->value;

        return $next($property);
    }
}
