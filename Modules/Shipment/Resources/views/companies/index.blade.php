@extends('layouts.app')
@section('title', __('shipment::lang.shipment'))

@section('content')
@include('shipment::layouts.nav')
<div class="default-box-body">
    <div class="row">
        @foreach ($companies as $company)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="ship-cad-box h-100">
                <img src="{{asset('public/modules/shipment/company/images/'.$company->image)}}">
                <div class="d-flex justify-content-between flex-wrap py-3">
                    <h3>{{ $company->name }}</h3>
                    {{-- <h3>{{ $customer->name_ar }}</h3>     --}}
                    <p class="ship-phone">{{ $company->phone }}</p>
                    <hr class="my-4">
                    <div class='ship-card-icons d-flex justify-content-between flex-wrap'>
                        @if($company->type == 'system')
                            <a href="{{route('shipment.company.addaccount',$company->name)}}" class="main-light-btn m-auto"><i class="far fa-edit">
                                
                                </i> @lang("shipment::lang.add_account")
                            </a>
                                        &nbsp;
                            <a href="{{route('shipment.' . strtolower($company->name) .'.index')}}" class="main-light-btn m-auto"><i class="far fa-edit">
                                
                                </i> @lang("shipment::lang.details")
                                </a>            
                        @else
                            <p>Not system</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>    
</div>    
@endsection