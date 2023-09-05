<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Tinymce;

use Illuminate\Contracts\View\View;
use App\View\Components\Forms\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

class TinymceComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly Tinymce $tinymce = new Tinymce()
    ) {
    }

    public function withAttributes(array $attributes): self
    {
        /** @var self */
        $parent = parent::withAttributes(array_merge([
            'rows' => 10,
        ], $attributes));

        return $parent;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.forms.tinymce-component');
    }
}
