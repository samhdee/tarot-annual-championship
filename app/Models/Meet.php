<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $started_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Hand> $hands
 * @property-read int|null $hands_count
 * @method static Builder<static>|Meet newModelQuery()
 * @method static Builder<static>|Meet newQuery()
 * @method static Builder<static>|Meet onlyTrashed()
 * @method static Builder<static>|Meet query()
 * @method static Builder<static>|Meet whereCreatedAt($value)
 * @method static Builder<static>|Meet whereDeletedAt($value)
 * @method static Builder<static>|Meet whereId($value)
 * @method static Builder<static>|Meet whereStartedAt($value)
 * @method static Builder<static>|Meet whereUpdatedAt($value)
 * @method static Builder<static>|Meet withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Meet withoutTrashed()
 * @mixin Eloquent
 */
class Meet extends Model
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

    public function hands(): HasMany
    {
        return $this->hasMany(Hand::class, 'meet_id');
    }
}
