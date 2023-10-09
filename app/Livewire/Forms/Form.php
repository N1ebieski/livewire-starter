<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Form as BaseForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Config\Repository as Config;

abstract class Form extends BaseForm
{
    protected array $messages = [];

    protected Container $container;

    protected Rule $rule;

    protected Gate $gate;

    protected Guard $guard;

    protected Config $config;

    //@phpstan-ignore-next-line
    public function __construct(
        protected Component $component,
        protected $propertyName
    ) {
        /** @var Container */
        $this->container = App::make(Container::class);
        $this->rule = App::make(Rule::class);
        $this->guard = App::make(Guard::class);
        $this->gate = App::make(Gate::class);
        $this->config = App::make(Config::class);

        /**
         * Fix. Livewire doesn't have access to the component's mount properties,
         * so we have to inject the rules manually in the component
         */
        if ($this->areComponentTypedPropertiesInitiated()) {
            parent::__construct($component, $propertyName);
        }

        if (method_exists($this, 'boot')) {
            $this->container->call([$this, 'boot']);
        }
    }

    /**
     * Fix. Livewire doesn't have access to the component's mount properties,
     * so we have to inject the rules manually in the component
     */
    private function areComponentTypedPropertiesInitiated(): bool
    {
        $reflectionClass = new \ReflectionClass($this->component);

        $properties = $reflectionClass->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            if (
                !is_null($property->getType())
                && $property->getName() !== 'form'
                && !isset($this->component->{$property->getName()})
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Fix. Livewire doesn't have a resetExcept method
     */
    public function resetExcept(string|array ...$properties): void
    {
        if (count($properties) && is_array($properties[0])) {
            $properties = $properties[0];
        }

        $keysToReset = array_diff(array_keys($this->all()), $properties);

        $this->reset($keysToReset);
    }

    /**
     * Temporary fix. Livewire add __rm__ to the array if removing element
     *
     * @param array $attributes
     * @return array
     */
    public function prepareForValidation(array $attributes): array
    {
        foreach ($attributes as $key => $value) {
            if (is_array($value)) {
                $attributes[$key] = array_filter($value, function (mixed $value) {
                    return $value !== "__rm__";
                });
            }
        }

        return $attributes;
    }    
}
