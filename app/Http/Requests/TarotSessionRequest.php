<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarotSessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'host_id' => ['nullable', 'integer'],
            'uptaded_at' => ['required', 'date'],
            'user_model_id' => ['nullable', 'exists:user_models'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
