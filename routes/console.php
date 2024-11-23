<?php

use App\Models\AuctionConfig;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {

//    $user = \App\Models\User::query()->first();
//    //$user->forceWithdraw(200 , ['description' => 'Withdraw from console']);
//    AuctionConfig::query()->create([
//        'additional_time' => 5,
//        'limits' => [
//            [0, 1000, 100],
//            [1001, 2000, 200],
//            [2001, -1, 300],
//        ]
//    ]);

     \Illuminate\Support\Facades\Cache::rememberForever('auction.config' , function(){
         return AuctionConfig::query()->first();
     });
})->purpose('Display an inspiring quote')->hourly();
