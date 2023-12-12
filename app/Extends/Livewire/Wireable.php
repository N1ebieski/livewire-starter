<?php

declare(strict_types=1);

namespace App\Extends\Livewire;

use Livewire\Wireable as LivewireWireable;

//TODO: #10 Move this class to livewire-starter and refactor \App\Livewire\Components\Modal\Modal
abstract class Wireable implements LivewireWireable
{
    /**
     * @return static|null
     */
    public static function tryFromLivewire(mixed $data)
    {
        return is_array($data) ? static::fromLivewire($data) : null;
    }

    public function toLivewire(): array
    {
        $array = get_object_vars($this);

        return array_map(function ($value) {
            if ($value instanceof Wireable) {
                return $value->toLivewire();
            }

            return $value;
        }, $array);
    }

    /**
     * @return static
     */
    public static function fromLivewire($data)
    {
        return new static(...$data);
    }
}
