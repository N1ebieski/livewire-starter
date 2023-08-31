<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Autocomplete;

use Illuminate\Contracts\View\View;
use App\View\Components\Forms\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

class AutocompleteComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly bool $labelFloating = false,
        public readonly ?string $endpoint = null,
        public readonly ?array $exceptIds = null,
        public readonly bool $validation = true,
        public readonly bool $highlight = true,
        public readonly Autocomplete $autocomplete = new Autocomplete()
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.autocomplete-component', [
            'except' => $this->exceptIds
        ]);
    }
}
