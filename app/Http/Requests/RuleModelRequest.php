<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuleModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'description' => ['nullable'],
            'function' => ['nullable'],
            'uptaded_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
