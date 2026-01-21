<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $hand_id
 * @property string $king_colour
 * @property int $contract_points_diff
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read HandModel $hand
 * @method static Builder<static>|GameModel newModelQuery()
 * @method static Builder<static>|GameModel newQuery()
 * @method static Builder<static>|GameModel onlyTrashed()
 * @method static Builder<static>|GameModel query()
 * @method static Builder<static>|GameModel whereCreatedAt($value)
 * @method static Builder<static>|GameModel whereDeletedAt($value)
 * @method static Builder<static>|GameModel whereHandId($value)
 * @method static Builder<static>|GameModel whereId($value)
 * @method static Builder<static>|GameModel whereKingColour($value)
 * @method static Builder<static>|GameModel whereUpdatedAt($value)
 * @method static Builder<static>|GameModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|GameModel withoutTrashed()
 * @mixin Eloquent
 */
class GameModel extends Model
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
        return $this->belongsTo(HandModel::class, 'hand_id');
    }
}
