<?php

declare(strict_types=1);

namespace App\View\Components\Alert;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class AlertComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly Action $action,
        public readonly bool $close = true
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.alert.alert-component');
    }
}
