<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth\Login;

use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
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
            'redirect' => [
                'bail',
                'nullable',
                'string',
                'regex:/\/\/([\da-z\.-]+)(\.[a-z]{2,6})/'
            ]
        ];
    }
}
