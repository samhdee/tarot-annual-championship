<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $bga_username
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static Builder<static>|BgaUser newModelQuery()
 * @method static Builder<static>|BgaUser newQuery()
 * @method static Builder<static>|BgaUser onlyTrashed()
 * @method static Builder<static>|BgaUser query()
 * @method static Builder<static>|BgaUser whereBgaUsername($value)
 * @method static Builder<static>|BgaUser whereCreatedAt($value)
 * @method static Builder<static>|BgaUser whereDeletedAt($value)
 * @method static Builder<static>|BgaUser whereId($value)
 * @method static Builder<static>|BgaUser whereUpdatedAt($value)
 * @method static Builder<static>|BgaUser whereUserId($value)
 * @method static Builder<static>|BgaUser withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|BgaUser withoutTrashed()
 * @mixin Eloquent
 */
class BgaUser extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $table = 'bga_users';

    protected $fillable = [
        'user_id',
        'bga_username',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
