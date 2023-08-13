<?php

declare(strict_types=1);

namespace App\View\Components\Buttons;

use App\View\Components\Action;
use App\View\Components\Component;
use App\View\Components\HasTargets;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ButtonComponent extends Component
{
    use HasTargets;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly Action $action = Action::PRIMARY,
        public readonly bool $responsive = true,
        public array $targets = []
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.buttons.button-component');
    }
}