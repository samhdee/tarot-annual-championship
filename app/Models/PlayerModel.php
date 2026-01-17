<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerModel extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'players';

    protected $fillable = [
        'user_id',
        'game_id',
        'bid_id',
        'has_declared_slam',
        'role',
        'is_dealer',
        'nb_tricks',
        'points',
        'created_at',
        'uptaded_at',
    ];

    protected function casts(): array
    {
        return [
            'has_declared_slam' => 'boolean',
            'is_dealer' => 'boolean',
            'created_at' => 'timestamp',
            'uptaded_at' => 'timestamp',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(GameModel::class, 'game_id');
    }

    public function bid(): BelongsTo
    {
        return $this->belongsTo(BidModel::class, 'bid_id');
    }
}
