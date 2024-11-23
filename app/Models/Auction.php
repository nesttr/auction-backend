<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = [
        'uuid',
        'user_id',
        'start_bid',
        'pigeon_id',
        'start_date',
        'end_date',
    ];
    protected function casts()
    {
        return [
          'start_date' => 'datetime',
          'end_date' => 'datetime'
        ];
    }

    public function pigeon()
    {
        return $this->hasOne(Pigeon::class, 'id', 'pigeon_id');
    }
}
