<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if (auth()->user()->can('purchase.view'))
                        <a href="{{action('PurchaseController@index')}}" @if(request()->segment(1) == 'purchases' && request()->segment(2) == null) class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-list me-2"></i> {{__('purchase.list_purchase')}}</a>
                    @endif
                    @if (auth()->user()->can('purchase.create'))
                        <a href="{{action('PurchaseController@imeicreate')}}" @if(request()->segment(1) == 'purchases' && request()->segment(2) == 'imei-create') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-plus-circle me-2"></i> {{__('purchase.add_imei_purchase')}}</a>                    
                    @endif
                    @if (auth()->user()->can('purchase.update'))
                        <a href="{{action('PurchaseReturnController@index')}}" @if(request()->segment(1) == 'purchase-return') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-undo me-2"></i> {{__('lang_v1.list_purchase_return')}}</a>                    
                    @endif 
                    
                    @if (auth()->user()->can('purchase.view'))
                        <a href="{{action('PurchaseOrderController@index')}}" @if(request()->segment(1) == 'purchase-order') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-list me-2"></i> {{__('purchase.purchase_order')}}</a>                    
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>