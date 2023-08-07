<?php

declare(strict_types=1);

namespace App\View\Components\Admin\Navbar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class NavbarComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly bool $autohide = true
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.admin.navbar.navbar-component');
    }
}
