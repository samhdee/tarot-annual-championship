<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GameController extends Controller
{
    /**
     * @param $game_id
     * @return View
     */
    public function index($game_id)
    {
        return view('game.index', ['game' => Game::getGameInfo($game_id)]);
    }
}
