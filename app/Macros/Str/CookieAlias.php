<?php

declare(strict_types=1);

namespace App\Macros\Str;

use Closure;
use Illuminate\Support\Str;

class CookieAlias
{
    public function __invoke(): Closure
    {
        return function (string $namespace): string {
            return Str::of($namespace)->replace('\\', '_')
                ->explode('_')
                ->map(fn ($name) => Str::of($name)->camel()->kebab())
                ->implode('_');
        };
    }
}
