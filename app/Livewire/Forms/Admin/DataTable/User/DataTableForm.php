<?php

declare(strict_types=1);

namespace App\Livewire\Forms\Admin\DataTable\User;

use Livewire\Attributes\Url;
use Illuminate\Validation\Rule;
use App\Filters\User\StatusEmail;
use App\Livewire\Forms\DataTable\DataTableForm as BaseDataTableForm;

final class DataTableForm extends BaseDataTableForm
{
    #[Url(as: 'columns')]
    public array $columns = ['id', 'name', 'email', 'created_at', 'updated_at'];

    #[Url(as: 'status_email')]
    public ?string $status_email = null;

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function rules(): array
    {
        return [
            'status_email' => [
                'bail',
                'string',
                'nullable',
                Rule::in(array_map(fn ($enum) => $enum->value, StatusEmail::cases()))
            ],
            ...parent::rules()
        ];
    }
}
