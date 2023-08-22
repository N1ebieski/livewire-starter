<?php

declare(strict_types=1);

namespace App\Http\Requests;

final class PageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => [
                'bail',
                'nullable',
                'integer'
            ]
        ];
    }
}
