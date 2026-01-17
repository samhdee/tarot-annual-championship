<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable'],
            'created_at' => ['nullable', 'date'],
            'uptaded_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
