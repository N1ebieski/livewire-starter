<?php

declare(strict_types=1);

namespace App\View\Components\Modal;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ModalComponent extends Component
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
        return $this->viewFactory->make('components.modal.modal-component');
    }
}
