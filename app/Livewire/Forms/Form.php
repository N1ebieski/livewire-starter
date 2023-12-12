<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\Form as BaseForm;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
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
        $this->container = App::make(Container::class);
        $this->rule = App::make(Rule::class);
        $this->guard = App::make(Guard::class);
        $this->gate = App::make(Gate::class);
        $this->config = App::make(Config::class);

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

        $fields = (new Collection($fields))->map(function (string $value) {
            return preg_replace('/^form\./', '', $value);
        })->toArray();

        if (empty($rules)) {
            $rules = (new Collection($this->rules()))
                ->filter(function (mixed $value, string $key) use ($fields) {
                    return (new Collection($fields))->filter(function (string $field) use ($key) {
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

    abstract public function rules(): array;
}
