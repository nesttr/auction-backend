<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use InvalidArgumentException;

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

    /**
     * @param int $value
     * @param array $thresholds
     * @return void
     */
    public static function validateAndCalculateValue(int $value, array $thresholds):void
    {
        foreach ($thresholds as $range) {
            [$min, $max, $increment] = $range;
            if ($value >= $min && ($max == -1 || $value <= $max)) {
                if ($value % $increment !== 0) {
                    throw new InvalidArgumentException("Değer {$increment}'un katı olmalıdır.");
                }
                return;
            }
        }
        throw new InvalidArgumentException("Değer geçersiz.");
    }

    public static function validateDateTime($startDateTime, $endDateTime): true
    {
        $input = Carbon::now();
        if ($input->lt($startDateTime)) {
            throw new InvalidArgumentException("Hata: Tarih ve saat başlangıç tarihinden küçük olamaz.");
        }
        if ($input->gt($endDateTime)) {
            throw new InvalidArgumentException("Hata: Tarih ve saat bitiş tarihinden büyük olamaz.");
        }

        return true;
    }
}
