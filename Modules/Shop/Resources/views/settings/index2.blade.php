@extends('layouts.app')
@section('title', __('shop::lang.shop_module'))

@section('content')
    @include('shop::layouts.nav')
    <section class="content-header">
        <h1>@lang('shop::lang.access_api_settings')</h1>
    </section>
    <section class="content">
    {!! Form::open(['url' => route('shop.settings.store')])!!}
    <div class="row">
        <div class="col-xs-12">
           <!--  <pos-tab-container> -->
            <div class="col-xs-12 pos-tab-container">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pos-tab-menu">
                    <div class="list-group">
                        <a href="#" class="list-group-item text-center active">@lang('woocommerce::lang.instructions')</a>
                        <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.api_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('shop::lang.variation_sync_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('shop::lang.categories_sync_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.product_sync_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.order_sync_settings')</a>
                        <a href="#" class="list-group-item text-center">@lang('woocommerce::lang.webhook_settings')</a>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 pos-tab">
                   @include('shop::settings.api_instructions')
                   @include('shop::settings.configration')
                </div>
            </div>

            <div class="col-xs-12">
                
            </div>
            <!--  </pos-tab-container> -->
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="form-group pull-right">
            {{Form::submit('update', ['class'=>"btn btn-danger"])}}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection