<?php

declare(strict_types=1);

namespace App\View\Sidebar;

class Sidebar
{
    public function __construct(public readonly ?bool $show = null)
    {
    }
}
