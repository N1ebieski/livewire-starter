<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\BulkActions;

use App\View\Components\Action;
use App\View\Components\Component;
use App\View\Components\HasTargets;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class BulkActionComponent extends Component
{
    use HasTargets;

    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly Action $action = Action::PRIMARY,
        public readonly array $targets = []
    ) {
    }

    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.bulk-actions.bulk-action-component');
    }
}