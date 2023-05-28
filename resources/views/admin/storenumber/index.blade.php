@extends('layouts.app')
@section('title', 'store number')

@section('content')

@include('layouts.navs.products_nav')
{{--
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'sale.store_number' )
      
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
--}}
<!-- Main content -->
<section class="content">
    {{--@component('components.widget', ['class' => 'box-primary', 'title' => __( 'sale.all_store_number' )])--}}
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between flex-wrap">
            <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> {{__( 'sale.all_store_number')}}</h4>
            @can('sell.view')
                <button type="button" class="main-dark-btn btn-modal" 
                        data-href="{{action('StoreNumberController@create')}}" 
                        data-container=".campaigns_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
            @endcan
        </div>
        <div class="default-box-body">
            @can('sell.view')
                <div class="table-responsive">
                    <table class="main_light_table table table-bordered table-striped" id="trafic_table">
                        <thead>
                            <tr>
                                <th>@lang( 'sale.name' )</th>
                                <th>@lang( 'sale.name_ar' )</th>
                                <th>@lang( 'sale.value' )</th>
                                <th>@lang( 'lang_v1.location_name' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                        <tbody>
                             @foreach ($brands as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->name_ar }}</td>
                                    <td>{{ $customer->value }}</td>
                                    <td>{{ isset($customer->location->name) ?  $customer->location->name  : $customer->location_id  }}</td>
                                    <td>
                                       @can("sell.update")
                                        <button data-href="{{action('StoreNumberController@edit', [$customer->id])}}" class="btn main-bg-light text-white edit_campaigns_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                                            &nbsp;
                                        @endcan
                                        @can("sell.delete")
                                            <a href="{{action('StoreNumberController@destroy', [$customer->id])}}" class="btn btn-danger delete_campaigns_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</a>
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