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

Route::post('login', 'App\Http\Controllers\LoginController@login');
Route::post('logout', 'App\Http\Controllers\LoginController@logout');
Route::post('/account_setting/edit_details', 'App\Http\Controllers\UserController@editAccountDetails');
Route::get('/account_setting/edit_details', 'App\Http\Controllers\UserController@editAccountDetails');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/authenticated', function () {
        return true;
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});