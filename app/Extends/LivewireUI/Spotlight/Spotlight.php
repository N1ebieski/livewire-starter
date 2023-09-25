<?php

declare(strict_types=1);

namespace App\Extends\LivewireUI\Spotlight;

use App\Spotlight\Command;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\View\Factory;
use App\Livewire\Components\HasComponent;
use Illuminate\Contracts\Container\Container;
use LivewireUI\Spotlight\Spotlight as BaseSpotlight;
use Illuminate\Contracts\Config\Repository as Config;

final class Spotlight extends BaseSpotlight
{
    use HasComponent;

    private Config $config;

    private Collection $collection;

    private Container $container;

    public function boot(
        Config $config,
        Collection $collection,
        Container $container
    ): void {
        $this->config = $config;
        $this->collection = $collection;
        $this->container = $container;
    }

    public static function registerCommand(string $command): void
    {
        tap(App::make($command), function (Command $command) {
            if ($command->getDefault() && !method_exists($command, 'dependencies')) {
                throw new \Exception('A command without dependencies cannot be default.');
            }

            parent::$commands[] = $command;
        });
    }

    #[Computed()]
    public function shortcutsAsString(): string
    {
        $shortcuts = $this->config->get('livewire-ui-spotlight.shortcuts');

        return mb_strtoupper('CTRL+' . $shortcuts[0]);
    }

    public function render(): View|Factory
    {
        /** @var View */
        $view = parent::render();

        $view->with(
            'commands',
            $this->collection->make(self::$commands)
                ->filter(function (Command $command) {
                    if (!method_exists($command, 'shouldBeShown')) {
                        return true;
                    }

                    return $this->container->call([$command, 'shouldBeShown']);
                })
                ->values()
                ->map(fn (Command $command) => $command->toArray())
        );

        return $view;
    }
}
