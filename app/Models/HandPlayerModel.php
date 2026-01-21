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
 * @property bool|null $is_host
 * @property int|null $total_points
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read BgaUserModel $bgaUser
 * @property-read HandModel $hand
 * @method static Builder<static>|HandPlayerModel newModelQuery()
 * @method static Builder<static>|HandPlayerModel newQuery()
 * @method static Builder<static>|HandPlayerModel onlyTrashed()
 * @method static Builder<static>|HandPlayerModel query()
 * @method static Builder<static>|HandPlayerModel whereBgaUserId($value)
 * @method static Builder<static>|HandPlayerModel whereCreatedAt($value)
 * @method static Builder<static>|HandPlayerModel whereDeletedAt($value)
 * @method static Builder<static>|HandPlayerModel whereHandId($value)
 * @method static Builder<static>|HandPlayerModel whereId($value)
 * @method static Builder<static>|HandPlayerModel whereIsHost($value)
 * @method static Builder<static>|HandPlayerModel whereTotalPoints($value)
 * @method static Builder<static>|HandPlayerModel whereUptadedAt($value)
 * @method static Builder<static>|HandPlayerModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|HandPlayerModel withoutTrashed()
 * @mixin Eloquent
 */
class HandPlayerModel extends Model
{
    use SoftDeletes;

    protected $table = 'hand_players';

    protected $fillable = [
        'bga_user_id',
        'hand_id',
        'is_host',
        'total_points',
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
        return $this->belongsTo(BgaUserModel::class, 'bga_user_id');
    }

    public function hand(): BelongsTo
    {
        return $this->belongsTo(HandModel::class, 'hand_id');
    }
}
