<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function(){
    dd(\Socialite::driver('discogs')->user());
});

Route::get('/login', function(){
    return \Socialite::driver('discogs')->redirect();
});

Route::get('/home', function(){
    dd(\Socialite::driver('discogs')->user());
});