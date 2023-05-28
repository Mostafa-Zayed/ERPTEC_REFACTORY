@if (in_array('stock_adjustment', $enabled_modules) && (auth()->user()->can('stock_adjustment.view')))
<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('stock_adjustment.view'))
                        <a href="{{action('StockAdjustmentController@index')}}" @if(request()->segment(1) == 'stock-adjustments' && request()->segment(2) == null) class="active nav-link" @else class="nav-link" @endif><i class="fas fa-layer-group"></i> {{__('stock_adjustment.list')}}</a>
                    @endif
                    @if (auth()->user()->can('stock_adjustment.create'))
                        <a href="{{action('StockAdjustmentController@export_index')}}" @if(request()->segment(1) == 'index-stock-adjustments' && request()->segment(2) == null) class="active nav-link" @else class="nav-link" @endif><i class="fas fa-plus-circle"></i> {{__('stock_adjustment.import_add')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
@endif