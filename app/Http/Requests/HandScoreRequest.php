<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HandScoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hand_id' => ['nullable', 'exists:hands'],
            'bga_user_id' => ['nullable', 'integer'],
            'total_points' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'date'],
            'uptaded_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
