<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidModel extends Model
{
    use SoftDeletes;

    protected $table = 'bids';

    protected $fillable = [
        'name',
        'description',
        'function',
        'created_at',
        'uptaded_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'timestamp',
            'uptaded_at' => 'timestamp',
        ];
    }
}
