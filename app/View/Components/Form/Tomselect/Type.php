<?php

declare(strict_types=1);

namespace App\View\Components\Form\Tomselect;

final class Type
{
    public const INPUT = 'input';

    public const SELECT = 'select';

    public function __construct(
        public readonly string $value
    ) {
        $this->validate($value);
    }

    private function validate(string $value): void
    {
        if (!in_array($value, $this->getEnums())) {
            throw new \InvalidArgumentException("The given type '{$value}' must be in: " . implode(', ', $this->getEnums()));
        }
    }

    public function isInput(): bool
    {
        return $this->value === self::INPUT;
    }

    public function isSelect(): bool
    {
        return $this->value === self::SELECT;
    }

    public static function input(): self
    {
        return new self(self::INPUT);
    }

    public static function select(): self
    {
        return new self(self::SELECT);
    }

    public function getEnums(): array
    {
        $reflection = new \ReflectionClass(static::class);

        return $reflection->getConstants();
    }    
}