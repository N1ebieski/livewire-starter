<?php

declare(strict_types=1);

namespace App\View\Components\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

class EmailComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly bool $labelFloating = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.email-component');
    }
}
