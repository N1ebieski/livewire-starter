<?php

declare(strict_types=1);

namespace App\Utils\Route;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Livewire\LivewireManager;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Config\Repository as Config;

final class RouteHelper
{
    public function __construct(
        private LivewireManager $livewireManager,
        private Config $config,
        private Collection $collection,
        private Str $str,
        private Request $request
    ) {
    }

    private function getAvailablePrefixes(): array
    {
        $prefixes = $this->collection->make($this->config->get('custom.routes'))
            ->pluck('prefix')
            ->filter()
            ->toArray();

        return $prefixes;
    }

    public function getPrefix(): ?string
    {
        $url = $this->str->start($this->livewireManager->originalPath(), '/');

        $prefix = $this->str->match('/(?:(?:^\/[a-z]{2})|^)\/(' . implode('|', $this->getAvailablePrefixes()) . ')/', $url);

        return !empty($prefix) ? $prefix : null;
    }
}
