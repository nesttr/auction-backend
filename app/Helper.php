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
        $time = substr($timestamp, -6);
        return rand(100, 130) . $time . rand(10000, 99999);
    }

    public static function findSlug(string $modelClass, string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;
        $model = new $modelClass();
        while ($model::query()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        return $slug;
    }


    public static function validateAndCalculateValue(int $lastBid, int $newBid, array $rules): void
    {
        $minimumIncrement = self::getMinimumIncrement($rules, $lastBid);

        $realBid = $lastBid + $minimumIncrement;
        if ($newBid >= $realBid ) {
            return;
        }
        throw new InvalidArgumentException("Değer {$realBid}'den buyuk olmalıdır.");
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

    public static function getMinimumIncrement(array $rules, $currentBid)
    {
        foreach ($rules as $rule) {
            [$min, $max, $increment] = $rule; // Decompose the rule
            if ($currentBid >= $min && $currentBid < $max) {
                return $increment;
            }
        }
        return last($rules)[2];
    }
}
