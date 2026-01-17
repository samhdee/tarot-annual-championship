<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hand_id' => ['nullable', 'exists:hands'],
            'winning_bid_id' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'date'],
            'uptaded_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
