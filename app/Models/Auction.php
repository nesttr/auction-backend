<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'pigeon_id',
        'start_date',
        'end_date',
    ];

    public function pigeon()
    {
        return $this->hasOne(Pigeon::class, 'id', 'pigeon_id');
    }
}
