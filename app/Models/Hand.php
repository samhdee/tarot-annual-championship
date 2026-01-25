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

/**
 * @property int $id
 * @property int $meet_id
 * @property int|null $bga_hand_id
 * @property string|null $imported_from
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Game> $games
 * @property-read int|null $games_count
 * @property Collection<int, HandPlayer> $players
 * @property-read int|null $hand_players_count
 * @property-read Meet $meet
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
 * @method static Builder<static>|Hand whereMeetId($value)
 * @method static Builder<static>|Hand whereStartedAt($value)
 * @method static Builder<static>|Hand whereUpdatedAt($value)
 * @method static Builder<static>|Hand withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Hand withoutTrashed()
 * @mixin Eloquent
 */
class Hand extends Model
{
    use SoftDeletes;

    protected $table = 'hands';

    protected $fillable = [
        'meet_id',
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

    public function meet(): BelongsTo
    {
        return $this->belongsTo(Meet::class, 'meet_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(HandPlayer::class, 'hand_id');
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'hand_id');
    }
}
