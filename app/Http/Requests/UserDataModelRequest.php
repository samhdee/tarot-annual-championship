<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDataModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:user_models'],
            'bga_username' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
