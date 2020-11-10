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

// TODO: Fix backend post route not read post request in the frontend
Route::post('login', 'App\Http\Controllers\LoginController@login');
Route::post('logout', 'App\Http\Controllers\LoginController@logout');
Route::resource('/users', App\Http\Controllers\UserController::class);
Route::get('document_type_list', 'App\Http\Controllers\DocumentController@getDocumentTypes');
Route::get('office_list', 'App\Http\Controllers\OfficeController@getOfficeList');
Route::get('get_all_documents', 'App\Http\Controllers\DocumentController@getAllDocuments');
Route::post('add_new_document', 'App\Http\Controllers\DocumentController@addNewDocument');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authenticated', function () {
        return true;
    });
});