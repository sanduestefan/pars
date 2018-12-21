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
//Auth::routes();
//Route::get('login', 'Auth\LoginController')->name('login');
Route::get('users/{id}', 'UserController@show');
Route::post('users/{id}/buy', 'UserController@postBuy');
Route::post('users/{id}/battle', 'UserController@postBattle');
Route::get('users/{id}/users', 'UserController@getIndex');
Route::delete('users/{id}/items/{itemId}', 'UserController@delete');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
//
});
