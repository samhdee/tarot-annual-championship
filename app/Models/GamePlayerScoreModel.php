<?php

namespace App\Models;

use App\Enums\BGABids;
use App\Enums\Miseres;
use App\Enums\Poignees;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property GameModel|null $game_id
 * @property HandPlayerModel $hand_player_id
 * @property int|null $order
 * @property BGABids|null $bga_bid_id
 * @property string|null $role
 * @property bool|null $has_declared_slam
 * @property Miseres|null $misere
 * @property Poignees|null $poignee_type
 * @property int|null $poignee_nb_atouts
 * @property int $nb_tricks
 * @property int|null $points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read GameModel|null $game
 * @property-read HandPlayerModel|null $player
 * @method static Builder<static>|GamePlayerScoreModel newModelQuery()
 * @method static Builder<static>|GamePlayerScoreModel newQuery()
 * @method static Builder<static>|GamePlayerScoreModel onlyTrashed()
 * @method static Builder<static>|GamePlayerScoreModel query()
 * @method static Builder<static>|GamePlayerScoreModel whereBidId($value)
 * @method static Builder<static>|GamePlayerScoreModel whereCreatedAt($value)
 * @method static Builder<static>|GamePlayerScoreModel whereDeletedAt($value)
 * @method static Builder<static>|GamePlayerScoreModel whereGameId($value)
 * @method static Builder<static>|GamePlayerScoreModel whereHasDeclaredSlam($value)
 * @method static Builder<static>|GamePlayerScoreModel whereId($value)
 * @method static Builder<static>|GamePlayerScoreModel whereNbTricks($value)
 * @method static Builder<static>|GamePlayerScoreModel whereOrder($value)
 * @method static Builder<static>|GamePlayerScoreModel wherePlayerId($value)
 * @method static Builder<static>|GamePlayerScoreModel wherePoints($value)
 * @method static Builder<static>|GamePlayerScoreModel whereRole($value)
 * @method static Builder<static>|GamePlayerScoreModel whereUpdatedAt($value)
 * @method static Builder<static>|GamePlayerScoreModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|GamePlayerScoreModel withoutTrashed()
 * @mixin Eloquent
 */
class GamePlayerScoreModel extends Model
{
    use SoftDeletes;

    protected $table = 'game_player_scores';

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
        return $this->belongsTo(GameModel::class, 'game_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(HandPlayerModel::class, 'hand_player_id');
    }
}
