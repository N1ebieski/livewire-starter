<?php

declare(strict_types=1);

namespace App\Providers;

use Livewire;
use App\Support\Url\UrlHelper;
use Illuminate\Support\ServiceProvider;
use App\Extends\LivewireUI\Spotlight\Spotlight;

final class SpotlightServiceProvider extends ServiceProvider
{
    protected array $commands = [
        'admin' => [
            \App\Spotlight\Admin\User\IndexCommand::class,
            \App\Spotlight\Admin\User\CreateCommand::class,
            \App\Spotlight\Admin\User\EditCommand::class,
            \App\Spotlight\Admin\Role\IndexCommand::class,
            \App\Spotlight\Admin\Role\CreateCommand::class,
            \App\Spotlight\Admin\Role\EditCommand::class,
        ],
        'web' => [
            \App\Spotlight\Web\User\Account\IndexCommand::class
        ]
    ];

    public function boot(): void
    {
        Livewire::component('livewire-ui-spotlight', Spotlight::class);

        /** @var UrlHelper */
        $routeHelper = $this->app->make(UrlHelper::class);

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
