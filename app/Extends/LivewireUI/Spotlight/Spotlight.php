<?php

declare(strict_types=1);

namespace App\Extends\LivewireUI\Spotlight;

use Illuminate\Support\Facades\App;
use LivewireUI\Spotlight\SpotlightCommand;
use LivewireUI\Spotlight\Spotlight as BaseSpotlight;

final class Spotlight extends BaseSpotlight
{
    public static function registerCommand(string $command): void
    {
        tap(App::make($command), function (SpotlightCommand $command) {
            parent::$commands[] = $command;
        });
    }
}
