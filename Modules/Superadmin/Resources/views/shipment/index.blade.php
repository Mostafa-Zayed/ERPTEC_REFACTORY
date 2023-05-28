@extends('layouts.app')
@section('title', __('superadmin::lang.superadmin') . ' | ' . __('superadmin::lang.packages'))

@section('content')
	@include('superadmin::layouts.nav')
	<section class="content-header">
		<h1>
			@lang('superadmin::lang.welcome_superadmin')
		</h1>
	</section>
	<section class="content">
	    <div class="row">
	        <div class="col-lg-4 col-xs-6">
	            <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3><span class="new_subscriptions">&nbsp;</span></h3>

	              <p>@lang('superadmin::lang.countries')</p>
	            </div>
	            <div class="icon">
	              <i class="fa fa-refresh"></i>
	            </div>
	            <a href="{{route('superadmin.shipment.country')}}" class="small-box-footer">@lang('superadmin::lang.more_info') <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        
	        <div class="col-lg-4 col-xs-6">
	            <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3><span class="new_subscriptions">&nbsp;</span></h3>

	              <p>@lang('superadmin::lang.countries')</p>
	            </div>
	            <div class="icon">
	              <i class="fa fa-refresh"></i>
	            </div>
	            <a href="{{route('superadmin.shipment.country')}}" class="small-box-footer">@lang('superadmin::lang.more_info') <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	    </div>
	</section>    
@endsection	

