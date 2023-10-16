<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Switch;

use Illuminate\Contracts\View\View;
use App\View\Components\Forms\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SwitchComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly string $label,
        public readonly ?string $tooltip = null,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.switch.switch-component');
    }
}
