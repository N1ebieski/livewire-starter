<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Forms\Form;
use App\Livewire\Converts\Property;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Pipeline\Pipeline;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @property-read Form $form
 */
trait HasComponent
{
    private Container $container;

    private ViewFactory $viewFactory;

    private Gate $gate;

    private Guard $guard;

    public function bootHasComponent(
        Container $container,
        ViewFactory $viewFactory,
        Gate $gate,
        Guard $guard
    ): void {
        $this->container = $container;
        $this->viewFactory = $viewFactory;
        $this->gate = $gate;
        $this->guard = $guard;
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
    public function updatedHasComponent($name, $value): void
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
