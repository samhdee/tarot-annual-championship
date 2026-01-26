<?php

namespace App\Http\Controllers;

use App\Models\Hand;

class PastHandsController extends Controller
{
    public function index()
    {
        return view('past-hands.index', [
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

    public function add()
    {

    }
}
