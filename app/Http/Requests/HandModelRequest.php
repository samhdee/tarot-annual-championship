<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'tarot_session_id' => ['nullable', 'integer'],
            'uptaded_at' => ['required', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
