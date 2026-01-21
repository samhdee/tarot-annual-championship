<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read string|null $username
 * @property-read string|null $name
 * @property-read string|null $email
 * @property-hidden string|null $password
 * @property-read Carbon|null $last_login_at
 * @property-read Carbon $created_at
 * @property-read Carbon|null $updated_at
 * @property-read Carbon|null $deleted_at
 * @method static Builder<static>|UserModel newModelQuery()
 * @method static Builder<static>|UserModel newQuery()
 * @method static Builder<static>|UserModel onlyTrashed()
 * @method static Builder<static>|UserModel query()
 * @method static Builder<static>|UserModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|UserModel withoutTrashed()
 * @mixin Eloquent
 */
class UserModel extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
