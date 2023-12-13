<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Select;

use Illuminate\Contracts\View\View;
use App\View\Components\Forms\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SelectComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly bool $labelFloating = false,
        public readonly bool $highlight = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.select.select-component');
    }
}
