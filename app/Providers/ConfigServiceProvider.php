<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

final class ConfigServiceProvider extends ServiceProvider
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
        $url = Config::get('app.url');

        /** @var string */
        $scheme = parse_url($url, PHP_URL_SCHEME);

        URL::forceScheme($scheme);
        URL::forceRootUrl($url);
    }
}
