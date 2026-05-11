<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property int $hand_id
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property string|null $king_colour
 * @property boolean $is_goulash
 * @property int $contract_points_diff
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Hand $hand
 * @property-read Collection<int, GamePlayer> $players
 * @property-read int|null $players_count
 * @method static Builder<static>|Game newModelQuery()
 * @method static Builder<static>|Game newQuery()
 * @method static Builder<static>|Game onlyTrashed()
 * @method static Builder<static>|Game query()
 * @method static Builder<static>|Game whereContractPointsDiff($value)
 * @method static Builder<static>|Game whereCreatedAt($value)
 * @method static Builder<static>|Game whereDeletedAt($value)
 * @method static Builder<static>|Game whereEndedAt($value)
 * @method static Builder<static>|Game whereHandId($value)
 * @method static Builder<static>|Game whereId($value)
 * @method static Builder<static>|Game whereKingColour($value)
 * @method static Builder<static>|Game whereIsGoulash($value)
 * @method static Builder<static>|Game whereStartedAt($value)
 * @method static Builder<static>|Game whereUpdatedAt($value)
 * @method static Builder<static>|Game withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Game withoutTrashed()
 */
class Game extends Model
{
    use SoftDeletes;

    protected $table = 'games';

    protected $fillable = [
        'hand_id',
        'king_colour',
        'contract_points_diff',
        'started_at',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function hand(): BelongsTo
    {
        return $this->belongsTo(Hand::class, 'hand_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(GamePlayer::class, 'game_id');
    }

    public function playersByOrder(): HasMany
    {
        return $this->hasMany(GamePlayer::class, 'game_id')->orderBy('order');
    }

    /**
     * @param int $game_id
     * @return Game
     */
    public static function getGameInfo(int $game_id): Game
    {
        return self::query()
            ->select([
                'id', 'king_colour', 'contract_points_diff', 'started_at', 'is_goulash',
                DB::raw('DATE_FORMAT(started_at, "%Y-%m-%d") as game_date'),
            ])
            ->with('playersByOrder:id,game_id,hand_player_id,role,nb_tricks,points')
            ->with('playersByOrder.handPlayer.bgaUser:id,bga_username')
            ->where('id', $game_id)
            ->orderBy('started_at')
            ->first();
    }

    /**
     * @param int $player_id
     * @param string $date
     * @return SupportCollection
     */
    public static function getPlayerGamesByDate(int $player_id, string $date): SupportCollection
    {
        $results = self::query()
            ->select([
                'gp.id', 'gp.game_id', 'gp.hand_player_id', 'gp.bga_bid_id', 'gp.role', 'gp.nb_tricks', 'gp.points',
                'games.contract_points_diff', 'games.started_at', 'games.king_colour', 'games.is_goulash',
            ])
            ->join('game_players as gp', 'gp.game_id', 'games.id')
            ->join('hand_players as hp', 'hp.id', 'gp.hand_player_id')
            ->whereDate('games.started_at', $date)
            ->where('hp.bga_user_id', $player_id)
            ->orderBy('games.started_at')
            ->get();

        /** @var GamePlayer $game */
        foreach ($results as &$game) {
            $game['other_players'] = GamePlayer::query()
                ->select([
                    'game_players.id as game_player_id', 'game_players.role', 'game_players.points',
                    'bu.id as bga_user_id', 'bu.bga_username'
                ])
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
