<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        /** @var \App\Macros\Str\CookieAlias */
        $cookieAlias = $this->app->make(\App\Macros\Str\CookieAlias::class);

        Str::macro('cookieAlias', $cookieAlias());

        /** @var \App\Macros\Stringable\CookieAlias */
        $cookieAlias = $this->app->make(\App\Macros\Stringable\CookieAlias::class);

        Stringable::macro('cookieAlias', $cookieAlias());
    }
}
