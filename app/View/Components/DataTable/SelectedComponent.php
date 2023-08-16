<?php

declare(strict_types=1);

namespace App\View\Components\DataTable;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class SelectedComponent extends Component
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly LengthAwarePaginator $collection
    ) {
    }

    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.selected-component');
    }
}
