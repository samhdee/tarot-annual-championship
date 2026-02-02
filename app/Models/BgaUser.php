<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use URL;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $bga_username
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property bool $is_admin
 * @property-read Collection<int, HandPlayer> $handPlayers
 * @property-read int|null $hand_players_count
 * @property-read User|null $user
 * @method static Builder<static>|BgaUser newModelQuery()
 * @method static Builder<static>|BgaUser newQuery()
 * @method static Builder<static>|BgaUser onlyTrashed()
 * @method static Builder<static>|BgaUser query()
 * @method static Builder<static>|BgaUser whereBgaUsername($value)
 * @method static Builder<static>|BgaUser whereCreatedAt($value)
 * @method static Builder<static>|BgaUser whereDeletedAt($value)
 * @method static Builder<static>|BgaUser whereId($value)
 * @method static Builder<static>|BgaUser whereIsAdmin($value)
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
        'is_admin',
    ];

    protected function casts(): array
    {
        return [
            'is_admin' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function handPlayers(): HasMany
    {
        return $this->hasMany(HandPlayer::class, 'bga_user_id');
    }

    public function getAvatar(): string
    {
        if (file_exists(public_path("/images/bga_{$this->bga_username}.jpg"))) {
            return URL::asset("/images/bga_{$this->bga_username}.jpg");
        } else {
            return URL::asset('/images/not_found.png');
        }
    }
}
