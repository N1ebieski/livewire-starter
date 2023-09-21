<?php

declare(strict_types=1);

namespace App\View\Composers\Theme;

use Illuminate\View\View;
use App\View\Theme\CurrentThemeFactory;

final class ThemeComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(private CurrentThemeFactory $themeFactory)
    {
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('currentTheme', $this->themeFactory->make());
    }
}
