<?php

declare(strict_types=1);

namespace App\Livewire\Converts;

use Closure;

interface HandlerInterface
{
    public function handle(Property $property, Closure $next): mixed;
}
