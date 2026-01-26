<?php

namespace App\Http\Controllers;

use App\Models\BgaUser;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $players = BgaUser::query()
            ->select(['id', 'bga_username'])
            ->with([
                'handPlayers:id,bga_user_id',
                'handPlayers.gamePlayers:id,hand_player_id',
            ])
            ->withSum('handPlayers as all_total_points', 'total_points')
            ->orderByDesc('all_total_points')
            ->get();

        return view('home.index', ['players' => $players]);
    }
}
