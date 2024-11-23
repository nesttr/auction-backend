<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionConfig extends Model
{
    protected $fillable = [
        'limits',
        'additional_time',
    ];
    protected function casts()
    {
        return [
            'limits' =>'array'
        ];
    }
}
