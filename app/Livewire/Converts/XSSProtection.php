<?php

declare(strict_types=1);

namespace App\Livewire\Converts;

use Closure;
use Mews\Purifier\Facades\Purifier;
use App\Livewire\Converts\HandlerInterface;

final class XSSProtection implements HandlerInterface
{
    protected array $except = ['form.content_html'];

    public function handle(Property $property, Closure $next): mixed
    {
        if (!is_string($property->value)) {
            return $next($property);
        }

        if (in_array($property->name, $this->except, true)) {
            $property->value = Purifier::clean($property->value);
        } else {
            $property->value = strip_tags($property->value);
        }

        return $next($property);
    }
}
