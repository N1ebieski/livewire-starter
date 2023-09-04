<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Filter;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class FilterComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $name,
        public readonly array $filters = [],
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.filter.filter-component');
    }
}
