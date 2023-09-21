<?php

declare(strict_types=1);

namespace App\View\Components\Web\Navbar;

use App\Utils\Route\RouteHelper;
use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class NavbarComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        private RouteHelper $routeHelper,
        public readonly bool $autohide = true,
        public readonly bool $sidebar = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.web.navbar.navbar-component', [
            'routeHelper' => $this->routeHelper
        ]);
    }
}
