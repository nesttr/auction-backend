<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PigeonSize implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $colors = \App\PigeonSize::values();
        if( !in_array($value , $colors)){
            $fail("The :attribute is invalid.");
        }
//        if (strlen($value) != 11 || !ctype_digit($value)) {
//            $fail("The :attribute must be 11 digits.");
//        }
//
//        $digits = str_split($value);
//        $sumOdd = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8];
//        $sumEven = $digits[1] + $digits[3] + $digits[5] + $digits[7];
//        $sumAll = array_sum(array_slice($digits, 0, 10));
//
//        if (($sumOdd * 7 - $sumEven) % 10 != $digits[9] || $sumAll % 10 != $digits[10]) {
//            $fail("The :attribute is invalid.");
//        }
    }
}
