<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\Illuminate\Contracts\Pipeline\Pipeline::class, \Illuminate\Pipeline\Pipeline::class);

        $this->app->bind(\App\Extends\Laravel\Prompts\Contracts\Prompts::class, \App\Extends\Laravel\Prompts\PromptsFactory::class);

        $this->app->bind(
            \Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware::class,
            \App\Http\Middleware\DisableBackButtonCacheMiddleware::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
