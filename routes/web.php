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

use App\Repositories\Discogs\CollectionRepository;

Route::get('/', 'HomeController@index');

Route::get('/app/{catchall?}', 'AppController@index')
    ->middleware('auth')
    ->where('catchall', '(.*)');

Route::get('/admin/{catchall?}', 'AppController@index')
    ->middleware('auth')
    ->where('catchall', '(.*)');

Route::get('/login', 'Auth\LoginController@login')->name('auth.login');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');