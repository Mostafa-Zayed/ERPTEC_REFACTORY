@if (auth()->user()->can('product.view') || auth()->user()->can('product.create') ||
    auth()->user()->can('brand.view') || auth()->user()->can('unit.view') ||
    auth()->user()->can('category.view') || auth()->user()->can('brand.create') ||
    auth()->user()->can('unit.create') || auth()->user()->can('category.create'))
<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if (auth()->user()->can('product.view'))
                        <a href="{{action('ProductController@index')}}" @if(request()->segment(1) == 'products' && request()->segment(2) == '') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-list"></i> {{__('lang_v1.list_products')}}</a>
                    @endif
                    @if (in_array('stock_transfers', $enabled_modules) && (auth()->user()->can('stock_transfers.view')))
                        <a href="{{action('StockTransferController@index')}}" @if(request()->segment(1) == 'stock-transfers' && request()->segment(2) == null) class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-angle-double-right"></i> {{__('lang_v1.list_stock_transfers')}}</a>
                    @endif
                    @if (in_array('stock_adjustment', $enabled_modules) && (auth()->user()->can('stock_adjustment.view')))
                        <a href="{{action('StockAdjustmentController@index')}}" @if((request()->segment(1) == 'stock-adjustments' && request()->segment(2) == null) || request()->segment(1) == 'index-stock-adjustments') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-layer-group"></i> {{__('stock_adjustment.list')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        <div class="dropdown nav-dropdown mb-4 me-3">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i>@lang('lang_v1.products_settings')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if (auth()->user()->can('product.create'))
                    <a href="{{action('VariationTemplateController@index')}}" @if(request()->segment(1) == 'variation-templates') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-circle"></i> {{__('product.variations')}}</a>
                @endif
                @if (auth()->user()->can('product.create'))
                    <a href="{{action('SellingPriceGroupController@index')}}" @if(request()->segment(1) == 'selling-price-group') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-money-check-alt"></i> {{__('lang_v1.selling_price_group')}}</a>
                @endif
                @if (auth()->user()->can('category.view') || auth()->user()->can('category.create'))
                    <a href="{{action('TaxonomyController@index') . '?type=product'}}" @if(request()->segment(1) == 'taxonomies' && request()->get('type') == 'product') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-sitemap"></i> {{__('category.categories')}}</a>
                @endif
                @if (auth()->user()->can('brand.view') || auth()->user()->can('brand.create'))
                    <a href="{{action('BrandController@index')}}" @if(request()->segment(1) == 'brands') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-tags"></i> {{__('brand.brands')}}</a>
                @endif
            </div>
        </div>
        <div class="dropdown nav-dropdown mb-4">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i>@lang('lang_v1.settings') </span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                @if (auth()->user()->can('labels.view'))
                    <a href="{{action('LabelsController@show')}}" @if(request()->segment(1) == 'labels' && request()->segment(2) == 'show') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-barcode"></i> {{__('barcode.print_labels')}}</a>
                @endif
                @if (auth()->user()->can('product.create'))
                    <a href="{{action('ImportProductsController@index')}}" @if(request()->segment(1) == 'import-products') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-download"></i> {{__('product.import_products')}}</a>
                @endif
                @if (auth()->user()->can('product.opening_stock'))
                    <a href="{{action('ImportOpeningStockController@index')}}" @if(request()->segment(1) == 'import-opening-stock') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-download"></i> {{__('lang_v1.import_opening_stock')}}</a>
                @endif
                @if (auth()->user()->can('unit.view') || auth()->user()->can('unit.create'))
                    <a href="{{action('UnitController@index')}}" @if(request()->segment(1) == 'units') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-balance-scale"></i> {{__('unit.units')}}</a>
                @endif
                @if (auth()->user()->can('shippingtype'))
                    <a href="{{action('Admin\ShippingTypeController@index')}}" @if(request()->segment(1) == 'shippingtype') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fa fas fa-warehouse"></i> {{__('sale.shipping_type')}}</a>
                @endif
                @if (auth()->user()->can('storenumber'))
                    <a href="{{action('StoreNumberController@index')}}" @if(request()->segment(1) == 'storenumber') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-code-branch"></i> {{__('sale.store_number')}}</a>
                @endif
                @if (auth()->user()->can('warranties'))
                    <a href="{{action('WarrantyController@index')}}" @if(request()->segment(1) == 'warranties') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-shield-alt"></i> {{__('lang_v1.warranties')}}</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endif