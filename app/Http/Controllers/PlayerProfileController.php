<?php

namespace App\Http\Controllers;

use App\Enums\BGABids;
use App\Enums\PlayerRoles;
use App\Models\BgaUser;
use App\Models\Game;
use App\Models\GamePlayer;

class PlayerProfileController extends Controller
{
    public function index($bga_user_id)
    {
        $data['hands'] = BgaUser::getPlayerStats($bga_user_id);
        $data['game_players'] = GamePlayer::getPlayerGames($bga_user_id);

        $data['victories'] = $data['game_players']->filter(function ($item) {
            return $item->points > 0;
        })->values();

        $data['takes'] = $data['game_players']->filter(function ($item) {
            return $item->role === PlayerRoles::taker->name;
        })->values();

        $data['successful_takes'] = $data['game_players']->filter(function ($item) {
            return $item->role === PlayerRoles::taker->name && $item->points > 0;
        })->values();

        // Graph WR par enchère
        $count_garde = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE->value;
        })->count();
        $count_garde_sans = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE_SANS->value;
        })->count();
        $count_garde_contre = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE_CONTRE->value;
        })->count();

        $data['stats_takes'] = [
            'labels' => ['Garde', 'Garde sans', 'Garde contre'],
            'values' => [
                !empty($count_garde)
                    ? number_format(100 *
                        $data['game_players']->filter(function ($item) {
                            return $item->bga_bid_id == BGABids::GARDE->value && $item->points > 0;
                        })->count() / $count_garde, 2)
                    : 0,
                !empty($count_garde_sans)
                    ? number_format(100 *
                        $data['game_players']->filter(function ($item) {
                            return $item->bga_bid_id == BGABids::GARDE_SANS->value && $item->points > 0;
                        })->count() / $count_garde_sans, 2)
                    : 0,
                !empty($count_garde_contre)
                    ? number_format(100 *
                        $data['game_players']->filter(function ($item) {
                            return $item->bga_bid_id == BGABids::GARDE_CONTRE->value && $item->points > 0;
                        })->count() / $count_garde_contre, 2)
                    : 0,
            ],
        ];

        // Graph WR par partenaire
        $all_partners = GamePlayer::getPlayerAllPartners($data['takes']->pluck('game_id')->toArray(), $bga_user_id);

        foreach ($all_partners->pluck('bga_username')->unique()->toArray() as $username) {
            $partner_games_count = $all_partners->filter(function ($item) use ($username) {
                return $item->bga_username === $username;
            })->count();
            if (!empty($partner_games_count)) {
                $data['stats_partners']['values'][$username] = number_format(100 * $all_partners->filter(function ($item) use ($username) {
                        return intval($item->points) > 0 && $item->bga_username === $username;
                    })->count() / $partner_games_count, 2);
            } else {
                $data['stats_partners']['values'][$username] = 0;
            }
        }

        $data['stats_partners']['labels'] = array_keys($data['stats_partners']['values']);
        sort($data['stats_partners']['labels']);

        // dd(BgaUser::getPlayerStats($bga_user_id));
        return view('player.index', $data);
    }

    public function history($player_id, $game_date)
    {
        return view('player.history', ['hand' => Game::getPlayerGamesByDate($player_id, $game_date)]);
    }
}
