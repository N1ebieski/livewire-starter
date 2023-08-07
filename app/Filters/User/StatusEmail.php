<?php

declare(strict_types=1);

namespace App\Filters\User;

enum StatusEmail: string
{
    case VERIFIED = 'verified';

    case UNVERIFIED = 'unverified';

    public function getAsBool(): bool
    {
        return match ($this) {
            self::VERIFIED => true,
            self::UNVERIFIED => false
        };
    }
}
