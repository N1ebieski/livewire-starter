<?php

declare(strict_types=1);

namespace App\Support\Query\Columns;

use Illuminate\Support\Collection;

final class ColumnsHelper
{
    public static function getColumnsAsString(array $columns): string
    {
        return (new Collection($columns))
            ->map(fn ($column) => '`' . $column . '`')
            ->implode(',');
    }
}
