<?php

declare(strict_types=1);

namespace App\ValueObjects\User;

use App\Support\Enum\Enum;
use App\View\Components\DataTable\Row\Action;

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

    public function getAction(): Action
    {
        return match ($this) {
            self::VERIFIED => Action::SUCCESS,
            self::UNVERIFIED => Action::WARNING
        };
    }
}
