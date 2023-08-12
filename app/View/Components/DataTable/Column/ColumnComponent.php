<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Column;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\DataTable\HasDisplay;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ColumnComponent extends Component
{
    use HasDisplay;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $name = null,
        public readonly ?array $columns = null,
        public readonly array $hidingColumns = []
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.column.column-component');
    }
}
