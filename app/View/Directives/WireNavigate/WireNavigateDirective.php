<?php

declare(strict_types=1);

namespace App\View\Directives\WireNavigate;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository as Config;

final class WireNavigateDirective
{
    public function __construct(
        private Guard $guard,
        private Config $config
    ) {
    }

    public function __invoke(): Closure
    {
        return function () {
            $navigate = "";

            if ($this->config->get('livewire.wire_navigate')) {
                $navigate .= "wire:navigate";

                if ($this->guard->check()) {
                    $navigate .= ".hover";
                }
            }

            return $navigate;
        };
    }
}
