<?php

declare(strict_types=1);

namespace App\Support\Livewire\Url;

use Illuminate\Support\Str;
use Livewire\LivewireManager;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Config\Repository as Config;

final class UrlHelper
{
    public function __construct(
        private LivewireManager $livewireManager,
        private Config $config,
        private Collection $collection,
        private Str $str,
    ) {
    }

    private function getAvailablePrefixes(): array
    {
        /** @var array */
        $routes = $this->config->get('custom.routes');

        $prefixes = $this->collection->make($routes)
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
