@extends('layouts.app')
@section('title', 'Shipment Price')

@section('content')

<!-- Content Header (Page header) -->
{{--
<section class="content-header">
    <h1>@lang( 'sale.shipment Price' )
      
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
    {{--@component('components.widget', ['class' => 'box-primary', 'title' => __( 'sale.all_shipment Prices' )])--}}
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between">
            <h4><i class="fas fa-shopping-basket"></i> {{__('sale.all_shipment Prices')}}</h4>
            @can('sell.view')
                <button type="button" class="main-dark-btn btn-modal" data-href="{{action('Admin\ShipmentPriceController@create')}}" data-container=".campaigns_modal">
                    <i class="fa fa-plus"></i> @lang( 'messages.add' )
                </button>
            @endcan
        </div>
        <div class="default-box-body">
            @can('sell.view')
                <div class="table-responsive">
                    <table class="main_light_table table table-bordered table-striped" id="trafic_table">
                        <thead>
                            <tr>
                                <th>@lang( 'sale.zone' )</th>
                                <th>@lang( 'sale.shipment' )</th>
                                <th>@lang( 'sale.price' )</th>
                                <th>@lang( 'sale.extra' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($brands as $customer)
                                <tr>
                                    <td>{{ !empty($customer->tozone->name) ? $customer->tozone->name  : "zone deleted" }}</td>
                                    <td>{{ !empty($customer->shipment->name) ? $customer->shipment->name : "ship deleted" }}</td>
                                    <td>{{ $customer->value }}</td>
                                    <td>{{ $customer->extra }}</td>
                                    <td>
                                        @can("sell.update")
                                            <button data-href="{{action('Admin\ShipmentPriceController@edit', [$customer->id])}}" class="btn btn-xs main-bg-light text-white edit_campaigns_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                                            &nbsp;
                                        @endcan
                                        @can("sell.delete")
                                            <a href="{{action('Admin\ShipmentPriceController@destroy', [$customer->id])}}" class="btn btn-xs btn-danger delete_campaigns_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a>
                                        @endcan  
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