<?php

declare(strict_types=1);

namespace App\View\Components\Web\Navbar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class NavbarComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly bool $autohide = true,
        public readonly ?string $sidebar = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.web.navbar.navbar-component');
    }
}
