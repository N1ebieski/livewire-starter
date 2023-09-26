<?php

declare(strict_types=1);

namespace App\View\Sidebar;

use Illuminate\Http\Request;
use App\View\Sidebar\Sidebar;

final class SidebarFactory
{
    public function __construct(private Request $request)
    {
    }

    public function make(): Sidebar
    {
        $show = true;

        $cookie = $this->request->cookie('sidebar_toggle');

        if (in_array($cookie, ['false', 'true'])) {
            $show = $cookie === 'true';
        }

        return new Sidebar(show: $show);
    }
}
