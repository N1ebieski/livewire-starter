<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $this->mapAuthRoutes();

            $this->mapApiRoutes();

            $this->mapWebRoutes();

            $this->mapAdminRoutes();
        });
    }

    private function mapAuthRoutes(): void
    {
        if (Config::get('custom.routes.auth.enabled') === false) {
            return;
        }

        $router = Route::middleware('web')
            ->prefix(Config::get('custom.routes.auth.prefix'));

        if (count(Config::get('custom.multi_langs')) > 1) {
            $router->prefix(Config::get('custom.routes.auth.prefix') . '/{lang}')
                ->where(['lang' => '(' . implode('|', Config::get('custom.multi_langs')) . ')']);
        }

        $router->group(function () {
            if (!file_exists(base_path('routes') . '/vendor/icore/auth.php')) {
                require(__DIR__ . '/../../routes/auth.php');
            }
        });
    }

    private function mapApiRoutes(): void
    {
        if (Config::get('custom.routes.api.enabled') === false) {
            return;
        }

        $router = Route::middleware(['api', 'force.verified'])
            ->prefix(Config::get('custom.routes.api.prefix', 'api'))
            ->as('api.');

        if (count(Config::get('custom.multi_langs')) > 1) {
            $router->prefix(Config::get('custom.routes.api.prefix') . '/{lang}')
                ->where(['lang' => '(' . implode('|', Config::get('custom.multi_langs')) . ')']);
        }

        $router->group(function () {
            $filenames = glob(__DIR__ . '/../../routes/api/*.php') ?: [];

            foreach ($filenames as $filename) {
                require($filename);
            }
        });
    }

    private function mapWebRoutes(): void
    {
        if (Config::get('custom.routes.web.enabled') === false) {
            return;
        }

        $router = Route::middleware(['web', 'force.verified'])
            ->prefix(Config::get('custom.routes.web.prefix'))
            ->as('web.');

        if (count(Config::get('custom.multi_langs')) > 1) {
            $router->prefix(Config::get('custom.routes.web.prefix') . '/{lang}')
                ->where(['lang' => '(' . implode('|', Config::get('custom.multi_langs')) . ')']);
        }

        $router->group(function () {
            $filenames = glob(__DIR__ . '/../../routes/web/*.php') ?: [];

            foreach ($filenames as $filename) {
                require($filename);
            }
        });
    }

    private function mapAdminRoutes(): void
    {
        if (Config::get('custom.routes.admin.enabled') === false) {
            return;
        }

        $router = Route::middleware([
                'web',
                'auth',
                'force.verified',
                'permission:admin.access'
            ])
            ->prefix(Config::get('custom.routes.admin.prefix', 'admin'))
            ->as('admin.');

        if (count(Config::get('custom.multi_langs')) > 1) {
            $router->prefix(Config::get('custom.routes.admin.prefix') . '/{lang}')
                ->where(['lang' => '(' . implode('|', Config::get('custom.multi_langs')) . ')']);
        }

        $router->group(function () {
            $filenames = glob(__DIR__ . '/../../routes/admin/*.php') ?: [];

            foreach ($filenames as $filename) {
                require($filename);
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
