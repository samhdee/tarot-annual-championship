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
 * @property string $bga_username
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read UserModel|null $user
 * @method static Builder<static>|BgaUserModel newModelQuery()
 * @method static Builder<static>|BgaUserModel newQuery()
 * @method static Builder<static>|BgaUserModel query()
 * @method static Builder<static>|BgaUserModel whereBgaUsername($value)
 * @method static Builder<static>|BgaUserModel whereCreatedAt($value)
 * @method static Builder<static>|BgaUserModel whereDeletedAt($value)
 * @method static Builder<static>|BgaUserModel whereId($value)
 * @method static Builder<static>|BgaUserModel whereUpdatedAt($value)
 * @method static Builder<static>|BgaUserModel whereUserId($value)
 * @mixin Eloquent
 */
class BgaUserModel extends Model
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
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
