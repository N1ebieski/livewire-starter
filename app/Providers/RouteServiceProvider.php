<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
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
            if (file_exists(base_path('routes') . '/auth.php')) {
                require(base_path('routes') . '/auth.php');
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
            $filenames = File::allFiles(base_path('routes') . '/api');

            foreach ($filenames as $filename) {
                if ($filename->getExtension() !== 'php') {
                    continue;
                }

                require($filename);
            }

            if (file_exists(base_path('routes') . '/api.php')) {
                require(base_path('routes') . '/api.php');
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
            $filenames = File::allFiles(base_path('routes') . '/web');

            foreach ($filenames as $filename) {
                if ($filename->getExtension() !== 'php') {
                    continue;
                }

                require($filename->getPathname());
            }

            if (file_exists(base_path('routes') . '/web.php')) {
                require(base_path('routes') . '/web.php');
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
            $filenames = File::allFiles(base_path('routes') . '/admin');

            foreach ($filenames as $filename) {
                if ($filename->getExtension() !== 'php') {
                    continue;
                }

                require($filename);
            }

            if (file_exists(base_path('routes') . '/admin.php')) {
                require(base_path('routes') . '/admin.php');
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
