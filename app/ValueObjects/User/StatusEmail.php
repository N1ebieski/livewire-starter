<?php

declare(strict_types=1);

namespace App\ValueObjects\User;

use App\Support\Enum\Enum;

enum StatusEmail: string
{
    use Enum;

    case VERIFIED = 'verified';

    case UNVERIFIED = 'unverified';

    public function getAsBool(): bool
    {
        return match ($this) {
            self::VERIFIED => true,
            self::UNVERIFIED => false
        };
    }

    public function toggle(): self
    {
        return match ($this) {
            self::VERIFIED => self::UNVERIFIED,
            self::UNVERIFIED => self::VERIFIED
        };
    }

    public function getAction(): string
    {
        return match ($this) {
            self::VERIFIED => 'success',
            self::UNVERIFIED => 'warning'
        };
    }
}
