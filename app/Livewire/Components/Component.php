<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Converts\Property;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\Guard;
use Livewire\Component as BaseComponent;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pipeline\Pipeline;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Component extends BaseComponent
{
    protected Container $container;

    protected ViewFactory $viewFactory;

    protected Gate $gate;

    protected Guard $guard;

    public function __construct()
    {
        $this->container = App::make(Container::class);
        $this->viewFactory = App::make(ViewFactory::class);
        $this->gate = App::make(Gate::class);
        $this->guard = App::make(Guard::class);
    }

    /**
     *
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function updated($name, $value): void
    {
        /** @var Pipeline */
        $pipeline = $this->container->make(Pipeline::class);

        $property = $pipeline->send(new Property($name, $value))
            ->through([
                \App\Livewire\Converts\XSSProtection::class,
                \App\Livewire\Converts\ConvertEmptyStringsToNull::class,
            ])
            ->thenReturn();

        data_set($this, $name, $property->value);
    }
}
