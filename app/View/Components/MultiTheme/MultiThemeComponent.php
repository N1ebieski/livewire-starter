<?php

declare(strict_types=1);

namespace App\View\Components\MultiTheme;

use App\View\Theme\ThemeHelper;
use App\View\Components\Component;
use Illuminate\Contracts\View\View;
use App\View\Theme\CurrentThemeFactory;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class MultiThemeComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected ViewFactory $viewFactory,
        private Config $config,
        private ThemeHelper $themeHelper,
        private CurrentThemeFactory $themeFactory
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return $this->viewFactory->make('components.multi-theme.multi-theme-component', [
            'themes' => $this->config->get('custom.multi_themes'),
            'currentTheme' => $this->themeFactory->make()->name,
            'themeHelper' => $this->themeHelper
        ]);
    }
}
