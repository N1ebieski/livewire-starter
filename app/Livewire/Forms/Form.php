<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Form as BaseForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ValidatedInput;
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

    protected Collection $collection;

    //@phpstan-ignore-next-line
    public function __construct(
        protected Component $component,
        protected $propertyName
    ) {
        $this->container = App::make(Container::class);
        $this->rule = App::make(Rule::class);
        $this->guard = App::make(Guard::class);
        $this->gate = App::make(Gate::class);
        $this->config = App::make(Config::class);
        $this->collection = App::make(Collection::class);

        if (method_exists($this, 'mount')) {
            App::call([$this, 'mount']);
        }
    }

    /**
     * Fix. Livewire has method validateOnly but only accepts one field.
     */
    public function validateSpecific(
        string|array $fields,
        array $rules = [],
        array $messages = [],
        array $attributes = []
    ): array {
        $fields = is_string($fields) ? [$fields] : $fields;

        $fields = $this->collection->make($fields)->map(function (string $value) {
            return preg_replace('/^form\./', '', $value);
        })->toArray();

        if (empty($rules)) {
            $rules = $this->collection->make($this->rules())
                ->filter(function (mixed $value, string $key) use ($fields) {
                    return $this->collection->make($fields)->filter(function (string $field) use ($key) {
                        return $field === $key || str_starts_with($key . '.', $field);
                    })->count() > 0;
                })
                ->toArray();
        }

        $validated = !empty($rules) ? $this->validate($rules, $messages, $attributes) : [];

        return $validated;
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

    public function safe(array $keys = null): ValidatedInput|array
    {
        if (is_array($keys)) {
            $keys = $this->collection->make($keys)->map(function (string $value) {
                return preg_replace('/^form\./', '', $value);
            })->toArray();
        }

        $validated = $this->validate($keys);

        $validatedInput = new ValidatedInput($validated);

        return is_array($keys) ? $validatedInput->only($keys) : $validatedInput;
    }

    abstract public function rules(): array;
}
