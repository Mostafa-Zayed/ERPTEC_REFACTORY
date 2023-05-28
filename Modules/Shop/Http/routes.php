<?php

Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'shop', 'as' => 'shop.','namespace' => 'Modules\Shop\Http\Controllers'], function () {
    Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');
    Route::get('/install/uninstall', 'InstallController@uninstall');
    
    
    /*
    * general routes
    */
    Route::get('/', 'ShopController@index')->name('index');
    Route::get('/settings','ShopController@settings')->name('settings');
    Route::get('/sync','ShopController@sync')->name('sync');
    
    Route::post('/settings','ShopController@storeSettings')->name('settings.store');
    // Route::get('/test','ShopController@connection')->name('shop.testing');
    // Route::get('/languages','ShopController@getLanguages')->name('shop.languages');
    Route::get('/cities','ShopController@getCities')->name('shop.cities');
    // Route::get('/states','ShopController@getStates')->name('shop.states');
    // Route::get('/countries','ShopController@getCountries')->name('shop.countries');
    // Route::get('/details/{id}','ShopController@getStoreDetails')->name('shop.store.details');
    // Route::get('sync/variation-templates','SyncController@variationTemplates')->name('sync.variation-templates');
    // // Route::get('sync/variation-templates/delete','SyncController@deleteVariationTemplates')->name('sync.variation-templates.delete');
    
    // Route::get('sync/categories','SyncController@categories')->name('sync.categories');
    // Route::get('sync/brands','SyncController@brands')->name('sync.brands');
    // Route::get('/api-settings', 'WoocommerceController@apiSettings');
    // Route::post('/update-api-settings', 'WoocommerceController@updateSettings');
    // Route::get('/sync-categories', 'WoocommerceController@syncCategories');
    // Route::get('/sync-products', 'WoocommerceController@syncProducts');
    // Route::get('/sync-log', 'WoocommerceController@getSyncLog');
    // Route::get('/sync-orders', 'WoocommerceController@syncOrders');
    // Route::post('/map-taxrates', 'WoocommerceController@mapTaxRates');
    // Route::get('/view-sync-log', 'WoocommerceController@viewSyncLog');
    // Route::get('/get-log-details/{id}', 'WoocommerceController@getLogDetails');
    // Route::get('/reset-categories', 'WoocommerceController@resetCategories');
    // Route::get('/reset-products', 'WoocommerceController@resetProducts');
    
    /*
    * categories
    */
    Route::get('/sync/categories','CategoryController@syncCategories');
    Route::get('/sync/categories/new','CategoryController@syncNewCategories');
    Route::get('/sync/categories/update','CategoryController@updateCategories');
    /*
    * variations
    */
    
    /*
    * brands
    */
    Route::get('/sync/brands/new','BrandController@syncNewBrands')->name('sync.new.brands');
    
    /*
    * products
    */
    Route::get('/sync/products/new','ProductController@syncNewProducts')->name('sync.new.products');
});
