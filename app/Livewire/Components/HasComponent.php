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
     *
     * @param mixed $name
     * @param mixed $value
     * @return void
     */
    public function updatedHasComponent($name, $value): void
    {
        $this->callUpdatedArrayHooks($name);

        /** Temporary fix. Livewire add __rm__ to the array if removing element */
        if ($value === "__rm__") {
            return;
        }

        /** @var Pipeline */
        $pipeline = $this->container->make(Pipeline::class);

        $property = $pipeline->send(new Property($name, $value))
            ->through([
                \App\Livewire\Converts\XSSProtection::class,
                \App\Livewire\Converts\ConvertEmptyStringsToNull::class
            ])
            ->thenReturn();

        data_set($this, $name, $property->value);
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
            $parentAlias = '';

            foreach ($ascendantsNames as $name) {
                if (is_numeric($name)) {
                    break;
                }

                $parentAlias .= $name . '.';
            }

            $parentAlias = mb_substr($parentAlias, 0, -1);

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
