<?php

declare(strict_types=1);

namespace App\Extends\Livewire\Features\SupportWireables;

use App\Extends\Livewire\Wireable;
use Livewire\Features\SupportWireables\WireableSynth as BaseWireableSynth;

final class WireableSynth extends BaseWireableSynth
{
    //phpcs:ignore
    static function match($target)
    {
        return is_object($target) && $target instanceof Wireable;
    }

    public function set(&$target, $key, $value)
    {
        $setterName = 'set' . ucfirst($key);

        if (method_exists($target, $setterName)) {
            call_user_func([$target, $setterName], $value);
        } else {
            $target->{$key} = $value;
        }
    }

    public function unset(&$target, $key)
    {
        $target->{$key} = null;
    }

    public function hydrate($value, $meta, $hydrateChild)
    {
        /** Temporary fix for Livewire */
        if ($value !== "__rm__") {
            return parent::hydrate($value, $meta, $hydrateChild);
        }
    }
}
