<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostLikeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'api'], function () {
    Route::resource('posts', PostController::class);
    Route::resource('posts/{post}/likes', PostLikeController::class);
});