<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Livewire\Attributes\Locked;
use Livewire\Features\SupportAttributes\Attribute;
use Livewire\Features\SupportAttributes\AttributeCollection;

/**
 * Trait to check if any specific property is dirty
 *
 * @property AttributeCollection $attributes
 */
trait HasDirty
{
    #[Locked]
    public bool $isDirty = false;

    private function isPropertyLocked(string $name): bool
    {
        return $this->attributes->contains(function (Attribute $attribute) use ($name) {
            return $attribute instanceof Locked && $attribute->getName() === $name;
        });
    }

    protected function isDirty(mixed ...$properties): bool
    {
        if (isset($properties[0]) && is_array($properties[0]) && !isset($properties[1])) {
            $properties = $properties[0];
        }

        //@phpstan-ignore-next-line
        $freshInstance = new static();

        foreach ($properties as $property) {
            if ($this->isPropertyLocked($property)) {
                continue;
            }

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
