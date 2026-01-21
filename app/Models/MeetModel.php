<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $started_at
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder<static>|MeetModel newModelQuery()
 * @method static Builder<static>|MeetModel newQuery()
 * @method static Builder<static>|MeetModel onlyTrashed()
 * @method static Builder<static>|MeetModel query()
 * @method static Builder<static>|MeetModel whereCreatedAt($value)
 * @method static Builder<static>|MeetModel whereDeletedAt($value)
 * @method static Builder<static>|MeetModel whereEndedAt($value)
 * @method static Builder<static>|MeetModel whereId($value)
 * @method static Builder<static>|MeetModel whereStartedAt($value)
 * @method static Builder<static>|MeetModel whereUpdatedAt($value)
 * @method static Builder<static>|MeetModel withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|MeetModel withoutTrashed()
 * @mixin Eloquent
 */
class MeetModel extends Model
{
    use SoftDeletes;

    protected $table = 'meets';

    protected $fillable = [
        // @FIXME : Changer le nom de cette colonne
        'started_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
