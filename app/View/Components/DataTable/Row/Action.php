<?php

declare(strict_types=1);

namespace App\View\Components\DataTable\Row;

enum Action: string
{
    case SUCCESS = "success";

    case WARNING = "warning";

    case PRIMARY = "primary";

    case DANGER = "danger";
}
