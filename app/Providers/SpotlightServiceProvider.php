<?php

declare(strict_types=1);

namespace App\Providers;

use App\Utils\Route\RouteHelper;
use Illuminate\Support\ServiceProvider;
use App\Extends\LivewireUI\Spotlight\Spotlight;

final class SpotlightServiceProvider extends ServiceProvider
{
    protected array $commands = [
        'admin' => [
            \App\Spotlight\Admin\Role\IndexCommand::class
        ]
    ];

    public function boot(): void
    {
        /** @var RouteHelper */
        $routeHelper = $this->app->make(RouteHelper::class);

        $prefix = $routeHelper->getPrefix();

        if (is_null($prefix)) {
            $prefix = 'web';
        }

        if (!isset($this->commands[$prefix])) {
            return;
        }

        foreach ($this->commands[$prefix] as $command) {
            Spotlight::registerCommand($command);
        }
    }
}
