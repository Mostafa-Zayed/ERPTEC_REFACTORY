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

Route::group(['middleware' => ['web', 'authh', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'spreadsheet', 'namespace' => '\Modules\Spreadsheet\Http\Controllers'], function () {
	Route::get('get-sheet/{id}/share', 'SpreadsheetController@getShareSpreadsheet');
	Route::post('post-share-sheet', 'SpreadsheetController@postShareSpreadsheet');
	Route::resource('sheets', 'SpreadsheetController')->except(['edit']);
	Route::get('install', 'InstallController@index');
    Route::post('install', 'InstallController@install');
    Route::get('install/uninstall', 'InstallController@uninstall');
    Route::get('install/update', 'InstallController@update');
	Route::post('add-folder', 'SpreadsheetController@addFolder');
	Route::post('move-to-folder', 'SpreadsheetController@moveToFolder');
});