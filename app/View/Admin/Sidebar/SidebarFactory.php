<?php

declare(strict_types=1);

namespace App\View\Admin\Sidebar;

use Illuminate\Http\Request;
use App\View\Admin\Sidebar\Sidebar;

class SidebarFactory
{
    public function __construct(private Request $request)
    {
    }

    public function make(): Sidebar
    {
        $show = null;

        $cookie = $this->request->cookie('admin_sidebar_toggle');

        if (in_array($cookie, ['false', 'true'])) {
            $show = $cookie === 'true';
        }

        return new Sidebar(show: $show);
    }
}
