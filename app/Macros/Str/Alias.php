<?php

declare(strict_types=1);

namespace App\Macros\Str;

use Closure;
use Illuminate\Support\Str;

final class Alias
{
    public function __invoke(): Closure
    {
        return function (string $namespace): string {
            return Str::of($namespace)->replace('\\', '.')
                ->explode('.')
                ->map(fn ($name) => Str::of($name)->camel()->kebab())
                ->implode('.');
        };
    }
}
