<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as SupportCollection;
use Throwable;

/**
 * @property int $id
 * @property int|null $bga_hand_id
 * @property string|null $imported_from
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property-read Collection<int, HandPlayer> $players
 * @property-read int|null $players_count
 * @method static Builder<static>|Hand newModelQuery()
 * @method static Builder<static>|Hand newQuery()
 * @method static Builder<static>|Hand onlyTrashed()
 * @method static Builder<static>|Hand query()
 * @method static Builder<static>|Hand whereBgaHandId($value)
 * @method static Builder<static>|Hand whereCreatedAt($value)
 * @method static Builder<static>|Hand whereDeletedAt($value)
 * @method static Builder<static>|Hand whereEndedAt($value)
 * @method static Builder<static>|Hand whereId($value)
 * @method static Builder<static>|Hand whereImportedFrom($value)
 * @method static Builder<static>|Hand whereStartedAt($value)
 * @method static Builder<static>|Hand whereUpdatedAt($value)
 * @method static Builder<static>|Hand withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Hand withoutTrashed()
 */
class Hand extends Model
{
    use SoftDeletes;

    protected $table = 'hands';

    public const int NB_PER_PAGE = 30;
    public const string BGA_LINK = 'https://boardgamearena.com/table?table=';

    protected $fillable = [
        'bga_hand_id',
        'imported_from',
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

    public function players(): HasMany
    {
        return $this->hasMany(HandPlayer::class, 'hand_id');
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'hand_id');
    }

    /**
     * @throws Throwable
     */
    public static function getHistory($sort = 'desc')
    {
        return self::query()
            ->select(['id', 'bga_hand_id', 'started_at', 'ended_at'])
            ->with([
                'players:id,hand_id,bga_user_id,total_points',
                'players.bgaUser:id,bga_username',
            ])
            ->orderBy('started_at', $sort)
            ->paginate(self::NB_PER_PAGE);
    }

    /**
     * @return string
     */
    public function getBgaLink(): string
    {
        return $this::BGA_LINK . $this->bga_hand_id;
    }

    /**
     * @param $date
     * @return SupportCollection
     */
    public static function getOneHandGames($date): SupportCollection
    {
        $results = self::query()
            ->select([
                'gp.id', 'gp.game_id', 'gp.hand_player_id', 'gp.bga_bid_id', 'gp.role', 'gp.nb_tricks', 'gp.points',
                'g.contract_points_diff', 'g.started_at', 'g.king_colour', 'g.is_goulash',
            ])
            ->join('games as g', 'g.hand_id', 'hands.id')
            ->join('game_players as gp', 'gp.game_id', 'g.id')
            ->whereDate('hands.started_at', $date)
            ->orderBy('g.started_at')
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
