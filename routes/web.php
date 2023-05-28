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

include_once('install_r.php');

use Illuminate\Support\Facades\App;

Route::middleware(['authh'])->group(function(){
    Route::get('/cache/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        return redirect()->route('home')->with('cache',__("lang_v1.system_cache_has_been_removed"));
    })->name('cache-clear');
    
    Route::get('/connector/docs', function () {
        return view('docs');
    });
});

Route::middleware(['setData','allow.register','allow.login'])->group(function () {
    // Route::get('/', function () {
        
    //     // App::setLocale($lang);
    //     return view('welcome');
    // })->name('welcome');

    Auth::routes();
    
    // Route::get('pipeline',PipeLineController::class);
    
    Route::get('/business/register', 'BusinessController@getRegister')->name('business.getRegister');
    Route::post('/business/register', 'BusinessController@postRegister')->name('business.postRegister');
    Route::post('/business/register/check-username', 'BusinessController@postCheckUsername')->name('business.postCheckUsername');
    Route::post('/business/register/check-email', 'BusinessController@postCheckEmail')->name('business.postCheckEmail');
    
    // new
    Route::get('/register','BusinessController@register')->name('register');
    Route::post('/register','BusinessController@storeBusiness')->name('add-new_business');
    //
    Route::get('/invoice/{token}', 'SellPosController@showInvoice')
        ->name('show_invoice');
    Route::get('/quote/{token}', 'SellPosController@showInvoice')
        ->name('show_quote');
});

//Routes for authenticated users only
Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home2/{lang}', 'HomeController@setHomeLang')->name('home.lang');
    Route::get('/home/get-totals', 'HomeController@getTotals');
    Route::get('/home/product-stock-alert', 'HomeController@getProductStockAlert');
    Route::get('/home/purchase-payment-dues', 'HomeController@getPurchasePaymentDues');
    Route::get('/home/sales-payment-dues', 'HomeController@getSalesPaymentDues');
    Route::post('/attach-medias-to-model', 'HomeController@attachMediasToGivenModel')->name('attach.medias.to.model');
    Route::get('/calendar', 'HomeController@getCalendar')->name('calendar');
    
    Route::post('/test-email', 'BusinessController@testEmailConfiguration');
    Route::post('/test-sms', 'BusinessController@testSmsConfiguration');
    Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
    Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');
    Route::get('/user/profile', 'UserController@getProfile')->name('user.getProfile');
    Route::post('/user/update', 'UserController@updateProfile')->name('user.updateProfile');
    Route::post('/user/update-password', 'UserController@updatePassword')->name('user.updatePassword');

    Route::resource('brands', 'BrandController');
    
    // new
    Route::get('/brands2','BrandController2@index')->name('brands2.index');
    Route::resource('payment-account', 'PaymentAccountController');

    Route::resource('tax-rates', 'TaxRateController');

    Route::resource('units', 'UnitController');
    // ahah
    Route::get('/contacts/payments/{contact_id}', 'ContactController@getContactPayments');
    Route::get('/contacts/map', 'ContactController@contactMap');
    Route::get('/contacts/update-status/{id}', 'ContactController@updateStatus');
    Route::get('/contacts/stock-report/{supplier_id}', 'ContactController@getSupplierStockReport');
    Route::get('/contacts/ledger', 'ContactController@getLedger');
    Route::post('/contacts/send-ledger', 'ContactController@sendLedger');
    Route::get('/contacts/import', 'ContactController@getImportContacts')->name('contacts.import');
    Route::post('/contacts/import', 'ContactController@postImportContacts');
    Route::post('/contacts/check-contact-id', 'ContactController@checkContactId');
    Route::get('/contacts/customers', 'ContactController@getCustomers');
    Route::resource('contacts', 'ContactController');

    Route::get('taxonomies-ajax-index-page', 'TaxonomyController@getTaxonomyIndexPage');
    Route::resource('taxonomies', 'TaxonomyController');
//    Route::get('variation-templates/index2','VariationTemplateController@index2');__("messages.something_went_wrong")
    Route::resource('variation-templates', 'VariationTemplateController');
//    Route::get('variation-templates/index2','VariationTemplateController@index2');
    Route::get('/products/stock-history/{id}', 'ProductController@productStockHistory');
    Route::get('/delete-media/{media_id}', 'ProductController@deleteMedia');
    Route::post('/products/mass-deactivate', 'ProductController@massDeactivate');
    Route::get('/products/activate/{id}', 'ProductController@activate');
    Route::get('/products/view-product-group-price/{id}', 'ProductController@viewGroupPrice');
    Route::get('/products/add-selling-prices/{id}', 'ProductController@addSellingPrices');
    Route::post('/products/save-selling-prices', 'ProductController@saveSellingPrices');
    Route::post('/products/mass-delete', 'ProductController@massDestroy');
    Route::get('/products/view/{id}', 'ProductController@view');
    Route::get('/products/list', 'ProductController@getProducts');
    Route::get('/products/list-no-variation', 'ProductController@getProductsWithoutVariations');
    Route::post('/products/bulk-edit', 'ProductController@bulkEdit');
    Route::post('/products/bulk-update', 'ProductController@bulkUpdate');
    Route::post('/products/bulk-update-location', 'ProductController@updateProductLocation');
    Route::get('/products/get-product-to-edit/{product_id}', 'ProductController@getProductToEdit');
    
    Route::post('/products/get_sub_categories', 'ProductController@getSubCategories');
    Route::get('/products/get_sub_units', 'ProductController@getSubUnits');
    Route::post('/products/product_form_part', 'ProductController@getProductVariationFormPart');
    Route::post('/products/get_product_variation_row', 'ProductController@getProductVariationRow');
    Route::post('/products/get_variation_template', 'ProductController@getVariationTemplate');
    Route::get('/products/get_variation_value_row', 'ProductController@getVariationValueRow');
    Route::post('/products/check_product_sku', 'ProductController@checkProductSku');
    Route::get('/products/quick_add', 'ProductController@quickAdd');
    Route::post('/products/save_quick_product', 'ProductController@saveQuickProduct');
    Route::get('/products/get-combo-product-entry-row', 'ProductController@getComboProductEntryRow');
    
    Route::resource('products', 'ProductController');
    // Route::get('products/delete/{id}','ProductController@destroy')->name('products.destroy');
    
    Route::post('/purchases/update-status', 'PurchaseController@updateStatus');
    Route::get('/purchases/get_products', 'PurchaseController@getProducts');
    Route::get('/purchases/get_suppliers', 'PurchaseController@getSuppliers');
    Route::post('/purchases/get_purchase_entry_row', 'PurchaseController@getPurchaseEntryRow');
    Route::post('/purchases/check_ref_number', 'PurchaseController@checkRefNumber');
    Route::resource('purchases', 'PurchaseController')->except(['show']);



    Route::get('/aramex','AramexController@index')    ;
    Route::get('/toggle-subscription/{id}', 'SellPosController@toggleRecurringInvoices');
    Route::post('/sells/pos/get-types-of-service-details', 'SellPosController@getTypesOfServiceDetails');
    Route::get('/sells/subscriptions', 'SellPosController@listSubscriptions');
    Route::get('/sells/duplicate/{id}', 'SellController@duplicateSell');
    Route::get('/sells/drafts', 'SellController@getDrafts');
    Route::get('/sells/convert-to-draft/{id}', 'SellPosController@convertToInvoice');
    Route::get('/sells/convert-to-proforma/{id}', 'SellPosController@convertToProforma');
    Route::get('/sells/quotations', 'SellController@getQuotations');
    Route::get('/sells/draft-dt', 'SellController@getDraftDatables');
    Route::resource('sells', 'SellController')->except(['show']);

    Route::get('/import-sales', 'ImportSalesController@index');
    Route::post('/import-sales/preview', 'ImportSalesController@preview');
    Route::post('/import-sales', 'ImportSalesController@import');
    Route::get('/revert-sale-import/{batch}', 'ImportSalesController@revertSaleImport');

    Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', 'SellPosController@getProductRow');
    Route::post('/sells/pos/get_payment_row', 'SellPosController@getPaymentRow');
    Route::post('/sells/pos/get-reward-details', 'SellPosController@getRewardDetails');
    Route::get('/sells/pos/get-recent-transactions', 'SellPosController@getRecentTransactions');
    Route::get('/sells/pos/get-product-suggestion', 'SellPosController@getProductSuggestion');
    Route::get('/sells/pos/get-featured-products/{location_id}', 'SellPosController@getFeaturedProducts');
    
    Route::get('order/shipment',function(){
        dd('order/shipment');
    });
    
    Route::resource('pos', 'SellPosController');

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'ManageUserController');

    Route::resource('group-taxes', 'GroupTaxController');
    
    Route::resource('tags', 'TagController');
    
    Route::get('/barcodes/set_default/{id}', 'BarcodeController@setDefault');
    Route::resource('barcodes', 'BarcodeController');

    //Invoice schemes..
    Route::get('/invoice-schemes/set_default/{id}', 'InvoiceSchemeController@setDefault');
    Route::resource('invoice-schemes', 'InvoiceSchemeController');
    
    // Invoice schemes new
    Route::get('/invoices/schemes','InvoiceSchemeController2@index')->name('invoice.schemes');
    //Print Labels
    Route::get('/labels/show', 'LabelsController@show');
    Route::get('/labels/add-product-row', 'LabelsController@addProductRow');
    Route::get('/labels/preview', 'LabelsController@preview');

    //Reports...
    Route::get('/reports/purchase-report', 'ReportController@purchaseReport');
    Route::get('/reports/sale-report', 'ReportController@saleReport');
    Route::get('/reports/service-staff-report', 'ReportController@getServiceStaffReport');
    Route::get('/reports/service-staff-line-orders', 'ReportController@serviceStaffLineOrders');
    Route::get('/reports/table-report', 'ReportController@getTableReport');
    Route::get('/reports/profit-loss', 'ReportController@getProfitLoss');
    Route::get('/reports/get-opening-stock', 'ReportController@getOpeningStock');
    Route::get('/reports/purchase-sell', 'ReportController@getPurchaseSell');
    Route::get('/reports/customer-supplier', 'ReportController@getCustomerSuppliers');
    Route::get('/reports/stock-report', 'ReportController@getStockReport');
    Route::get('/reports/stock-details', 'ReportController@getStockDetails');
    Route::get('/reports/tax-report', 'ReportController@getTaxReport');
    Route::get('/reports/tax-details', 'ReportController@getTaxDetails');
    Route::get('/reports/trending-products', 'ReportController@getTrendingProducts');
    Route::get('/reports/expense-report', 'ReportController@getExpenseReport');
    Route::get('/reports/stock-adjustment-report', 'ReportController@getStockAdjustmentReport');
    Route::get('/reports/register-report', 'ReportController@getRegisterReport');
    Route::get('/reports/sales-representative-report', 'ReportController@getSalesRepresentativeReport');
    Route::get('/reports/sales-representative-total-expense', 'ReportController@getSalesRepresentativeTotalExpense');
    Route::get('/reports/sales-representative-total-sell', 'ReportController@getSalesRepresentativeTotalSell');
    Route::get('/reports/sales-representative-total-commission', 'ReportController@getSalesRepresentativeTotalCommission');
    Route::get('/reports/stock-expiry', 'ReportController@getStockExpiryReport');
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', 'ReportController@getStockExpiryReportEditModal');
    Route::post('/reports/stock-expiry-update', 'ReportController@updateStockExpiryReport')->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', 'ReportController@getCustomerGroup');
    Route::get('/reports/product-purchase-report', 'ReportController@getproductPurchaseReport');
    Route::get('/reports/product-sell-report', 'ReportController@getproductSellReport');
    Route::get('/reports/product-sell-report-with-purchase', 'ReportController@getproductSellReportWithPurchase');
    Route::get('/reports/product-sell-grouped-report', 'ReportController@getproductSellGroupedReport');
    Route::get('/reports/lot-report', 'ReportController@getLotReport');
    Route::get('/reports/purchase-payment-report', 'ReportController@purchasePaymentReport');
    Route::get('/reports/sell-payment-report', 'ReportController@sellPaymentReport');
    Route::get('/reports/product-stock-details', 'ReportController@productStockDetails');
    Route::get('/reports/adjust-product-stock', 'ReportController@adjustProductStock');
    Route::get('/reports/get-profit/{by?}', 'ReportController@getProfit');
    Route::get('/reports/items-report', 'ReportController@itemsReport');
    Route::get('/reports/get-stock-value', 'ReportController@getStockValue');
    
    Route::get('business-location/activate-deactivate/{location_id}', 'BusinessLocationController@activateDeactivateLocation');

    //Business Location Settings...
    Route::prefix('business-location/{location_id}')->name('location.')->group(function () {
        Route::get('settings', 'LocationSettingsController@index')->name('settings');
        Route::post('settings', 'LocationSettingsController@updateSettings')->name('settings_update');
    });

    //Business Locations...
    Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
    Route::resource('business-location', 'BusinessLocationController');
    // Business Locations new
    Route::get('business/locations','BusinessLocationController2@index')->name('business.locations');
    //Invoice layouts..
    Route::resource('invoice-layouts', 'InvoiceLayoutController');
    
    // Invoice layouts new
    Route::get('/invoices/layouts','InvoiceLayoutController2@index')->name('invoice.layouts');
    
    //Expense Categories...
    Route::resource('expense-categories', 'ExpenseCategoryController');

    //Expenses...
    Route::resource('expenses', 'ExpenseController');

    //Transaction payments...
    // Route::get('/payments/opening-balance/{contact_id}', 'TransactionPaymentController@getOpeningBalancePayments');
    Route::get('/payments/show-child-payments/{payment_id}', 'TransactionPaymentController@showChildPayments');
    Route::get('/payments/view-payment/{payment_id}', 'TransactionPaymentController@viewPayment');
    Route::get('/payments/add_payment/{transaction_id}', 'TransactionPaymentController@addPayment');
    Route::get('/payments/pay-contact-due/{contact_id}', 'TransactionPaymentController@getPayContactDue');
    Route::post('/payments/pay-contact-due', 'TransactionPaymentController@postPayContactDue');
    Route::resource('payments', 'TransactionPaymentController');

    //Printers...
    Route::resource('printers', 'PrinterController');

    Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', 'StockAdjustmentController@removeExpiredStock');
    Route::post('/stock-adjustments/get_product_row', 'StockAdjustmentController@getProductRow');
    Route::resource('stock-adjustments', 'StockAdjustmentController');

    Route::get('/cash-register/register-details', 'CashRegisterController@getRegisterDetails');
    Route::get('/cash-register/close-register/{id?}', 'CashRegisterController@getCloseRegister');
    Route::post('/cash-register/close-register', 'CashRegisterController@postCloseRegister');
    Route::resource('cash-register', 'CashRegisterController');

    //Import products
    Route::get('/import-products', 'ImportProductsController@index');
    Route::post('/import-products/store', 'ImportProductsController@store');

    //Sales Commission Agent
    Route::resource('sales-commission-agents', 'SalesCommissionAgentController');

    //Stock Transfer
    Route::get('stock-transfers/print/{id}', 'StockTransferController@printInvoice');
    Route::post('stock-transfers/update-status/{id}', 'StockTransferController@updateStatus');
    Route::resource('stock-transfers', 'StockTransferController');
    
    Route::get('/opening-stock/add/{product_id}', 'OpeningStockController@add');
    Route::post('/opening-stock/save', 'OpeningStockController@save');

    //Customer Groups
    Route::resource('customer-group', 'CustomerGroupController');

    //Import opening stock
    Route::get('/import-opening-stock', 'ImportOpeningStockController@index');
    Route::post('/import-opening-stock/store', 'ImportOpeningStockController@store');

    //Sell return
    Route::resource('sell-return', 'SellReturnController');
    Route::get('sell-return/get-product-row', 'SellReturnController@getProductRow');
    Route::get('/sell-return/print/{id}', 'SellReturnController@printInvoice');
    Route::get('/sell-return/add/{id}', 'SellReturnController@add');
    
    //Backup
    Route::get('backup/download/{file_name}', 'BackUpController@download');
    Route::get('backup/delete/{file_name}', 'BackUpController@delete');
    Route::resource('backup', 'BackUpController', ['only' => [
        'index', 'create', 'store'
    ]]);

    Route::get('selling-price-group/activate-deactivate/{id}', 'SellingPriceGroupController@activateDeactivate');
    Route::get('export-selling-price-group', 'SellingPriceGroupController@export');
    Route::post('import-selling-price-group', 'SellingPriceGroupController@import');

    Route::resource('selling-price-group', 'SellingPriceGroupController');
    
    // sell price group new
    Route::get('sell/price/groups','SellPriceGroupController@index')->name('sell.price.groups');
    
    Route::resource('notification-templates', 'NotificationTemplateController')->only(['index', 'store']);
    Route::get('notification/get-template/{transaction_id}/{template_for}', 'NotificationController@getTemplate');
    Route::post('notification/send', 'NotificationController@send');

    Route::post('/purchase-return/update', 'CombinedPurchaseReturnController@update');
    Route::get('/purchase-return/edit/{id}', 'CombinedPurchaseReturnController@edit');
    Route::post('/purchase-return/save', 'CombinedPurchaseReturnController@save');
    Route::post('/purchase-return/get_product_row', 'CombinedPurchaseReturnController@getProductRow');
    Route::get('/purchase-return/create', 'CombinedPurchaseReturnController@create');
    Route::get('/purchase-return/add/{id}', 'PurchaseReturnController@add');
    Route::resource('/purchase-return', 'PurchaseReturnController', ['except' => ['create']]);
    
    // chat
    Route::get('/chat','ChatController@index')->name('chat');
    
    Route::get('/runcom','ChatController@runcom');
    Route::get('/discount/activate/{id}', 'DiscountController@activate');
    Route::post('/discount/mass-deactivate', 'DiscountController@massDeactivate');
    Route::resource('discount', 'DiscountController');

    Route::group(['prefix' => 'account'], function () {
        Route::resource('/account', 'AccountController');
        Route::get('/fund-transfer/{id}', 'AccountController@getFundTransfer');
        Route::post('/fund-transfer', 'AccountController@postFundTransfer');
        Route::get('/deposit/{id}', 'AccountController@getDeposit');
        Route::post('/deposit', 'AccountController@postDeposit');
        Route::get('/close/{id}', 'AccountController@close');
        Route::get('/activate/{id}', 'AccountController@activate');
        Route::get('/delete-account-transaction/{id}', 'AccountController@destroyAccountTransaction');
        Route::get('/get-account-balance/{id}', 'AccountController@getAccountBalance');
        Route::get('/balance-sheet', 'AccountReportsController@balanceSheet');
        Route::get('/trial-balance', 'AccountReportsController@trialBalance');
        Route::get('/payment-account-report', 'AccountReportsController@paymentAccountReport');
        Route::get('/link-account/{id}', 'AccountReportsController@getLinkAccount');
        Route::post('/link-account', 'AccountReportsController@postLinkAccount');
        Route::get('/cash-flow', 'AccountController@cashFlow');
    });
    
    
    
    /* website */
     
    Route::group(['prefix' => 'website'], function () {
        
        Route::get('/', 'WebsiteController@website_setting')->name('website.locations');
        Route::get('/sync-all/{id}', 'WebsiteController@indexx')->name('website.sync');
        Route::get('/api-settings/{id}', 'WebsiteController@apiSettings');
        Route::get('/sync-products', 'WebsiteController@syncProducts');
        Route::get('/sync-log', 'WebsiteController@getSyncLog');
        Route::get('/sync-orders', 'WebsiteController@syncOrders');
        Route::post('/map-taxrates', 'WebsiteController@mapTaxRates');
        Route::get('/view-sync-log', 'WebsiteController@viewSyncLog');
        Route::get('/get-log-details/{id}', 'WebsiteController@getLogDetails');
        Route::get('/reset-categories', 'WebsiteController@resetCategories');
        Route::get('/reset-products', 'WebsiteController@resetProducts');
    });
    
    Route::post('/uupdate-api-settingss/{id}', 'WebsiteController@updateSettings');
    Route::get('/website_set', 'Api\ConectionController@website');
    Route::put('/sync-categories/', 'WebsiteController@syncCategories');
    Route::put('/synced-categories/', 'WebsiteController@syncedCategories');
    Route::put('/sync-Brands/', 'WebsiteController@syncBrands');
    Route::put('/synced-Brands/', 'WebsiteController@syncedBrands');
    
    
    
    
    
    //------------ ADMIN ZONES  ------------
    
    Route::get('/zones/datatables', 'Admin\ShipmentZoneController@datatables')->name('admin-zones-datatables');
    Route::get('/zones', 'Admin\ShipmentZoneController@index')->name('admin-zones-index');
    Route::get('/zones/create', 'Admin\ShipmentZoneController@create')->name('admin-zones-create');
    Route::post('/zones/store', 'Admin\ShipmentZoneController@store')->name('admin-zones-store');
    Route::get('/zones/edit/{id}', 'Admin\ShipmentZoneController@edit')->name('admin-zones-edit');
    Route::post('/zones/edit/{id}', 'Admin\ShipmentZoneController@update')->name('admin-zones-update');
    Route::get('/zones/destroy/{id}', 'Admin\ShipmentZoneController@destroy')->name('admin-zones-delete');
    Route::get('/zones/city/create', 'Admin\ShipmentZoneController@citycreate')->name('admin-city-zone-create');
    Route::post('/zones/city/store', 'Admin\ShipmentZoneController@citystore')->name('admin-city-zone--store');
    Route::post('cities' , 'Admin\ShipmentZoneController@cities');
    Route::get('/zones/city/{id}', 'Admin\ShipmentZoneController@city')->name('admin-city-zone-index');
    Route::get('/zones/city/delete/{id}', 'Admin\ShipmentZoneController@citydelete')->name('admin-zones-delete-city');
    //------------ ADMIN ZONES ENDS ------------ 
    
    //----------------- COUNTRY ----------------------------------
  
    Route::get('/country/datatables', 'Admin\CountryController@datatables')->name('admin-country-datatables'); //JSON REQUEST
    Route::get('/country', 'Admin\CountryController@index')->name('admin-country-index');
    Route::get('/country/create', 'Admin\CountryController@create')->name('admin-country-create');
    Route::post('/country/create', 'Admin\CountryController@store')->name('admin-country-store');
    Route::get('/country/edit/{id}', 'Admin\CountryController@edit')->name('admin-country-edit');
    Route::post('/country/edit/{id}', 'Admin\CountryController@update')->name('admin-country-update');
    Route::delete('/country/delete/{id}', 'Admin\CountryController@destroy')->name('admin-country-delete');
    Route::get('/country/status/{id1}/{id2}', 'Admin\CountryController@status')->name('admin-country-status');
    
    //----------------- CITY ----------------------------------
  
    Route::get('/city/datatables', 'Admin\CityController@datatables')->name('admin-city-datatables'); //JSON REQUEST
    Route::get('/city', 'Admin\CityController@index')->name('admin-city-index');
    Route::get('/city/create', 'Admin\CityController@create')->name('admin-city-create');
    Route::post('/city/create', 'Admin\CityController@store')->name('admin-city-store');
    Route::get('/city/edit/{id}', 'Admin\CityController@edit')->name('admin-city-edit');
    Route::post('/city/edit/{id}', 'Admin\CityController@update')->name('admin-city-update');
    Route::get('/city/delete/{id}', 'Admin\CityController@destroy')->name('admin-city-delete');
    Route::POST('/city/name/', 'Admin\CityController@cityname');
   
    Route::post('/state/name/', 'Admin\CityController@statename');
    Route::post('/country/name/', 'Admin\CityController@countryname');
    
    Route::get('/city/status/{id1}/{id2}', 'Admin\CityController@status')->name('admin-city-status');  
    Route::post('/city/city', 'Admin\CityController@city')->name('admin-city-city');  
    Route::post('/city/cityy', 'Admin\CityController@cityy')->name('admin-cityy-city');  
    Route::post('/city/state', 'Admin\ShipmentZoneController@states')->name('admin-states-city');  
    Route::post('/city/states', 'Admin\ShipmentZoneController@statess')->name('admin-statess-city');  
    
    //----------------- State ----------------------------------
  
    Route::get('/state/datatables', 'Admin\StateController@datatables')->name('admin-state-datatables'); //JSON REQUEST
    Route::get('/state', 'Admin\StateController@index')->name('admin-state-index');
    Route::get('/state/create', 'Admin\StateController@create')->name('admin-state-create');
    Route::post('/state/create', 'Admin\StateController@store')->name('admin-state-store');
    Route::get('/state/edit/{id}', 'Admin\StateController@edit')->name('admin-state-edit');
    Route::post('/state/edit/{id}', 'Admin\StateController@update')->name('admin-state-update');
    Route::get('/state/delete/{id}', 'Admin\StateController@destroy')->name('admin-state-delete');
    Route::get('/state/status/{id1}/{id2}', 'Admin\StateController@status')->name('admin-state-status');  
    
    //------------ ADMIN SHIPMENTS ------------

    Route::get('/shipment/datatables', 'Admin\ShipmentController@datatables')->name('admin-shipment-datatables');
    Route::get('/shipmentss', 'Admin\ShipmentController@index')->name('admin-shipment-index');
    Route::get('/shipment/create', 'Admin\ShipmentController@create')->name('admin-shipment-create');
    Route::post('/shipment/store', 'Admin\ShipmentController@store')->name('admin-shipment-store');
    Route::get('/shipment/edit/{id}', 'Admin\ShipmentController@edit')->name('admin-shipment-edit');
    Route::post('/shipment/edit/{id}', 'Admin\ShipmentController@update')->name('admin-shipment-update');
    Route::get('/shipment/delete/{id}', 'Admin\ShipmentController@destroy')->name('admin-shipment-delete');
    
    //------------ ADMIN SHIPMENTS PRICE------------

  Route::get('/shipment/price/datatables', 'Admin\ShipmentPriceController@datatables')->name('admin-shipment-price-datatables');
  Route::get('/shipment/price', 'Admin\ShipmentPriceController@index')->name('admin-shipment-price-index');
  Route::get('/shipment/price/create', 'Admin\ShipmentPriceController@create')->name('admin-shipment-price-create');
  Route::post('/shipment/price/create', 'Admin\ShipmentPriceController@store')->name('admin-shipment-price-store');
  Route::get('/shipment/price/edit/{id}', 'Admin\ShipmentPriceController@edit')->name('admin-shipment-price-edit');
  Route::post('/shipment/price/edit/{id}', 'Admin\ShipmentPriceController@update')->name('admin-shipment-price-update');
  Route::get('/shipment/price/delete/{id}', 'Admin\ShipmentPriceController@destroy')->name('admin-shipment-price-delete');

  //------------ ADMIN SHIPMENTS ENDS ------------
    
    Route::resource('account-types', 'AccountTypeController');

    //Restaurant module
    Route::group(['prefix' => 'modules'], function () {
        Route::resource('tables', 'Restaurant\TableController');
        Route::resource('modifiers', 'Restaurant\ModifierSetsController');

        //Map modifier to products
        Route::get('/product-modifiers/{id}/edit', 'Restaurant\ProductModifierSetController@edit');
        Route::post('/product-modifiers/{id}/update', 'Restaurant\ProductModifierSetController@update');
        Route::get('/product-modifiers/product-row/{product_id}', 'Restaurant\ProductModifierSetController@product_row');

        Route::get('/add-selected-modifiers', 'Restaurant\ProductModifierSetController@add_selected_modifiers');

        Route::get('/kitchen', 'Restaurant\KitchenController@index');
        Route::get('/kitchen/mark-as-cooked/{id}', 'Restaurant\KitchenController@markAsCooked');
        Route::post('/refresh-orders-list', 'Restaurant\KitchenController@refreshOrdersList');
        Route::post('/refresh-line-orders-list', 'Restaurant\KitchenController@refreshLineOrdersList');

        Route::get('/orders', 'Restaurant\OrderController@index');
        Route::get('/orders/mark-as-served/{id}', 'Restaurant\OrderController@markAsServed');
        Route::get('/data/get-pos-details', 'Restaurant\DataController@getPosDetails');
        Route::get('/orders/mark-line-order-as-served/{id}', 'Restaurant\OrderController@markLineOrderAsServed');
    });

    Route::get('bookings/get-todays-bookings', 'Restaurant\BookingController@getTodaysBookings');
    Route::resource('bookings', 'Restaurant\BookingController');
    
    Route::resource('types-of-service', 'TypesOfServiceController');
    Route::get('sells/edit-shipping/{id}', 'SellController@editShipping');
    Route::put('sells/update-shipping/{id}', 'SellController@updateShipping');
    Route::get('shipments', 'SellController@shipments');

    Route::post('upload-module', 'Install\ModulesController@uploadModule');
    Route::resource('manage-modules', 'Install\ModulesController')
        ->only(['index', 'destroy', 'update']);
    Route::resource('warranties', 'WarrantyController');
    
    // warranty new
    Route::get('/warranties/new/create','WarrantyController2@create')->name('warranty.index');
    
    Route::resource('dashboard-configurator', 'DashboardConfiguratorController')
    ->only(['edit', 'update']);

    Route::get('view-media/{model_id}', 'SellController@viewMedia');

    //common controller for document & note
    Route::get('get-document-note-page', 'DocumentAndNoteController@getDocAndNoteIndexPage');
    Route::post('post-document-upload', 'DocumentAndNoteController@postMedia');
    Route::resource('note-documents', 'DocumentAndNoteController');
});


Route::middleware(['EcomApi'])->prefix('api/ecom')->group(function () {
    Route::get('products/{id?}', 'ProductController@getProductsApi');
    Route::get('categories', 'CategoryController@getCategoriesApi');
    Route::get('brands', 'BrandController@getBrandsApi');
    Route::post('customers', 'ContactController@postCustomersApi');
    Route::get('settings', 'BusinessController@getEcomSettings');
    Route::get('variations', 'ProductController@getVariationsApi');
    Route::post('orders', 'SellPosController@placeOrdersApi');
});

//common route
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    Route::get('/load-more-notifications', 'HomeController@loadMoreNotifications');
    Route::get('/get-total-unread', 'HomeController@getTotalUnreadNotifications');
    Route::get('/purchases/print/{id}', 'PurchaseController@printInvoice');
    Route::get('/purchases/{id}', 'PurchaseController@show');
    Route::get('/sells/{id}', 'SellController@show');
    Route::get('/sells/{transaction_id}/print', 'SellPosController@printInvoice')->name('sell.printInvoice');
    Route::get('/sells/invoice-url/{id}', 'SellPosController@showInvoiceUrl');
    Route::get('/show-notification/{id}', 'HomeController@showNotification');
});

Route::get('/websocket','WebsocketController@index');


      //------------ ADMIN Shipping Types ------------

  Route::get('/shippingtype/datatables', 'Admin\ShippingTypeController@datatables')->name('admin-shippingtype-datatables');
  Route::get('/shippingtype', 'Admin\ShippingTypeController@index')->name('admin-shippingtype-index');
  Route::get('/shippingtype/create', 'Admin\ShippingTypeController@create')->name('admin-shippingtype-create');
  Route::post('/shippingtype/store', 'Admin\ShippingTypeController@store')->name('admin-shippingtype-store');
  Route::get('/shippingtype/edit/{id}', 'Admin\ShippingTypeController@edit')->name('admin-shippingtype-edit');
  Route::post('/shippingtype/edit/{id}', 'Admin\ShippingTypeController@update')->name('admin-shippingtype-update');
  Route::get('/shippingtype/delete/{id}', 'Admin\ShippingTypeController@destroy')->name('admin-shippingtype-delete');

  //------------ ADMIN SHIPPING TYPES ENDS ------------ 
  
  
     //------------ ADMIN Store Number ------------

  Route::get('/storenumber/datatables', 'StoreNumberController@datatables')->name('admin-storenumber-datatables');
  Route::get('/storenumber', 'StoreNumberController@index')->name('admin-storenumber-index');
  Route::get('/storenumber/create', 'StoreNumberController@create')->name('admin-storenumber-create');
  Route::post('/storenumber/store', 'StoreNumberController@store')->name('admin-storenumber-store');
  Route::get('/storenumber/edit/{id}', 'StoreNumberController@edit')->name('admin-storenumber-edit');
  Route::post('/storenumber/edit/{id}', 'StoreNumberController@update')->name('admin-storenumber-update');
  Route::get('/storenumber/delete/{id}', 'StoreNumberController@destroy')->name('admin-storenumber-delete');

  //------------ ADMIN Store Number ENDS ------------ 
  
  Route::post('customer/address','AddressController@getCustomerAddress')->name('ajax.customer.address');
  Route::post('address/shipment','AddressController@getShipment')->name('ajax.address.shipment');
  Route::post('address/info','AddressController@info')->name('ajax.address.info');
  Route::get('address/{id}/edit','AddressController@edit')->name('address.edit');
  
  Route::get('test','TestController@test');
