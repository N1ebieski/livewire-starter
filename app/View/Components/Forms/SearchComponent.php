<?php

declare(strict_types=1);

namespace App\View\Components\Forms;

use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class SearchComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly bool $labelFloating = false,
        public readonly bool $highlight = false
    ) {
    }

    public function getReset(): string
    {
        $name = Str::of($this->attributes->get('name'))
            ->explode('.')
            ->map(fn ($name) => ucfirst($name))
            ->implode('');

        return "reset{$name}";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.search-component');
    }
}
