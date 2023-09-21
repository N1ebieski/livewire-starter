<?php

declare(strict_types=1);

namespace App\View\Components\Web\Layouts\App;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SlotComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $sidebarAlias = null
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.web.layouts.app.slot-component');
    }
}
