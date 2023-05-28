@extends('layouts.app')

@section('title', __('affilate::lang.affilate_products'))
@section('content')
<style>
    .col-sm-6{
        /*float: unset;*/
    }
    .w-100{
        width: 100%;
    }
    .all-affiliate-products .affiliate-prod-box{
        margin-bottom: 16px;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img{
        position: relative;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img img{
        height: 250px;
        object-fit: contain;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img span{
        position: absolute;
        font-size: 11px;
        top: 10px;
        color: #fff;
        padding: 3px 6px;
        border-radius: 5px;
        box-shadow: 0px 2px 4px rgb(0 0 0 / 40%);
        font-weight: 600;
        letter-spacing: 1px;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-availability{
        background: #2dce89;
        left: 10px;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-availability.out{
        background: #f5365c
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-commission{
        background: #ffad46;
        right: 10px;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-info{
        padding-inline: 10px;
        padding-bottom: 8px;
    }
    .justify-content-between{
        justify-content: space-between;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-info h4{
        text-align: center;
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 15px;
        height: 33px;
        overflow: hidden;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-info .affiliate-price{
        font-weight: 700;
        font-size: 20px;
        color: #143250;
        display: block;
        text-align: center;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-info .affiliate-sku{
        text-align: center;
        font-size: 15px;
        font-weight: 600;
    }
    .all-affiliate-products .affiliate-prod-box .affiliate-info div span{
        font-size: 16px;
        font-weight: 600;
    }
    @media only screen and (max-width: 1320px) and (min-width: 1199px){
        .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-availability{
            left: 5px;
            font-size: 11px;
        }
        .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-commission{
            right: 5px;
            font-size: 11px;
        }
    }
    @media only screen and (max-width: 281px){
        .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-availability,
        .all-affiliate-products .affiliate-prod-box .affiliate-img .affiliate-commission{
            font-size: 11px;
        }
    }
</style>
 
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ __('affilate::lang.affilate_products') }}</h1>
</section>
<section class="content no-print">
    <div class="all-affiliate-products">
        <div class="row">
            @if($affiliate_products)
                @foreach($affiliate_products as $aff_prod)
                <div class='col-lg-3 col-md-4 col-sm-6'>
                    <div class="affiliate-prod-box bg-white">
                        <div class="affiliate-img">
                            @if(count($aff_prod->media) > 0)
        						<img src="{{asset('/uploads/media/' . rawurlencode($aff_prod->media->first()->file_name))}}" class="w-100">
        					@elseif(!empty($aff_prod->product_image))
        						<img src="{{asset('/uploads/img/' . rawurlencode($aff_prod->product_image))}}" class="w-100">
        					@else
        						<img src="{{asset('/img/default.png')}}" class="w-100">
        					@endif
                            @if($aff_prod->enable_stock == 1)
                                <span class="affiliate-availability">{{ __('affilate::lang.Available') }}</span>
                            @else
                                <span class="affiliate-availability out">{{ __('affilate::lang.Out_of_stock') }}</span>
                            @endif
                            <span class="affiliate-commission">  {{ __('affilate::lang.Commision') }}: @if($aff_prod->affilate_type == 'fixed') {{$aff_prod->affilate_comm}} {{ $business->currency->symbol}} @else {{$aff_prod->affilate_comm}} % @endif</span>
                        </div>
                        <div class="affiliate-info">
                            <h4>{{ $aff_prod->name }}</h4>
                            <small>
                                
                            </small>
                            <span class="affiliate-price">{{number_format($aff_prod->sell_price_inc_tax,2)}} {{ $business->currency->symbol}}</span>
                            <h6 class="affiliate-sku">{{ __('product.sku') }}: {{ $aff_prod->sub_sku }}</h6>
                            <div class="d-flex align-items-center justify-content-between mt-2" style="height: 25px">
                                <span>
                                    @if($aff_prod->type == 'variable')
                        				 {{$aff_prod->variation}}
                        			@endif
                                </span>
                                <span>
                                    @if($aff_prod->type == 'variable')
                                        {{$aff_prod->vp}}
                        			@endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
{{$affiliate_products}}
    </div>
</section>
@endsection
@section('javascript')

@endsection    
    
    
  


