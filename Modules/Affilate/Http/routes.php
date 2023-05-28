<?php




Route::group(['middleware' => ['web', 'language', 'timezone'], 'prefix' => 'affilate', 'namespace' => 'Modules\Affilate\Http\Controllers'], function () {
 
Route::get(
    '/{business_id}/create',
    'AffilateUserController@create'
);
  Route::post(
    '/store','AffilateUserController@store');
Route::get(
    '/welcome',
    'AffilateUserController@welcome'
);
});


    Route::post('/affilate/register/check-username', 'Modules\Affilate\Http\Controllers\AffilateUserController@postCheckUsername')->name('affilate.postCheckUsername');
    Route::post('/affilate/register/check-email', 'Modules\Affilate\Http\Controllers\AffilateUserController@postCheckEmail')->name('affilate.postCheckEmail');
    
    
Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'affilate', 'namespace' => 'Modules\Affilate\Http\Controllers'], function () {
    Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');
    Route::get('/install/uninstall', 'InstallController@uninstall');
    
    Route::get('/', 'AffilateController@index');
   
    Route::get('/api-settings', 'AffilateController@apiSettings');
    Route::post('/update-api-settings', 'AffilateController@updateSettings');
    Route::get('/sync-categories', 'AffilateController@syncCategories');
    Route::get('/sync-products', 'AffilateController@syncProducts');
    Route::get('/sync-log', 'AffilateController@getSyncLog');
    Route::get('/sync-orders', 'AffilateController@syncOrders');
    Route::post('/map-taxrates', 'AffilateController@mapTaxRates');
    Route::get('/view-sync-log', 'AffilateController@viewSyncLog');
    Route::get('/get-log-details/{id}', 'AffilateController@getLogDetails');
    Route::get('/reset-categories', 'AffilateController@resetCategories');
    Route::get('/reset-products', 'AffilateController@resetProducts');
     Route::get('/balance-log', 'AffilateController@viewbalance');
     
     
     Route::get('/paids-log', 'AffilateController@viewpaids');
     Route::get('/report', 'AffilateController@reports');
     
     Route::get('/affilate-commissions', 'AffilateController@affilate_commissions');
     
     Route::delete('/paid-delete/{id}', 'AffilateController@deletepaid');
     Route::get('/paid-create/', 'AffilateController@createpaid');
     Route::post('/paid-store/', 'AffilateController@storepaid');
     
     
     Route::get('/affilate-products/', 'AffilateUserController@affiliate_products');
     
    Route::get('/home', 'HomeController@index');
    Route::get('/home/get-totals', 'HomeController@getTotals');
    Route::get('/home/sales-payment-dues', 'HomeController@getSalesPaymentDues');
});
