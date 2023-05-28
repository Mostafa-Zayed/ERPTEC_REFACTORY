@extends('layouts.app')
@section('title', 'shipment')

@section('content')

<!-- Content Header (Page header) -->
{{--
<section class="content-header">
    <h1>@lang( 'sale.Shipping company' )
      
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
--}}
@include('layouts.navs.settings_nav')

<!-- Main content -->
<section class="content">
    {{--@component('components.widget', ['class' => 'box-primary', 'title' => __( 'sale.all_Shipping company' )])--}}
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between">
            <h4><i class="fas fa-box-open"></i> @lang('sale.all_Shipping company')</h4>
            @can('sell.view')
                <button type="button" class="main-dark-btn btn-modal" data-href="{{action('Admin\ShipmentController@create')}}" data-container=".campaigns_modal">
                    <i class="fa fa-plus"></i> @lang( 'messages.add' )
                </button>
            @endcan
        </div>
        <div class="default-box-body">
            @can('sell.view')
                <div class="row">
                    @foreach ($brands as $customer)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="ship-cad-box h-100">
                            <img src="{{asset('assets/images/shipments/'.$customer->photo)}}">
                            <div class="d-flex justify-content-between flex-wrap py-3">
                                <h3>{{ $customer->name }}</h3>
                                <h3>{{ $customer->name_ar }}</h3>    
                            </div>
                            <p class="ship-phone">{{ $customer->phone }}</p>
                            <hr class="my-4">
                            <div class='ship-card-icons d-flex justify-content-between flex-wrap'>
                                @if($customer->status == 0)
                                    @can("sell.update")
                                        <a href="{{route('admin-shipment-setting',$customer->id)}}" class="main-light-btn m-auto"><i class="far fa-edit"></i> @lang("sale.editshipping")</a>
                                        &nbsp;
                                    @endcan
                                @endif
                                @can("sell.update")
                                    @if($customer->type == 1)
                                        @if (auth()->user()->can('superadmin')) 
                                            <button data-href="{{action('Admin\ShipmentController@editimg', [$customer->id])}}" class="main-light-btn edit_campaigns_button mb-2"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit_shipping_img")</button>
                                        @endif 
                                    @endif
                                    @if($customer->type == 2)
                                        <button data-href="{{action('Admin\ShipmentController@editimg', [$customer->id])}}" class="main-light-btn edit_campaigns_button mb-2"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit_shipping_img")</button>
                                        <button data-href="{{action('Admin\ShipmentController@edit', [$customer->id])}}" class="main-dark-btn edit_campaigns_button mb-2"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                                    @endif
                                @endcan
                                @can("sell.delete")
                                    @if($customer->type == 2)
                                        <button data-href="{{action('Admin\ShipmentController@destroy', [$customer->id])}}" class="btn btn-danger delete_campaigns_button mb-2">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endcan
        </div>
    </div>
    
    <div class="default-box">
        <div class="default-box-body">
            @can('sell.view')
                <div class="table-responsive">
                    <table class="main_light_table table table-bordered table-striped" id="trafic_table">
                        <thead>
                            <tr>
                                <th>@lang( 'sale.name' )</th>
                                <th>@lang( 'sale.name_ar' )</th>
                                <th>@lang( 'sale.phone' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->name_ar }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        @if($customer->status == 0)
                                            @can("sell.update")
                                                <a href="{{route('admin-shipment-setting',$customer->id)}}" class="btn btn-xs main-bg-dark text-white"><i class="glyphicon glyphicon-edit"></i> @lang("sale.editshipping")</a>
                                                &nbsp;
                                            @endcan
                                        @endif
                                        @if($customer->type == 2)
                                            @can("sell.update")
                                                <button data-href="{{action('Admin\ShipmentController@edit', [$customer->id])}}" class="btn btn-xs main-bg-light text-white edit_campaigns_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                                                &nbsp;
                                            @endcan
                                        @endif
                                        @if($customer->type == 2)
                                            @can("sell.delete")
                                                <button data-href="{{action('Admin\ShipmentController@destroy', [$customer->id])}}" class="btn btn-xs btn-danger delete_campaigns_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                                            @endcan 
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endcan
        </div>
    </div>
    {{--@endcomponent--}}

    <div class="modal fade campaigns_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection
@section('javascript')
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready( function () {
            $('#trafic_table').DataTable();
             
         });
    </script>
@endsection