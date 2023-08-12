<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Tomselect;

use App\Utils\Enum\Enum;

enum Type: string
{
    use Enum;

    case INPUT = 'input';

    case SELECT = 'select';
}
