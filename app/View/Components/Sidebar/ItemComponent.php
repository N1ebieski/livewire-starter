<?php

declare(strict_types=1);

namespace App\View\Components\Sidebar;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class ItemComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly bool $active = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.sidebar.item-component');
    }
}
