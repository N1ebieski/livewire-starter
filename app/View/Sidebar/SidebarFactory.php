<?php

declare(strict_types=1);

namespace App\View\Sidebar;

use Illuminate\Http\Request;
use App\View\Sidebar\Sidebar;

class SidebarFactory
{
    public function __construct(private Request $request)
    {
    }

    public function make(): Sidebar
    {
        $show = null;

        if (in_array($this->request->cookie('sidebar_toggle'), ['false', 'true'])) {
            $show = $this->request->cookie('sidebar_toggle') === 'true' ?
                true : false;
        }

        return new Sidebar(show: $show);
    }
}
