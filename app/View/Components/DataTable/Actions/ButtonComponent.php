<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Actions;

use App\View\Components\Component;
use App\View\Components\HasTargets;
use Illuminate\Contracts\View\View;
use App\View\Components\Buttons\Action;
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
        return $this->viewFactory->make('components.data-table.actions.button-component');
    }
}
