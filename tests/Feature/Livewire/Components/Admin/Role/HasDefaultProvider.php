<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Components\Admin\Role;

use Illuminate\Support\Collection;
use App\ValueObjects\Role\DefaultName;

trait HasDefaultProvider
{
    public static function defaultProvider(): array
    {
        return Collection::make(DefaultName::cases())
            ->mapWithKeys(function (DefaultName $name) {
                return [$name->value => [$name]];
            })
            ->toArray();
    }
}
