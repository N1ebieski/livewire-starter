<?php

declare(strict_types=1);

namespace App\View\Components\Web\User\Sidebar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\Sidebar\HasSidebar;
use Illuminate\Contracts\Routing\Registrar as Route;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SidebarComponent extends Component
{
    use HasSidebar;

    public function __construct(
        protected ViewFactory $viewFactory,
        private Route $route
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.web.user.sidebar.sidebar-component');
    }
}
