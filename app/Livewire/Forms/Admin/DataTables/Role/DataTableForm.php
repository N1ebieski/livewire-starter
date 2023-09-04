<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\DataTables\Role;

use Livewire\Attributes\Url;
use App\Livewire\Forms\DataTable\DataTableForm as BaseDataTableForm;

final class DataTableForm extends BaseDataTableForm
{
    #[Url(as: 'columns')]
    public array $columns = ['id', 'name', 'created_at', 'updated_at'];

    public function getColumns(): array
    {
        return $this->columns;
    }
}
