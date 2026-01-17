<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RuleModel extends Model
{
    use SoftDeletes;

    protected $table = 'rules';

    protected $fillable = [
        'name',
        'description',
        'function',
        'uptaded_at',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'timestamp',
            'uptaded_at' => 'timestamp',
        ];
    }
}
