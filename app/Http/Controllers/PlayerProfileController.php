<?php

namespace App\Http\Controllers;

use App\Models\BgaUser;

class PlayerProfileController extends Controller
{
    public function index($bga_user_id)
    {
        // dd(BgaUser::getPlayerStats($bga_user_id));
        return view('player.index', [
            'player' => BgaUser::getPlayerStats($bga_user_id),
        ]);
    }
}
