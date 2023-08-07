<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component as BaseComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Component extends BaseComponent
{
    public function __construct(
        protected ViewFactory $viewFactory
    ) {
    }
}
