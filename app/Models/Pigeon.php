<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pigeon extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'mother_name',
        'father_name',
        'color',
        'size',
        'rating',
        'sex',
        'sold',
    ];

    public function images()
    {
        return $this->hasMany(PigeonImage::class, 'pigeon_id', 'id');
    }
}
