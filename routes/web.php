<?php

use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::group([

], function () {
    Route::get('/auction/{uuid}', [ExampleController::class, 'index']);
});
