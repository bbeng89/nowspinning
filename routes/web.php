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

use App\Repositories\CollectionRepository;

Route::get('/home', function(CollectionRepository $collection)
{
    return view('home', ['collection' => $collection->getAllItemsInUserCollection()]);
})->middleware('auth');

Route::get('/login', 'Auth\LoginController@login')->name('auth.login');
Route::get('/logout', 'Auth\LoginController@logout')->name('auth.logout');