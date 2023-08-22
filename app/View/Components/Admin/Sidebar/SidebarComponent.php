<?php

declare(strict_types=1);

namespace App\View\Components\Admin\Sidebar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Routing\Registrar as Route;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @property \Illuminate\Routing\Router $route
 */
class SidebarComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        private Route $route
    ) {
    }

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

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.admin.sidebar.sidebar-component');
    }
}
