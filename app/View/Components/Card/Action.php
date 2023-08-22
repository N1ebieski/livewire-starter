<?php

declare(strict_types=1);

namespace App\View\Components\Card;

enum Action: string
{
    case PRIMARY = 'primary';

    case SECONDARY = 'secondary';

    case SUCCESS = 'success';

    case DANGER = 'danger';

    case WARNING = 'warning';

    case INFO = 'info';

    case LIGHT = 'light';

    case DARK = 'dark';
}
