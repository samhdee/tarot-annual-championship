<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GamePlayerScoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'game_id' => ['required', 'exists:games'],
            'hand_player_id' => ['required', 'exists:hand_players'],
            'order' => ['required', 'integer'],
            'bid_id' => ['required', 'exists:bids'],
            'role' => ['required'],
            'has_declared_slam' => ['nullable', 'boolean'],
            'nb_tricks' => ['required', 'integer'],
            'points' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
