<?php

declare(strict_types=1);

namespace App\View\Components\Card;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class CardComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?Action $action = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.card.card-component');
    }
}
