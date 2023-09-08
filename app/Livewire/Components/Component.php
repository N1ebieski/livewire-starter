<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Component as BaseComponent;
use App\Extends\Illuminate\Contracts\Auth\Guard;

/**
 * @property-read Guard $guard
 */
abstract class Component extends BaseComponent
{
}
