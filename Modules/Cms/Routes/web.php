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
Route::get('/', 'CmsController@index')->name('welcome');
Route::get('/{lang}','CmsController@index')->name('welcome.lang');
Route::get('c/page/{page}', 'CmsPageController@showPage');
Route::get('c/blogs', 'CmsController@getBlogList');
Route::get('c/blog/{slug}-{id}', 'CmsController@viewBlog');
Route::get('c/contact-us', 'CmsController@contactUs')->name('cms.contact.us');
Route::post('c/submit-contact-form', 'CmsController@postContactForm')->name('cms.submit.contact.form');

Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu', 'superadmin'], 'prefix' => 'cms', 'namespace' => '\Modules\Cms\Http\Controllers'], function () {

    Route::get('install', 'InstallController@index');
    Route::post('install', 'InstallController@install');
    Route::get('install/uninstall', 'InstallController@uninstall');
    Route::get('install/update', 'InstallController@update');
    
    Route::resource('cms-page', 'CmsPageController')->except(['show']);
    Route::resource('site-details', 'SettingsController');
});
