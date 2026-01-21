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
 * @property int $meet_id
 * @property int|null $bga_hand_id
 * @property string|null $imported_from
 * @property Carbon|null $started_at
 * @property Carbon|null $ended_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read MeetModel $meet
 * @method static Builder<static>|HandModel newModelQuery()
 * @method static Builder<static>|HandModel newQuery()
 * @method static Builder<static>|HandModel onlyTrashed()
 * @method static Builder<static>|HandModel query()
 * @method static Builder<static>|HandModel whereBgaGameId($value)
 * @method static Builder<static>|HandModel whereCreatedAt($value)
 * @method static Builder<static>|HandModel whereDeletedAt($value)
 * @method static Builder<static>|HandModel whereEndedAt($value)
 * @method static Builder<static>|HandModel whereId($value)
 * @method static Builder<static>|HandModel whereImportedFrom($value)
 * @method static Builder<static>|HandModel whereMeetId($value)
 * @method static Builder<static>|HandModel whereStartedAt($value)
 * @method static Builder<static>|HandModel whereUpdatedAt($value)
 * @method static Builder<static>|HandModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|HandModel withoutTrashed()
 * @mixin Eloquent
 */
class HandModel extends Model
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
        return $this->belongsTo(MeetModel::class, 'meet_id');
    }
}
