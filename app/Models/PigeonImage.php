<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PigeonImage extends Model
{
    protected $fillable = [
        'pigeon_id',
        'path',
        'family_tree',
    ];
}
