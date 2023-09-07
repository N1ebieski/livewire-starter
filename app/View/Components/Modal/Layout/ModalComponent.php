<?php

declare(strict_types=1);

namespace App\View\Components\Modal\Layout;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\Modal\Modal;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class ModalComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly Modal $modal
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.modal.layout.modal-component');
    }
}
