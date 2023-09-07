<?php

declare(strict_types=1);

namespace App\View\Admin\Sidebar;

final class Sidebar
{
    public function __construct(public readonly ?bool $show = null)
    {
    }
}
