@if (auth()->user()->can('supplier.view') || auth()->user()->can('customer.view'))
    <div class="d-flex align-items-top justify-content-between no-print">
        <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
            <div class="container-fluid p-0">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <i class="fas fa-list"></i>
                </button>
                <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                    <div class="navbar-nav">
                        @if (auth()->user()->can('supplier.view'))
                            <a href="{{action('ContactController@index', ['type' => 'supplier'])}}" @if(request()->input('type') == 'supplier') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-people-carry me-2"></i> {{__('report.supplier')}}</a>
                        @endif
                        @if (auth()->user()->can('customer.view'))
                            <a href="{{action('ContactController@index', ['type' => 'customer'])}}" @if(request()->input('type') == 'customer') class="active-dark nav-link" @else class="nav-link" @endif><i class="far fa-id-badge me-2"></i> {{__('report.customer')}}</a>                    
                        @endif
                    </div>
                </div>
            </div>
        </nav>
        <div class="dropdown nav-dropdown mb-4">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i> @lang('lang_v1.others')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if (auth()->user()->can('customer.view'))
                    {{--@php
                        $userRoles = auth()->user()->roles;
                        $isAdmin = $this->isAuthenticatedUserHaAdminRole(request()->session()->get('user.business_id'),$userRoles);
                    @endphp
                    @if (! auth()->user()->can('customer.view_customer_groups_only') && ! auth()->user()->can('supplier.view_supplier_groups_only') && ! auth()->user()->can('customer.enable_add_customer_to_user') && ! auth()->user()->can('supplier.enable_add_supplier_to_user') || $isAdmin) --}}  
                        <a href="{{action('CustomerGroupController@index')}}" @if(request()->segment(1) == 'customer-group') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-users"></i> {{__('lang_v1.customer_groups')}}</a>
                    {{--@endif--}}    
                @endif
                @if (auth()->user()->can('supplier.create') || auth()->user()->can('customer.create'))
                    <a href="{{action('ContactController@getImportContacts')}}" @if(request()->segment(1) == 'contacts' && request()->segment(2) == 'import') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-file-import"></i> {{__('lang_v1.import_contacts')}}</a>
                @endif
            </div>
        </div>
    </div>
@endif