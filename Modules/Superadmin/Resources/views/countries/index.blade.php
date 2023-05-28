@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
	@include('superadmin::layouts.nav')
	<section class="content-header">
		<h1>@lang( 'sale.Country' )</h1>
	</section>
	
	<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'sale.all_Country' )])
        @can('sell.view')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('Admin\CountryController@create')}}" 
                        data-container=".campaigns_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('sell.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="country_table">
                    <thead>
                        <tr>
                            <th>@lang( 'sale.name' )</th>
                            <th>@lang( 'sale.country code' )</th>
                            <th>@lang( 'sale.phonecode' )</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                    <tbody>
                             @foreach ($countries as $customer)
                                <tr>
                                    <td>{{ $customer->country_name }}</td>
                                    <td>{{ $customer->country_code }}</td>
                                    <td>{{ $customer->phonecode }}</td>
                          
                              
                                    <td>
                                       @can("sell.update")
                                        <button data-href="{{action('Admin\CountryController@edit', [$customer->id])}}" class="btn btn-xs btn-primary edit_campaigns_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                                            &nbsp;
                                        @endcan
                                        @can("sell.delete")
                                            <button data-href="{{action('Admin\CountryController@destroy', [$customer->id])}}" class="btn btn-xs btn-danger delete_campaigns_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                                        @endcan  
                                    </td>
                                </tr>
                            @endforeach
                            
                            
                            
                            </tbody>
                </table>
            </div>
        @endcan
    @endcomponent

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
            let countryTable = $('#country_table');
            console.log(countryTable);
        });
    </script>
@endsection