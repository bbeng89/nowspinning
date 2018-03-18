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
    Route::get('search', 'UserController@search')->name('user.search');
    Route::get('{username}', 'UserController@find')->name('user.find');
    Route::get('{username}/friends', 'UserController@friends')->name('user.friends');

    Route::post('profile/update', 'UserController@updateProfile')->name('user.profile.update');
    Route::post('profile/add-image', 'UserController@uploadProfileImage')->name('user.profile.addimage');
    Route::post('profile/remove-image', 'UserController@deleteProfileImage')->name('user.profile.removeimage');
    Route::post('first-login/unset', 'UserController@unsetFirstLogin')->name('user.first-login.unset');
    Route::post('spin', 'UserController@spin')->name('user.spin');
    Route::post('sync', 'UserController@sync')->name('user.sync');
    Route::post('follow', 'UserController@follow')->name('user.follow');
    Route::post('unfollow', 'UserController@unfollow')->name('user.unfollow');
});

Route::prefix('collection')->group(function() {
    Route::get('release/{id}', 'CollectionController@release')->name('collection.release');
    Route::get('{username}/{shelf}', 'CollectionController@shelf')->name('collection.shelf');
    Route::get('{username}/shelves/counts', 'CollectionController@shelfCounts')->name('collection.shelf.count');
    Route::post('shelf/add-release', 'CollectionController@addToShelf')->name('collection.shelf.add');
    Route::post('shelf/remove-release', 'CollectionController@removeFromShelf')->name('user.shelf.remove');
});

Route::prefix('posts')->group(function() {
    Route::get('/{feed}', 'PostController@index')->name('posts.index')->where(['feed' => 'friends|global']);
    Route::post('create', 'PostController@create')->name('posts.create');
    Route::post('create/image', 'PostController@uploadPostImage')->name('posts.create.image');
    Route::patch('/{id}', 'PostController@update')->name('posts.update');
    Route::delete('delete/{id}', 'PostController@delete')->name('posts.delete');
});