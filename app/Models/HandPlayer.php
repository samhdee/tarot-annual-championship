<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $bga_user_id
 * @property int $hand_id
 * @property bool|null $is_host
 * @property int $total_points
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read BgaUser $bgaUser
 * @property-read Collection<int, GamePlayer> $gamePlayers
 * @property-read int|null $game_players_count
 * @property-read Hand $hand
 * @method static Builder<static>|HandPlayer newModelQuery()
 * @method static Builder<static>|HandPlayer newQuery()
 * @method static Builder<static>|HandPlayer onlyTrashed()
 * @method static Builder<static>|HandPlayer query()
 * @method static Builder<static>|HandPlayer whereBgaUserId($value)
 * @method static Builder<static>|HandPlayer whereCreatedAt($value)
 * @method static Builder<static>|HandPlayer whereDeletedAt($value)
 * @method static Builder<static>|HandPlayer whereHandId($value)
 * @method static Builder<static>|HandPlayer whereId($value)
 * @method static Builder<static>|HandPlayer whereIsHost($value)
 * @method static Builder<static>|HandPlayer whereTotalPoints($value)
 * @method static Builder<static>|HandPlayer whereUpdatedAt($value)
 * @method static Builder<static>|HandPlayer withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|HandPlayer withoutTrashed()
 * @mixin Eloquent
 */
class HandPlayer extends Model
{
    use SoftDeletes;

    protected $table = 'hand_players';

    protected $fillable = [
        'bga_user_id',
        'hand_id',
        'is_host',
        'total_points',
        'players',
    ];

    protected function casts(): array
    {
        return [
            'is_host' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function bgaUser(): BelongsTo
    {
        return $this->belongsTo(BgaUser::class, 'bga_user_id');
    }

    public function hand(): BelongsTo
    {
        return $this->belongsTo(Hand::class, 'hand_id');
    }

    public function gamePlayers(): HasMany
    {
        return $this->hasMany(GamePlayer::class, 'hand_player_id');
    }
}
