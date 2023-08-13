<?php

declare(strict_types=1);

namespace App\View\Components\Buttons;

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

    case OUTLINE_PRIMARY = 'outline-primary';

    case OUTLINE_SECONDARY = 'outline-secondary';

    case OUTLINE_SUCCESS = 'outline-success';

    case OUTLINE_DANGER = 'outline-danger';

    case OUTLINE_WARNING = 'outline-warning';

    case OUTLINE_INFO = 'outline-info';

    case OUTLINE_LIGHT = 'outline-light';

    case OUTLINE_DARK = 'outline-dark';
}
