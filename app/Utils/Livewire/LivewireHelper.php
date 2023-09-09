<?php

declare(strict_types=1);

namespace App\Utils\Livewire;

use Illuminate\Support\Str;
use Illuminate\Contracts\Config\Repository as Config;

final class LivewireHelper
{
    public function __construct(
        private Str $str,
        private Config $config
    ) {
    }

    public function getAlias(string $namespace): string
    {
        return $this->str->of($namespace)
            ->replace($this->config->get('livewire.class_namespace') . '\\', '')
            ->alias()
            ->toString();
    }
}
