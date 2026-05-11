<?php

namespace App\Models;

use App\Enums\BGABids;
use App\Enums\PlayerRoles;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $game_id
 * @property int $hand_player_id
 * @property int|null $order
 * @property string|null $bga_bid_id
 * @property string|null $role
 * @property bool $has_declared_slam
 * @property string|null $misere
 * @property string|null $poignee_type
 * @property int|null $poignee_nb_atouts
 * @property int $nb_tricks
 * @property int $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Game $game
 * @property-read HandPlayer $handPlayer
 * @method static Builder<static>|GamePlayer newModelQuery()
 * @method static Builder<static>|GamePlayer newQuery()
 * @method static Builder<static>|GamePlayer onlyTrashed()
 * @method static Builder<static>|GamePlayer query()
 * @method static Builder<static>|GamePlayer whereBgaBidId($value)
 * @method static Builder<static>|GamePlayer whereCreatedAt($value)
 * @method static Builder<static>|GamePlayer whereDeletedAt($value)
 * @method static Builder<static>|GamePlayer whereGameId($value)
 * @method static Builder<static>|GamePlayer whereHandPlayerId($value)
 * @method static Builder<static>|GamePlayer whereHasDeclaredSlam($value)
 * @method static Builder<static>|GamePlayer whereId($value)
 * @method static Builder<static>|GamePlayer whereMisere($value)
 * @method static Builder<static>|GamePlayer whereNbTricks($value)
 * @method static Builder<static>|GamePlayer whereOrder($value)
 * @method static Builder<static>|GamePlayer wherePoigneeNbAtouts($value)
 * @method static Builder<static>|GamePlayer wherePoigneeType($value)
 * @method static Builder<static>|GamePlayer wherePoints($value)
 * @method static Builder<static>|GamePlayer whereRole($value)
 * @method static Builder<static>|GamePlayer whereUpdatedAt($value)
 * @method static Builder<static>|GamePlayer withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|GamePlayer withoutTrashed()
 */
class GamePlayer extends Model
{
    use SoftDeletes;

    protected $table = 'game_players';

    protected $fillable = [
        'game_id',
        'hand_player_id',
        'order',
        'bga_bid_id',
        'role',
        'has_declared_slam',
        'misere',
        'poignee_type',
        'poignee_nb_atouts',
        'nb_tricks',
        'points',
    ];

    protected function casts(): array
    {
        return [
            'has_declared_slam' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function handPlayer(): BelongsTo
    {
        return $this->belongsTo(HandPlayer::class, 'hand_player_id');
    }

    /**
     * @param $bga_user_id
     * @return array
     */
    public static function getPlayerGames($bga_user_id): array
    {
        $results['game_players'] = self::query()
            ->select([
                'game_players.id', 'game_id', 'hand_player_id', 'bga_bid_id', 'role',
                'points', 'g.contract_points_diff', 'g.started_at', 'g.is_goulash',
                DB::raw('DATE_FORMAT(g.started_at, "%Y-%m-%d") as game_started_at'),
            ])
            ->join('hand_players as hp', 'hp.id', 'game_players.hand_player_id')
            ->join('games as g', 'g.id', 'game_players.game_id')
            ->where('hp.bga_user_id', $bga_user_id)
            ->orderByDesc('game_started_at')
            ->orderBy('g.started_at')
            ->get()
            ->keyBy('game_id');

        $results['victories'] = $results['game_players']->filter(function ($item) {
            return $item->points > 0;
        })->values();

        $results['takes'] = $results['game_players']->filter(function ($item) {
            return $item->role === PlayerRoles::taker->name;
        })->values();

        $results['successful_takes'] = $results['game_players']->filter(function ($item) {
            return $item->role === PlayerRoles::taker->name && $item->points > 0;
        })->values();
        $results['stats_takes'] = [
            'labels' => ['Garde', 'Garde sans', 'Garde contre'],
            'values' => [
                number_format(100 *
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE->value && $item->points > 0;
                    })->count() /
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE->value;
                    })->count(),
                    2
                ),
                number_format(100 *
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE_SANS->value && $item->points > 0;
                    })->count() /
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE_SANS->value;
                    })->count(),
                    2
                ),
                number_format(100 *
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE_CONTRE->value && $item->points > 0;
                    })->count() /
                    $results['game_players']->filter(function ($item) {
                        return $item->bga_bid_id == BGABids::GARDE_CONTRE->value;
                    })->count(),
                    2
                ),
            ],
        ];

        return $results;
    }
}
