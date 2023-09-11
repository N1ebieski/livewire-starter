<?php

declare(strict_types=1);

namespace App\Extends\LivewireUI\Spotlight;

use App\Spotlight\Command;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\View\Factory;
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

    public function render(): View|Factory
    {
        $baseView = parent::render();

        /** @var Collection */
        $commands = $baseView->commands;

        $commands->transform(function (array $data) {
            /** @var Command */
            $command = Collection::make(self::$commands)->first(function (Command $command) use ($data) {
                return $data['id'] === $command->getId();
            });

            $data['default'] = $command->getDefault();

            return $data;
        });

        return $baseView;
    }
}
