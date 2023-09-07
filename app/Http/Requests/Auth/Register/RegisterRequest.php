<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\Register;

use Illuminate\Foundation\Http\FormRequest;

final class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                'alpha_dash',
                'max:255',
                'unique:users,name'
            ],
            'email' => [
                'bail',
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'bail',
                'required',
                'string',
                'min:8',
                'confirmed'
            ],
            'privacy_agreement' => [
                'bail',
                'accepted',
            ],
            'contact_agreement' => [
                'bail',
                'accepted',
            ],
            'marketing_agreement' => [
                'bail',
                'nullable'
            ]
        ];
    }
}
