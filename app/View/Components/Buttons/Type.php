<?php

declare(strict_types=1);

namespace App\View\Components\Buttons;

use App\Utils\Enum\Enum;

enum Type: string
{
    use Enum;

    case BUTTON = 'button';

    case SUBMIT = 'submit';

    case A = 'a';

    public function getElement(): string
    {
        return match ($this) {
            self::SUBMIT => 'button',
            default => $this->value
        };
    }
}
