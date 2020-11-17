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
Route::get('auth_user', 'App\Http\Controllers\UserController@getAuthUser');
Route::get('all_users', 'App\Http\Controllers\UserController@getAllUsers');
Route::put('update_user/{id}', 'App\Http\Controllers\UserController@updateUser');
Route::get('document_type_list', 'App\Http\Controllers\DocumentController@getDocumentTypes');
Route::get('office_list', 'App\Http\Controllers\OfficeController@getOfficeList');
Route::get('get_active_documents', 'App\Http\Controllers\DocumentController@getAllActiveDocuments');
Route::get('get_non_page_active_documents', 'App\Http\Controllers\DocumentController@getNonPaginatedActiveDocuments');
Route::post('add_new_document', 'App\Http\Controllers\DocumentController@addNewDocument');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/authenticated', function () {
        return true;
    });
});