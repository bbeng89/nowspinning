<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user', 'UserController@index')->name('user.index');
Route::post('user/spin', 'UserController@spin')->name('user.spin');
Route::post('user/shelf/add-release', 'UserController@addToShelf')->name('user.addtoshelf');
Route::post('user/shelf/remove-release', 'UserController@removeFromShelf')->name('user.removefromshelf');

Route::get('collection/release/{id}', 'CollectionController@release')->name('collection.release');
Route::get('collection/{username}/{shelf?}', 'CollectionController@shelf')->name('collection.shelf');
Route::get('collection/{username}/shelves/counts', 'CollectionController@shelfCounts')->name('collection.shelf.count');

