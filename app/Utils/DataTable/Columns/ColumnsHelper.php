<?php

declare(strict_types=1);

namespace App\Utils\DataTable\Columns;

use Illuminate\Support\Collection;

class ColumnsHelper
{
    public function getColumnsAsString(array $columns): string
    {
        return (new Collection($columns))
            ->map(fn ($column) => '`' . $column . '`')
            ->implode(',');
    }
}
