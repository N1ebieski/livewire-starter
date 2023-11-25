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

        if (method_exists($this, 'mount')) {
            $this->container->call([$this, 'mount']);
        }
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
}
