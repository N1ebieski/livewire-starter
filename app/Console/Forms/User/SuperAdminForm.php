<?php

declare(strict_types=1);

namespace App\Console\Forms\User;

use App\Models\User\User;
use App\Console\Forms\Form;
use App\ValueObjects\Role\Name;
use Illuminate\Contracts\Database\Eloquent\Builder;

class SuperAdminForm extends Form
{
    public function __construct(private User $user)
    {
    }

    public function authorize(): bool
    {
        return $this->user->whereHas('roles', function (Builder $query) {
            return $query->where('name', Name::SUPER_ADMIN);
        })->count() === 0;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                'alpha_dash',
                'max:255'
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'confirmed'
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
