<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {

    $user = \App\Models\User::query()->first();
    //$user->forceWithdraw(200 , ['description' => 'Withdraw from console']);
    dd($user->transactions->toArray());
})->purpose('Display an inspiring quote')->hourly();
