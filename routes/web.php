<?php

use Illuminate\Support\Facades\Route;

Route::group([

], function () {
   Route::get('/',[\App\Http\Controllers\ExampleController::class,'index']);
});
