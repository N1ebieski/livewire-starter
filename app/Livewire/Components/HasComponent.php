<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Support\Str;
use App\Livewire\Forms\Form;
use Livewire\Attributes\Computed;
use App\Livewire\Converts\Property;
use Illuminate\Contracts\Auth\Guard;
use App\Support\Livewire\LivewireHelper;
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

    private LivewireHelper $livewireHelper;

    private Gate $gate;

    private Guard $guard;

    private Str $str;

    public function bootHasComponent(
        Container $container,
        ViewFactory $viewFactory,
        LivewireHelper $livewireHelper,
        Gate $gate,
        Guard $guard,
        Str $str
    ): void {
        $this->container = $container;
        $this->viewFactory = $viewFactory;
        $this->livewireHelper = $livewireHelper;
        $this->gate = $gate;
        $this->guard = $guard;
        $this->str = $str;
    }

    #[Computed()]
    public function alias(): string
    {
        return $this->livewireHelper->getAlias($this::class);
    }

    /**
     * @param array $attributes
     * @return array
     */
    protected function prepareForValidation($attributes): array
    {
        $attributes = $this->unwrapDataForValidation($attributes);

        if (
            array_key_exists('form', $attributes)
            && property_exists($this, 'form')
            && method_exists($this->form, 'prepareForValidation')
        ) {
            $attributes['form'] = $this->form->prepareForValidation($attributes['form']);
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

        $this->callUpdatedArrayHooks($name);
    }

    /**
     * Fix. Livewire has method validateOnly but only accepts one field.
     *
     * @param mixed $fields
     * @param mixed $rules
     * @param array $messages
     * @param array $attributes
     * @param array $dataOverrides
     * @return array
     */
    public function validateOnly(
        $fields,
        $rules = null,
        $messages = [],
        $attributes = [],
        $dataOverrides = []
    ): array {
        $fields = is_array($fields) ? $fields : [$fields];

        $validated = [];

        $validateOnly = function ($field, $rules, $messages, $attributes, $dataOverrides) use (&$validated, &$validateOnly) {
            $validatedData = parent::validateOnly($field, $rules, $messages, $attributes);

            $value = data_get($this, $field, false);

            if ($value && is_array($value)) {
                foreach (array_keys(array_filter($value)) as $key) {
                    $validateOnly("{$field}.{$key}", $rules, $messages, $attributes, $dataOverrides);
                }
            }

            $validated[key($validatedData)] = current($validatedData);
        };

        foreach ($fields as $field) {
            $validateOnly($field, $rules, $messages, $attributes, $dataOverrides);
        }

        return $validated;
    }

    /**
     * Fix for Livewire 3.0. Livewire doesn't call array property updated hook.
     * For example if user updates $columns[3] = 'something',
     * Livewire calls only a updatedColumns3 method, instead a updatedColumns.
     */
    private function callUpdatedArrayHooks(string $name): void
    {
        $ascendantsNames = explode('.', $name);

        if (count($ascendantsNames) > 1) {
            $parentAlias = implode('.', array_slice($ascendantsNames, 0, -1));

            $parent = data_get($this, $parentAlias);

            if (is_array($parent)) {
                $parentName = $this->str->of($parentAlias)->replace('.', '_')->camel()->ucfirst();

                $methodName = 'updated' . $parentName;

                $callback = [$this, $methodName];

                if (is_callable($callback) && method_exists(...$callback)) {
                    call_user_func($callback, $parent);
                }
            }
        }
    }
}
