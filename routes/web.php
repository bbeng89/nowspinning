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

Route::get('/home', function()
{
    return 'Welcome!';
})->middleware('auth');

Route::get('/login', function(\Illuminate\Http\Request $request)
{
    $auth = \App::make('App\Services\AuthenticateUser');
    return $auth->execute($request->get('oauth_token', null), $request->get('oauth_verifier', null), $request);
});