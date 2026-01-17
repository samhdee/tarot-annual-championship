<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'USER' => ['nullable'],
            'CURRENT_CONNECTIONS' => ['required', 'integer'],
            'TOTAL_CONNECTIONS' => ['required', 'integer'],
            'MAX_SESSION_CONTROLLED_MEMORY' => ['required'],
            'MAX_SESSION_TOTAL_MEMORY' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
