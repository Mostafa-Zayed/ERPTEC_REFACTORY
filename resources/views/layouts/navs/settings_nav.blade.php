<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if(auth()->user()->can('business_settings.access'))
                        <a href="{{action('BusinessController@getBusinessSettings')}}"  @if(request()->segment(1) == 'business') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-cogs me-2"></i> {{__('business.business_settings')}}</a>
                        <a href="{{action('BusinessLocationController@index')}}"  @if(request()->segment(1) == 'business-location') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-map-marker me-2"></i> {{__('business.business_locations')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        
        <div class="dropdown nav-dropdown mb-4 me-3">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i> @lang('lang_v1.shipping_settings')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if (auth()->user()->can('shipment_zones'))
                
                    <a href="{{action('Admin\ShipmentController@index')}}" @if(request()->segment(1) == 'shipment' && request()->segment(2) == null) class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-building"></i> {{__('sale.Shipping_company')}}</a>
                    
                    <a href="{{action('Admin\ShipmentZoneController@index')}}" @if(request()->segment(1) == 'zones') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-tags"></i> {{__('sale.zones')}}</a>
                    <a href="{{action('Admin\ShipmentPriceController@index')}}" @if(request()->segment(1) == 'shipment' && request()->segment(2) == 'price') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-dollar-sign"></i> {{__('sale.shipment_prices')}}</a>
                @endif
                @if (auth()->user()->can('superadmin'))
                    <a href="{{action('Admin\CountryController@index')}}" @if(request()->segment(1) == 'Country') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-globe-africa"></i> {{__('sale.Country')}}</a>
                    <a href="{{action('Admin\CityController@index')}}" @if(request()->segment(1) == 'city') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-city"></i> {{__('sale.City')}}</a>
                    <a href="{{action('Admin\StateController@index')}}" @if(request()->segment(1) == 'state') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="far fa-building"></i> {{__('sale.State')}}</a>
                @endif
            </div>
        </div>
        
        <div class="dropdown nav-dropdown mb-4">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i> @lang('lang_v1.other')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                @if(auth()->user()->can('invoice_settings.access'))
                    <a href="{{action('InvoiceSchemeController@index')}}" @if(in_array(request()->segment(1), ['invoice-schemes', 'invoice-layouts'])) class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-file"></i> @lang('invoice.invoice_settings')</a>
                @endif
                @if(auth()->user()->can('barcode_settings.access'))
                    <a href="{{action('BarcodeController@index')}}" @if(request()->segment(1) == 'barcodes') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-barcode"></i> @lang('barcode.barcode_settings')</a>
                @endif
                <a href="{{action('PrinterController@index')}}" @if(request()->segment(1) == 'printers') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-share-alt"></i> @lang('printer.receipt_printers')</a>
                @if(auth()->user()->can('send_notifications'))
                    <a href="{{action('NotificationTemplateController@index')}}" @if(request()->segment(1) == 'notification-templates') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="far fa-bell"></i> @lang('lang_v1.notification_templates')</a>
                @endif
                @if (auth()->user()->can('tax_rate.view') || auth()->user()->can('tax_rate.create'))
                    <a href="{{action('TaxRateController@index')}}" @if(request()->segment(1) == 'tax-rates') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-bolt"></i> @lang('tax_rate.tax_rates')</a>
                @endif
                @if (in_array('types_of_service', $enabled_modules))
                    <a href="{{action('TypesOfServiceController@index')}}" @if(request()->segment(1) == 'types-of-service') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-user-circle"></i> @lang('lang_v1.types_of_service')</a>
                @endif
            </div>
        </div>
    </div>
</div>