<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Tinymce;

use Illuminate\Contracts\View\View;
use App\View\Theme\CurrentThemeFactory;
use App\View\Components\Forms\FormComponent;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class TinymceComponent extends FormComponent
{
    public function __construct(
        protected ViewFactory $viewFactory,
        private CurrentThemeFactory $currentThemeFactory,
        public readonly ?string $label = null,
        public readonly ?string $tooltip = null,
        public readonly Tinymce $tinymce = new Tinymce()
    ) {
        $this->setThemeToTinyMCE();
    }

    private function setThemeToTinyMCE(): void
    {
        $theme = $this->currentThemeFactory->make();

        if (is_null($this->tinymce->skin)) {
            $this->tinymce->skin = $theme->name === 'dark' ? 'tinymce-5-dark' : 'tinymce-5';
        }

        if (is_null($this->tinymce->content_css)) {
            $this->tinymce->content_css = $theme->name === 'dark' ? 'dark' : 'default';
        }
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
        return $this->viewFactory->make('components.forms.tinymce.tinymce-component');
    }
}
