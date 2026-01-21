<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'created_at' => ['required', 'date'],
            'updated_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
