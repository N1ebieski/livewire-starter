<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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
    }
}
