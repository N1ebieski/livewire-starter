<?php

declare(strict_types=1);

namespace App\View\Theme;

use Illuminate\Http\Request;
use Illuminate\Contracts\Config\Repository as Config;

final class ThemeHelper
{
    public function __construct(
        private Config $config,
        private Request $request
    ) {
    }

    public function isMultiThemeEnabled(): bool
    {
        return count($this->config->get('custom.multi_themes')) > 1;
    }

    public function isThemeAvailable(string $theme): bool
    {
        return in_array($theme, $this->config->get('custom.multi_themes'));
    }

    public function doesUserHaveTheme(): bool
    {
        return !empty($this->request->cookie('theme_toggle'));
    }
}
