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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prifex('v1/')->group(function(){
    
//     Route::get('/country','CountryController@index');
// });

Route::group([],function(){
    
    Route::get('/country','CountryController@index')->name('api.country');
    // Route::get('/business','BusinessController@index')->name('api.business');
});



Route::post('/business','BusinessController@index')->name('api.business');
Route::apiResource('/products','ProductController');