<?php

declare(strict_types=1);

namespace App\View\Components\Form\Tomselect;

use Illuminate\Contracts\View\View;
use App\View\Components\Form\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

class TomselectComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly bool $labelFloating = false,
        public readonly ?string $lang = 'pl',
        public readonly ?string $endpoint = null,
        public readonly ?array $exceptIds = null,
        public readonly bool $validation = true,
        public readonly bool $highlight = false, 
        public readonly Type $type = new Type(Type::SELECT),
        public readonly Tomselect $tomselect = new Tomselect()
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.form.tomselect-component', [
            'except' => $this->exceptIds
        ]);
    }
}
