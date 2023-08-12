<?php

declare(strict_types=1);

namespace App\Utils\Enum;

trait Enum
{
    public function isEquals(self $value): bool
    {
        return $this->value === $value->value;
    }
}
