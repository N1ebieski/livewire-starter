<?php

declare(strict_types=1);

namespace App\View\Directives\WireNavigate;

use Closure;
use Illuminate\Contracts\Config\Repository as Config;

final class WireNavigateDirective
{
    public function __construct(private Config $config)
    {
    }

    public function __invoke(): Closure
    {
        return function (?string $modifier = null) {
            $navigate = "";

            if ($this->config->get('livewire.wire_navigate')) {
                $navigate .= "wire:navigate";

                // Livewire is currently bugged. I disable this feature for a while
                // if ($modifier) {
                    //     $navigate .= "." . substr($modifier, 1, -1);
                // }
            }

            return $navigate;
        };
    }
}
