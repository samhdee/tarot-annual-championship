<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BgaUserModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:user_models'],
            'bga_username' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
