<?php

declare(strict_types=1);

namespace App\Macros\Stringable;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

final class Alias extends Stringable
{
    public function __invoke(): Closure
    {
        return function (): Stringable {
            return new Stringable(Str::alias($this->value));
        };
    }
}
