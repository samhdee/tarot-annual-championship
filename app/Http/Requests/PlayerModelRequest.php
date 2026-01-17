<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerModelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:user_models'],
            'game_id' => ['nullable', 'exists:games'],
            'bid_id' => ['nullable', 'exists:bids'],
            'has_declared_slam' => ['nullable', 'boolean'],
            'role' => ['nullable'],
            'is_dealer' => ['nullable', 'boolean'],
            'nb_tricks' => ['nullable', 'integer'],
            'points' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'date'],
            'uptaded_at' => ['nullable', 'date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
