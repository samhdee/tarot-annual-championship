<?php

namespace App\Http\Controllers;

use App\Models\BgaUser;
use App\Models\Hand;
use App\Models\HandPlayer;
use App\Models\Meet;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index', [
            'hands' => Hand::query()
                ->select(['id', 'bga_hand_id', 'started_at', 'ended_at'])
                ->with([
                    'players:id,hand_id,bga_user_id,total_points',
                    'players.bgaUser:id,bga_username',
                ])
                ->orderByDesc('started_at')
                ->get(),
        ]);
    }
}
