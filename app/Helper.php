<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Helper
{
    public static function RegisterNumber(): int
    {
        $timestamp = Carbon::now()->timestamp;
        $time = substr($timestamp,-6);
        return rand(100, 130) . $time . rand(10000, 99999);
    }

    public static function findSlug(string $modelClass, string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        $model =  new $modelClass();
        while ($model::query()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        return $slug;
    }
}
