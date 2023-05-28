<?php

use Modules\Shipment\Entities\Account;
use App\Business;
use Modules\Shipment\Services\ShipmentService;
use Modules\Shipment\Interfaces\ShipmentInterface;


Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone', 'AdminSidebarMenu'], 'prefix' => 'shipment', 'namespace' => 'Modules\Shipment\Http\Controllers', 'as' => 'shipment.'], function () {
    Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');
    Route::get('/install/uninstall', 'InstallController@uninstall');
    
    Route::get('/', 'ShipmentController@index')->name('index');
    
    Route::get('/{id}','ShipmentController@shipmentOrder')->name('order');
    
    // company routes
    Route::get('/company','CompanyController@index')->name('company');
    
    Route::get('/company/create','CompanyController@create')->name('company.create');
    
    Route::get('/accounts','AccountController@index')->name('accounts');
    
    Route::post('/accounts','AccountController@store')->name('accounts.store');
    
    Route::get('/company/add/account/{name}','CompanyController@addAccount')->name('company.addaccount');
    
    Route::get('/company/{id}/accounts','ShipmentController@companyAccounts')->name('company.accounts');
    // Route::post('/company/accounts','ShipmentController@companyAccounts')->name('company.accounts.ajax');
    // Route::get('/order','VooShipmentController@shipmentOrder')->name('send.order');
    // Route::get('/voo','VooShipmentController@index');
    // Route::get('/shipping/details','ShippingDetailsController@index')->name('shipping.details');
    
    
    Route::get('/test',function(){
        $business = request()->session()->get('user.business_id');
        
        $test = Business::find($business);
        dd($test->shipmentCompanies());
        
        return Account::first()->business;
    });
    Route::get('/test2','TestController@index');
    /**
     *  aramx
     */
    Route::get('/aramex','AramexCompanyController@index')->name('aramex.index');
    
    /**
     *  bosta
     */
    Route::get('/bosta','BostaCompanyController@index')->name('bosta.index');
    Route::get('/bosta/cities','BostaCompanyController@getCitites')->name('bosta.cities');
    Route::get('bosta/zones','BostaCompanyController@getZones')->name('bosta.zones');
    Route::get('bosta/deliveries/{id}','BostaCompanyController@deliveries')->name('bosta.deliveries');
    Route::get('bosta/sync','BostaCompanyController@sync')->name('bosta.sync');
    // Route::get('/bosta/orders/{id}/')
    /**
     * xturbo
     */
    Route::get('/xturbo','XturboCompanyController@index')->name('xturbo.index');
    
    /**
     * voo
     */
    Route::get('/voo','VooCompanyController@index')->name('voo.index');
    Route::post('/voo/areas','VooCompanyController@getAreas')->name('voo.areas');
    Route::post('/voo/courier','VooCompanyController@getCourier')->name('voo.courier');
    
    /**
     * fedex express
     */
    Route::get('/fedex-express/','FedexExpressCompanyController@index')->name('fedex-express.index');
    
    /**
     * zones
     */
    Route::resource('zones','ZoneController')->except(['show']);
    Route::get('/zones/city/add','ZoneController@createCityZone')->name('zones.create.city');
    Route::post('/zones/city/add','ZoneController@storeCityZone')->name('zones.store.city');
    Route::post('zones/country/cities','ZoneController@getCountryCities')->name('zones.country.cities');
    Route::post('zones/city/states','ZoneController@getCityStates')->name('zones.city.states');
    // Route::get('zones','ZoneController@index')->name('shipment.zones');
    // Route::get('zones/create','ZoneController@create')->name('shipment.zones.create');
    // Route::post('zones/store','ZoneController@store')->name('shipment.zones.store');
    // Route::delete('zones','ZoneController@destroy')->name('shipment.zones.delete');
    Route::get('zones/price','ZonePriceController@index')->name('zones.price');
    Route::get('zones/price/create','ZonePriceController@create')->name('zones.price.create');
    Route::post('zones/price','ZonePriceController@store')->name('zones.price.store');
    Route::get('zones/price/{id}','ZonePriceController@edit')->name('zones.price.edit');
    Route::post('zones/price/{id}','ZonePriceController@destroy')->name('zones.price.destroy');
    Route::post('/shipcharge','ShipmentController@getShipmentCharge')->name('shipcharge');
    
    Route::get('/{compnay}/send',function($company){
        app()->when(ShipmentService::class)->needs(ShipmentInterface::class)->give(function() use ($company){
            $company = sprintf("Modules\\Shipment\\Companies\\%s",ucfirst($company));
            return new $company;
        });
        
        dd(app(ShipmentService::class));
    });
});
