<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarotSessionModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'started_at',
        'ended_at',
        'host_id',
        'uptaded_at',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'timestamp',
            'ended_at' => 'timestamp',
            'created_at' => 'timestamp',
            'uptaded_at' => 'timestamp',
        ];
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(PlayerModel::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(PlayerModel::class);
    }
}
