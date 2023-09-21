<?php

declare(strict_types=1);

namespace App\Utils\Route;

use Illuminate\Support\Str;
use Illuminate\Contracts\Routing\Registrar as Router;

/**
 * @property-read \Illuminate\Routing\Router $router
 */
final class RouteHelper
{
    public function __construct(
        private Router $router,
        private Str $str
    ) {
    }

    public function isCurrentRouteStartsWith(mixed $names): bool
    {
        if (is_string($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            if ($this->str->startsWith($this->router->currentRouteName(), $name)) {
                return true;
            }

            return false;
        }
    }

    public function isCurrentRoute(mixed $names): bool
    {
        if (is_string($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            if ($this->router->currentRouteName() === $name) {
                return true;
            }
        }

        return false;
    }

    public function isCurrentRouteHasPoli(string $name, array $polis): bool
    {
        foreach ($polis as $poli) {
            if ($this->isCurrentRoute(str_replace('{poli}', $poli, $name))) {
                return true;
            }
        }

        return false;
    }

    public function getPermissionsByPoli(string $permission, array $polis): array
    {
        return array_map(function (string $poli) use ($permission) {
            return str_replace('{poli}', $poli, $permission);
        }, $polis);
    }
}
