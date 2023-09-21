<?php

declare(strict_types=1);

namespace App\View\Composers\Sidebar;

use Illuminate\View\View;
use App\View\Admin\Sidebar\SidebarFactory;

final class SidebarComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(private SidebarFactory $sidebarFactory)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('sidebarToggle', $this->sidebarFactory->make());
    }
}
