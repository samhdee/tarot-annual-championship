<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $hand_id
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property string|null $king_colour
 * @property int $contract_points_diff
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $players
 * @property-read int|null $game_players_count
 * @property-read \App\Models\Hand $hand
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
 * @method static Builder<static>|Game whereStartedAt($value)
 * @method static Builder<static>|Game whereUpdatedAt($value)
 * @method static Builder<static>|Game withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Game withoutTrashed()
 * @mixin Eloquent
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
}
