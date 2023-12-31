<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\BulkActions;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\Button\Action;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class ButtonComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly Action $action = Action::PRIMARY,
        public readonly bool $responsive = true
    ) {
    }

    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.bulk-actions.button-component');
    }
}
