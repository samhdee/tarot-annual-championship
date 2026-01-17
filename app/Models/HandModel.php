<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class HandModel extends Model
{
    use SoftDeletes;

    protected $table = 'hands';

    protected $fillable = [
        'started_at',
        'ended_at',
        'tarot_session_id',
        'uptaded_at',
        'deleted_at',
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

    public function tarotSession(): BelongsTo
    {
        return $this->belongsTo(TarotSessionModel::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(PlayerModel::class);
    }
}
