<?php

declare(strict_types=1);

namespace App\Console\Forms\User;

use App\Models\User\User;
use App\Console\Forms\Form;
use App\ValueObjects\Role\DefaultName;
use Illuminate\Contracts\Database\Eloquent\Builder;

final class SuperAdminForm extends Form
{
    public function __construct(private User $user)
    {
    }

    public function authorize(): bool
    {
        return $this->user->whereHas('roles', function (Builder $query) {
            return $query->where('name', DefaultName::SUPER_ADMIN);
        })->count() === 0;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'alpha_dash',
                'min:3',
                'max:255'
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
            ],
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ]
        ];
    }
}
