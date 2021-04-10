<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', 'App\Http\Controllers\UserController@logout')->name('logout.api');
    Route::get('/user', 'App\Http\Controllers\UserController@userdata')->name('user.api');
});


Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@register');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');
Route::get('/getApi', 'App\Http\Controllers\Auth\LoginController@getApi');