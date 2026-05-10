<?php

namespace App\Http\Controllers;

use App\Models\BgaUser;
use App\Models\Hand;

class PlayerProfileController extends Controller
{
    public function index($bga_user_id)
    {
        // dd(BgaUser::getPlayerStats($bga_user_id));
        return view('player.index', [
            'player' => BgaUser::getPlayerStats($bga_user_id),
        ]);
    }

    public function history($game_date)
    {
        return view('player.history', ['hand' => Hand::getOneHandGames($game_date)]);
    }
}
