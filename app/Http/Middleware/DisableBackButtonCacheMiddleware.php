<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;
use Livewire\Features\SupportDisablingBackButtonCache\SupportDisablingBackButtonCache;
use Livewire\Features\SupportDisablingBackButtonCache\DisableBackButtonCacheMiddleware as BaseDisableBackButtonCacheMiddleware ;

final class DisableBackButtonCacheMiddleware extends BaseDisableBackButtonCacheMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        SupportDisablingBackButtonCache::$disableBackButtonCache = !Config::get('livewire.back_button_cache');

        if ($response instanceof Response && SupportDisablingBackButtonCache::$disableBackButtonCache) {
            $response->headers->add([
                "Pragma" => "no-cache",
                "Expires" => "Fri, 01 Jan 1990 00:00:00 GMT",
                "Cache-Control" => "no-cache, must-revalidate, no-store, max-age=0, private",
            ]);
        }

        return $response;
    }
}
