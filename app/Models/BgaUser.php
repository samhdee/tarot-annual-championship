<?php

namespace App\Models;

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

    public function handPlayersDesc(): HasMany
    {
        return $this->hasMany(HandPlayer::class, 'bga_user_id')
            ->orderByDesc('created_at');
    }

    /**
     * @param $bga_username
     * @return string
     */
    public static function getAvatar($bga_username): string
    {
        return URL::asset(file_exists(public_path("/images/bga_{$bga_username}.jpg"))
            ? "/images/bga_{$bga_username}.jpg"
            : '/images/not_found.png'
        );
    }

    /**
     * @param int $bga_user_id
     * @return array|null
     */
    public static function getPlayerStats(int $bga_user_id): ?BgaUser
    {
        return self::query()
            ->select(['id', 'bga_username'])
            ->with('handPlayersDesc:id,bga_user_id,total_points')
            ->withSum('handPlayers as all_total_points', 'total_points')
            ->where('id', $bga_user_id)
            ->first();
    }
}
