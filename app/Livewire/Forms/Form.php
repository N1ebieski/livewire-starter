<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Form as BaseForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;

abstract class Form extends BaseForm
{
    protected array $messages = [];

    protected Container $container;

    protected Rule $rule;

    public function __construct(
        protected Component $component,
        protected $propertyName
    ) {
        $this->container = App::make(Container::class);
        $this->rule = App::make(Rule::class);

        /**
         * Fix. Livewire doesn't have access to the component's mount properties,
         * so we have to inject the rules manually in the component
         */
        if ($this->areComponentTypedPropertiesInitiated()) {
            parent::__construct($component, $propertyName);
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

    public function resetExcept(...$properties): void
    {
        if (count($properties) && is_array($properties[0])) {
            $properties = $properties[0];
        }

        $keysToReset = array_diff(array_keys($this->all()), $properties);

        $this->reset($keysToReset);
    }
}
