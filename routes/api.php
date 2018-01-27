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

Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('profile/{userid}', 'UserController@getProfile')->name('user.profile');
    Route::post('profile/update', 'UserController@updateProfile')->name('user.profile.update');
    Route::post('spin', 'UserController@spin')->name('user.spin');
    Route::post('sync', 'UserController@sync')->name('user.sync');
});

Route::prefix('collection')->group(function() {
    Route::get('release/{id}', 'CollectionController@release')->name('collection.release');
    Route::get('{username}/{shelf}', 'CollectionController@shelf')->name('collection.shelf');
    Route::get('{username}/shelves/counts', 'CollectionController@shelfCounts')->name('collection.shelf.count');
    Route::post('shelf/add-release', 'CollectionController@addToShelf')->name('collection.shelf.add');
    Route::post('shelf/remove-release', 'CollectionController@removeFromShelf')->name('user.shelf.remove');
});

Route::prefix('posts')->group(function() {
    Route::get('/{feed}', 'PostController@index')->name('posts.index');
    Route::post('create', 'PostController@create')->name('posts.create');
});