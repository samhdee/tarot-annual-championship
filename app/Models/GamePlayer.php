<?php

namespace App\Models;

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
    public static function getPlayersGame($bga_user_id): array
    {
        $results['games'] = self::query()
            ->select([
                'game_players.id', 'game_id', 'hand_player_id', 'bga_bid_id', 'role',
                'nb_tricks', 'points', 'g.contract_points_diff', 'g.started_at', 'g.king_colour',
                'g.is_goulash', DB::raw('DATE_FORMAT(g.started_at, "%Y-%m-%d") as game_started_at'),
            ])
            ->join('hand_players as hp', 'hp.id', 'game_players.hand_player_id')
            ->join('games as g', 'g.id', 'game_players.game_id')
            ->where('hp.bga_user_id', $bga_user_id)
            ->orderByDesc('game_started_at')
            ->orderBy('g.started_at')
            ->get()
            ->keyBy('game_id');

        $results['victories'] = $results['games']->filter(function ($item) {
            return $item->points > 0;
        })->values();

        // dd($results['winning_bids']->toArray());

        foreach ($results['games'] as &$game) {
            $game['other_players'] = self::query()
                ->select(['game_players.id as game_player_id', 'game_players.role', 'game_players.points', 'bu.id as bga_user_id', 'bu.bga_username'])
                ->join('hand_players as hp', 'hp.id', 'game_players.hand_player_id')
                ->join('bga_users as bu', 'bu.id', 'hp.bga_user_id')
                ->where('game_players.id', '!=', $game->id)
                ->where('game_players.game_id', $game->game_id)
                ->orderBy('bga_username')
                ->get();
        }

        return $results;
    }
}
