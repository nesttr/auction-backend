<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;

class Helper
{
    public static function RegisterNumber(): int
    {
        $timestamp = Carbon::now()->timestamp;
        $time = substr($timestamp,-6);
        return rand(100, 130) . $time . rand(10000, 99999);
    }
}
