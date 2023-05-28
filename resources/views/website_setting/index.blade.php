@extends('layouts.app')
@section('title', __('business.business_locations'))

@section('content')

<!-- Content Header (Page header) -->
{{--
<section class="content-header">
    <h1>@lang( 'business.business_locations' )
        <small>@lang( 'business.manage_your_business_locations' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
--}}
<!-- Main content -->
<section class="content">
    {{--@component('components.widget', ['class' => 'box-primary', 'title' => __( 'business.all_your_business_locations' )])--}}
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between">
            <h4><i class="fas fa-filter"></i> {{__( 'business.all_your_business_locations' )}}</h4>
            <button type="button" class="main-dark-btn btn-modal" data-href="{{action('BusinessLocationController@create')}}" data-container=".location_add_modal">
                <i class="fa fa-plus"></i> @lang( 'messages.add' )
            </button>
        </div>
        <div class="default-box-body">
            <div class="table-responsive">
                <table class="main_light_table table table-bordered table-striped" id="business_location_tables">
                    <thead>
                        <tr>
                            <th>@lang( 'invoice.name' )</th>
                            <th>@lang( 'lang_v1.website_app_url' )</th>
                            <th>@lang( 'lang_v1.website_app_code' )</th>
                      
              
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($locations as $location)
                        @php
                      
                        @endphp
                        
                        <tr>
                            <td>{{$location->name}}</td>
                            <td>{{$location->website_app_url}}</td>
                            <td>{{$location->website_app_code}}</td>
                     
              
                            <td> 
                            @can('role.activeStore')
                            <a href="{{action('WebsiteController@apiSettings', [$location->id])}}" class="btn main-bg-light text-white btn-xs"><i class="fa fa-wrench"></i> @lang("messages.apiSettings")</a> 
                            <a href="{{action('WebsiteController@indexx', [$location->id])}}" class="btn main-bg-dark text-white btn-xs"><i class="fa fa-wrench"></i> @lang("messages.sync")</a>
                            @endcan
                            
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--@endcomponent--}}

    <div class="modal fade location_add_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>
    <div class="modal fade location_edit_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script>
 
   
</script>
@endsection
