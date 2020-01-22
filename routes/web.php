<?php

use App\Http\Controllers\CheckEmailController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::group(['namespace' => 'App\Http\Controllers'],function(){
    Auth::routes();
});

Route::get('/home', DashboardController::class)->name('dashboard');
Route::get('/checkEmail',CheckEmailController::class);
