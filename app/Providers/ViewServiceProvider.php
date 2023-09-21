<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', \App\View\Composers\Theme\ThemeComposer::class);

        /** @var \App\View\Directives\WireNavigate\WireNavigateDirective */
        $wireNavigateDirective = $this->app->make(\App\View\Directives\WireNavigate\WireNavigateDirective::class);

        Blade::directive('wireNavigate', $wireNavigateDirective());
    }
}
