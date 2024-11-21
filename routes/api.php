<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PigeonController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::group([
    "prefix" => 'auth',
], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::post('profile', [UserProfileController::class, 'store']);
});
Route::group(['prefix' => 'pigeon', 'middleware' => 'auth:api'], function () {
    Route::post('/', [PigeonController::class, 'store']);
});
Route::group(['prefix' => 'news', 'middleware' => 'auth:api'], function () {
    Route::post('/', [NewsController::class, 'store']);
});
Route::group(['prefix' => 'auction', 'middleware' => 'auth:api'], function () {
    Route::post('/', [AuctionController::class, 'store']);
});
