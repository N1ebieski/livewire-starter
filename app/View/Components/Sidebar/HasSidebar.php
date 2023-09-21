<?php

declare(strict_types=1);

namespace App\View\Components\Sidebar;

/**
 * @property-read \Illuminate\Routing\Router $route
 */
trait HasSidebar
{
    public function isCurrentRoute(mixed $names): bool
    {
        if (is_string($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            if ($this->route->currentRouteName() === $name) {
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
