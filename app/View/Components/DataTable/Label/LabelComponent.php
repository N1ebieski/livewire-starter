<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Label;

use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Components\DataTable\HasDisplay;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class LabelComponent extends Component
{
    use HasDisplay;

    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $name,
        public readonly ?string $value = null,
        public readonly ?array $columns = null,
        public readonly array $hidingColumns = [],
        public readonly array $sorts = []
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.data-table.label.label-component');
    }
}
