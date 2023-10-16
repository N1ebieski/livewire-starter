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
        $target->{$key} = $value;
    }
}
