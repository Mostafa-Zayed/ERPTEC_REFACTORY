@extends('layouts.app')
@section('title', __('shop::lang.shop_module'))

@section('content')
    @include('shop::layouts.nav')
    <section class="content">
        <div class="main-bg mt-4">
            <div class="section-body">
                <div class="row">
                    <div class="col-sm-12">
                        @if(auth()->user()->can('shop.syc_categories') )
                        <div class="col-md-6">
                            <div class="col-sm-12">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tags"></i>
                                        <h3 class="box-title">@lang('woocommerce::lang.sync_product_categories'):</h3>
                                    </div>
                                    <div class="box-body">
                                        @if(!empty($alerts['categories']))
                                        <div class="col-sm-12">
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <ul>
                                                    @if(!empty($alerts['categories']['create']))
                                                        <li>{{$alerts['categories']['create']}}</li>
                                                    @endif
                                                    @if(!empty($alerts['categories']['updated']))
                                                        <li>{{$alerts['categories']['updated']}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-warning btn-block" id="update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <br>
                                        <div class="col-sm-6 mt-3">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                            <button type="button" class="btn btn-danger btn-xs" id="reset_categories">
                                                <i class="fa fa-undo"></i> @lang('woocommerce::lang.reset_synced_cat')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(auth()->user()->can('shop.syc_brands') )
                        <div class="col-md-6">
                            <div class="col-sm-12">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tags"></i>
                                        <h3 class="box-title">@lang('shop::lang.sync_brands'):</h3>
                                    </div>
                                    <div class="box-body">
                                        @if(!empty($alerts['brands']))
                                        <div class="col-sm-12">
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <ul>
                                                    @if(!empty($alerts['brands']['create']))
                                                        <li>{{$alerts['brands']['create']}}</li>
                                                    @endif
                                                    @if(!empty($alerts['brands']['updated']))
                                                        <li>{{$alerts['brands']['updated']}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-warning btn-block" id="update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <br>
                                        <div class="col-sm-6 mt-3">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                            <button type="button" class="btn btn-danger btn-xs" id="reset_categories">
                                                <i class="fa fa-undo"></i> @lang('woocommerce::lang.reset_synced_cat')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        @if(auth()->user()->can('shop.sync_taxs') )
                        <div class="col-md-6">
                            <div class="col-sm-12">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tags"></i>
                                        <h3 class="box-title">@lang('shop::lang.sync_taxs'):</h3>
                                    </div>
                                    <div class="box-body">
                                        @if(!empty($alerts['taxs']))
                                        <div class="col-sm-12">
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <ul>
                                                    @if(!empty($alerts['taxs']['create']))
                                                        <li>{{$alerts['taxs']['create']}}</li>
                                                    @endif
                                                    @if(!empty($alerts['taxs']['updated']))
                                                        <li>{{$alerts['taxs']['updated']}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-warning btn-block" id="update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <br>
                                        <div class="col-sm-6 mt-3">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                            <button type="button" class="btn btn-danger btn-xs" id="reset_categories">
                                                <i class="fa fa-undo"></i> @lang('woocommerce::lang.reset_synced_cat')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(auth()->user()->can('shop.sync_products') )
                        <div class="col-md-6">
                            <div class="col-sm-12">
                                <div class="box box-solid">
                                    <div class="box-header">
                                        <i class="fa fa-tags"></i>
                                        <h3 class="box-title">@lang('shop::lang.sync_products'):</h3>
                                    </div>
                                    <div class="box-body">
                                        @if(!empty($alerts['products']))
                                        <div class="col-sm-12">
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <ul>
                                                    @if(!empty($alerts['brands']['create']))
                                                        <li>{{$alerts['brands']['create']}}</li>
                                                    @endif
                                                    @if(!empty($alerts['brands']['updated']))
                                                        <li>{{$alerts['brands']['updated']}}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-warning btn-block" id="update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <br>
                                        <div class="col-sm-6 mt-3">
                                            <button type="button" class="btn btn-primary btn-block" id="sync_update_categories">
                                                <i class="fa fa-refresh"></i>@lang('woocommerce::lang.sync')
                                            </button>
                                            <span class="last_sync_cat"></span>
                                        </div>
                                        <div class="col-sm-12">
                                            <br>
                                            <button type="button" class="btn btn-danger btn-xs" id="reset_categories">
                                                <i class="fa fa-undo"></i> @lang('woocommerce::lang.reset_synced_cat')
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection