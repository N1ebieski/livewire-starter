<?php

declare(strict_types=1);

namespace App\View\Theme;

use App\View\Theme\Theme;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as Config;

class CurrentThemeFactory
{
    public function __construct(
        private Config $config,
        private Request $request,
        private ThemeHelper $themeHelper
    ) {
    }

    public function make(): Theme
    {
        /** @var string */
        $theme = $this->config->get('custom.theme');

        if (
            $this->themeHelper->isMultiThemeEnabled()
            && $this->themeHelper->doesUserHaveTheme()
            && $this->themeHelper->isThemeAvailable(
                //@phpstan-ignore-next-line
                $this->request->cookie('theme_toggle')
            )
        ) {
            /** @var string */
            $theme = $this->request->cookie('theme_toggle');
        }

        return new Theme(name: $theme);
    }
}
