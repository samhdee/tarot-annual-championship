<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameModel extends Model
{
    use SoftDeletes;

    protected $table = 'games';

    protected $fillable = [
        'hand_id',
        'winner_id',
        'created_at',
        'uptaded_at',
        'deleted_at',
    ];
    protected function casts(): array
    {
        return [
            'created_at' => 'timestamp',
            'uptaded_at' => 'timestamp',
            'deleted_at' => 'timestamp',
        ];
    }

    public function hand(): BelongsTo
    {
        return $this->belongsTo(HandModel::class, 'hand_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(PlayerModel::class);
    }
}
