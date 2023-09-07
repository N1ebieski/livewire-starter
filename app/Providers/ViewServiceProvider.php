<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', \App\View\Composers\Theme\ThemeComposer::class);
        View::composer('components.admin.sidebar.sidebar-component', \App\View\Composers\Sidebar\SidebarComposer::class);

        Blade::directive('wireNavigate', function (?string $modifier = null) {
            $navigate = "";

            if (Config::get('livewire.wire_navigate')) {
                $navigate .= "wire:navigate";

                if ($modifier) {
                    $navigate .= "." . substr($modifier, 1, -1);
                }
            }

            return $navigate;
        });
    }
}
