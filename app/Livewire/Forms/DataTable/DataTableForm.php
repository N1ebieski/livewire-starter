<?php

declare(strict_types=1);

namespace App\Livewire\Forms\DataTable;

use App\Livewire\Forms\Form;
use Livewire\Attributes\Url;

abstract class DataTableForm extends Form
{
    #[Url(as: 'orderby')]
    public ?string $orderby = null;

    #[Url(as: 'paginate')]
    public int $paginate = 25;

    #[Url(as: 'columns')]
    public array $columns = [];

    #[Url(as: 'search')]
    public ?string $search = null;

    abstract public function getColumns(): array;
}
