<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Forms\Form;
use App\Livewire\Converts\Property;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\Guard;
use Livewire\Component as BaseComponent;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pipeline\Pipeline;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @property-read Form $form
 */
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
     * Fix. Livewire doesn't have access to the component's mount properties,
     * so we have to inject the rules manually in the component
     */
    public function booted(): void
    {
        if (property_exists($this, 'form')) {
            $this->form->addValidationRulesToComponent();
        }
    }

    /**
     * Temporary fix. Livewire add __rm__ to the array if removing element
     *
     * @param array $attributes
     * @return array
     */
    protected function prepareForValidation($attributes): array
    {
        if (property_exists($this, 'form')) {
            foreach (get_object_vars($attributes['form']) as $key => $value) {
                if (is_array($value)) {
                    $attributes['form']->{$key} = array_filter($value, function (mixed $value) {
                        return $value !== "__rm__";
                    });
                }
            }
        }

        return $attributes;
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
