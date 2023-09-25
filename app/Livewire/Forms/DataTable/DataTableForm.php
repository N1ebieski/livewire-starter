<?php

declare(strict_types=1);

namespace App\Livewire\Forms\DataTable;

use App\Livewire\Forms\Form;
use Livewire\Attributes\Url;
use App\Support\Query\Sorts\SortsHelper;
use App\Livewire\Components\DataTable\DataTableInterface;

/**
 * @property-read DataTableInterface $component
 */
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

    public function rules(): array
    {
        return [
            'search' => [
                'bail',
                'nullable',
                'string',
                'max:255'
            ],
            'orderby' => [
                'bail',
                'string',
                'nullable',
                $this->rule->in(SortsHelper::getAttributesWithOrder($this->component->sorts))
            ],
            'columns' => [
                'bail',
                'array',
                'nullable',
            ],
            'columns.*' => [
                'bail',
                'string',
                'nullable',
                $this->rule->in($this->component->showingColumns)
            ],
            'paginate' => [
                'bail',
                'nullable',
                'integer',
                $this->rule->in($this->component->availablePaginates)
            ]
        ];
    }
}
