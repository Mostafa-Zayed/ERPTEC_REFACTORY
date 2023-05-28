@extends('layouts.app')
@section('title', __('woocommerce::lang.api_settings'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('woocommerce::lang.api_settings')</h1>
</section>

<!-- Main content -->
<section class="content">
    

     {!! Form::open(['url' => action('WebsiteController@updateSettings', [$business->id]), 'method' => 'post' ]) !!}
    <div class="default-box p-0">
        <div class="default-box-body">
            <div class="row">
                <div class="col-md-3 col-4 pos-tab-menu">
                    <div class="list-group list-settings-group">
                        <a href="#" class="list-settings-item text-center active">@lang('woocommerce::lang.instructions')</a>
                        <a href="#" class="list-settings-item text-center">@lang('woocommerce::lang.api_settings')</a>
                     <!--  <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.product_sync_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.webhook_settings')</a>-->
                    </div>
                </div>
                <div class="col-md-9 col-8 pos-tab">
                    @include('website_setting.partials.api_instructions')
                    @include('website_setting.partials.api_settings')
                </div>
            </div>

            <div class="col-xs-12">
                <p class="help-block"><i>vowalaa E-commerce 2.8</i></p>
            </div>
            <!--  </pos-tab-container> -->
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-end">
            {{Form::submit('update', ['class'=>"main-dark-btn-lg"])}}
        </div>
    </div>
    {!! Form::close() !!}
</section>
@stop
@section('javascript')
@endsection