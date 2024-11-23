<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutomaticBid extends Model
{
    protected $fillable = [
        'auction_id',
        'user_id',
        'bid',
    ];
}
