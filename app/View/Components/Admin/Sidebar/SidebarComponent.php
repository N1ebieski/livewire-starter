<?php

declare(strict_types=1);

namespace App\View\Components\Admin\Sidebar;

use App\Support\Route\RouteHelper;
use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Admin\Sidebar\SidebarFactory;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SidebarComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        private RouteHelper $routeHelper,
        private SidebarFactory $sidebarFactory
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.admin.sidebar.sidebar-component', [
            'routeHelper' => $this->routeHelper,
            'sidebar' => $this->sidebarFactory->make()
        ]);
    }
}
