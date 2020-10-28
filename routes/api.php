<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group([ 'prefix' => 'v1' ], function () {
  Route::post('send-passcode', 'App\Http\Controllers\AuthController@sendPasscode');
  
  Route::post('login', 'App\Http\Controllers\AuthController@login');
  Route::post('register', 'App\Http\Controllers\AuthController@register');

  Route::group([ 'middleware' => 'auth:api' ], function() {
    Route::get('logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('user', 'App\Http\Controllers\AuthController@user');
  });
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
