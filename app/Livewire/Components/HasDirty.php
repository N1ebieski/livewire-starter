<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\Locked;

/**
 * Trait to check if any specific property is dirty
 */
trait HasDirty
{
    #[Locked]
    public bool $isDirty = false;

    protected function isDirty(mixed ...$properties): bool
    {
        if (isset($properties[0]) && is_array($properties[0]) && !isset($properties[1])) {
            $properties = $properties[0];
        }

        //@phpstan-ignore-next-line
        $freshInstance = new static();

        foreach ($properties as $property) {
            if (data_get($this, $property) !== data_get($freshInstance, $property)) {
                return true;
            }
        }

        return false;
    }

    protected function dirty(): void
    {
        $this->isDirty = false;

        if ($this->arePropertiesDirty()) {
            $this->isDirty = true;
        }
    }

    abstract protected function arePropertiesDirty(): bool;
}
