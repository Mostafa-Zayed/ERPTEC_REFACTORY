@if (auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view'))
    <div class="d-flex align-items-top justify-content-between no-print">
        <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
            <div class="container-fluid p-0">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <i class="fas fa-list"></i>
                </button>
                <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                    <div class="navbar-nav">
                        @if (auth()->user()->can('user.view'))
                            <a href="{{action('ManageUserController@index')}}"  @if(request()->segment(1) == 'users') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-users me-2"></i> {{__('user.users')}}</a>
                        @endif
                        @if (auth()->user()->can('roles.view'))
                            <a href="{{action('RoleController@index')}}"  @if(request()->segment(1) == 'roles') class="active-dark nav-link" @else class="nav-link" @endif><i class="far fa-address-card me-2"></i> {{__('user.roles')}}</a>
                        @endif
                        @if (auth()->user()->can('user.create'))
                            <a href="{{action('SalesCommissionAgentController@index')}}"  @if(request()->segment(1) == 'sales-commission-agents') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-handshake me-2"></i> {{__('lang_v1.sales_commission_agents')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>
    </div>
@endif