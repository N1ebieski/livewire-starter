<?php

declare(strict_types=1);

namespace App\View\Theme;

use App\View\Theme\Theme;
use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as Config;

final class CurrentThemeFactory
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

        $cookie = $this->request->cookie('theme_toggle');

        if (
            $this->themeHelper->isMultiThemeEnabled()
            && $this->themeHelper->doesUserHaveTheme()
            && is_string($cookie)
            && $this->themeHelper->isThemeAvailable($cookie)
        ) {
            $theme = $cookie;
        }

        return new Theme(name: $theme);
    }
}
