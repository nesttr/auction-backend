<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

trait HasUser
{
    public function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id()
        ]) ;
    }
}
