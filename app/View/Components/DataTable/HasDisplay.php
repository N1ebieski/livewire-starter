<?php

declare(strict_types=1);

namespace App\View\Components\DataTable;

/**
 * @property array|null $columns
 * @property array $hidingColumns
 */
trait HasDisplay
{
    public function display(): ?string
    {
        if (is_null($this->columns)) {
            return null;
        }

        if (!in_array($this->name, $this->columns)) {
            return 'd-none';
        }

        if (in_array($this->name, $this->hidingColumns['sm'])) {
            return 'd-md-table-cell d-none';
        }

        if (in_array($this->name, $this->hidingColumns['md'])) {
            return 'd-lg-table-cell d-none';
        }

        if (in_array($this->name, $this->hidingColumns['lg'])) {
            return 'd-xl-table-cell d-none';
        }

        return null;
    }
}
