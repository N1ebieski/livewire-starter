<?php

declare(strict_types=1);

namespace App\View\Components\Buttons;

use App\Utils\Enum\Enum;

enum Type: string
{
    use Enum;

    case BUTTON = 'button';

    case A = 'a';
}
