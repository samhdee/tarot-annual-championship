<?php

namespace App\Http\Controllers;

use App\Enums\BGABids;
use App\Enums\PlayerRoles;
use App\Models\BgaUser;
use App\Models\Game;
use App\Models\GamePlayer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

        // Dates des manches
        $data['hands_dates'] = $data['game_players']->groupBy('game_started_at')->keys();

        // Graph Évolution scores
        $data['stats_scores'] = $this->getPointsEvolutionStats($data);

        // Graph WR par enchère
        $data['stats_takes'] = $this->getBidWRStats($data);

        // Graph WR par partenaire
        $data['stats_partners'] = $this->getPartnerWRStats($data, $bga_user_id);

        return view('player.index', $data);
    }

    public function history($player_id, $game_date)
    {
        return view('player.history', ['hand' => Game::getPlayerGamesByDate($player_id, $game_date)]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getPointsEvolutionStats(array $data): array
    {
        $start = Carbon::parse($data['hands_dates']->last());
        $end = Carbon::parse($data['hands_dates']->first());
        $months = CarbonPeriod::create($start, '1 month', $end);
        $period = collect($months)->map(fn($date) => $date->format('Y-m'))->toArray();

        foreach ($period as $month) {
            $games = $data['game_players']->filter(function ($item) use ($month) {
                return str_starts_with($item->game_started_at, $month);
            });

            $stats_scores['labels'][] = ucfirst(Carbon::parse($month)->translatedFormat('F'));
            $stats_scores['values'][] = $games->isNotEmpty()
                ? number_format($games->pluck('points')->sum() / $games->count(), 2)
                : 0;
        }

        return $stats_scores;
    }

    /**
     * @param array $data
     * @return array
     */
    public function getBidWRStats(array $data): array
    {
        $count_garde = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE->value;
        })->count();
        $count_garde_sans = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE_SANS->value;
        })->count();
        $count_garde_contre = $data['game_players']->filter(function ($item) {
            return $item->bga_bid_id == BGABids::GARDE_CONTRE->value;
        })->count();

        // @FIXME : Supprimer enchère si aucune stat
        // @FIXME : Quid de quelqu'un qui n'a jamais pris ?
        return [
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
    }

    /**
     * @param array $data
     * @param int $bga_user_id
     * @return array
     */
    private function getPartnerWRStats(array $data, int $bga_user_id): array
    {
        // @FIXME : Quid de quelqu'un qui n'a jamais pris ?
        $all_partners = GamePlayer::getPlayerAllPartners($data['takes']->pluck('game_id')->toArray(), $bga_user_id);

        foreach ($all_partners->pluck('bga_username')->unique()->toArray() as $username) {
            $partner_games_count = $all_partners->filter(function ($item) use ($username) {
                return $item->bga_username === $username;
            })->count();
            if (!empty($partner_games_count)) {
                $stats_partner['values'][$username] = number_format(100 * $all_partners->filter(function ($item) use ($username) {
                        return intval($item->points) > 0 && $item->bga_username === $username;
                    })->count() / $partner_games_count, 2);
            } else {
                $stats_partner['values'][$username] = 0;
            }
        }

        $stats_partner['labels'] = array_keys($stats_partner['values']);
        sort($stats_partner['labels']);
        return $stats_partner;
    }
}
