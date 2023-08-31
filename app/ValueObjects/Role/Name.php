<?php

declare(strict_types=1);

namespace App\ValueObjects\Role;

use App\ValueObjects\ValueObject;

final class Name extends ValueObject
{
    public function __construct(public readonly string $value)
    {
    }

    public function isAdmin(): bool
    {
        foreach ([DefaultName::SUPER_ADMIN, DefaultName::ADMIN] as $name) {
            if ($this->isEquals(new self($name->value))) {
                return true;
            }
        }

        return false;
    }

    public function isDefault(): bool
    {
        foreach (DefaultName::cases() as $name) {
            if ($this->isEquals(new self($name->value))) {
                return true;
            }
        }

        return false;
    }

    public function isEqualsDefault(DefaultName $value): bool
    {
        return $this->value === $value->value;
    }
}
