@extends('layouts.app')
@section('title', __('lang_v1.vowalaa_website'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('lang_v1.vowalaa_website')</h1>
</section>

<!-- Main content -->
<section class="content">
    @php
        $is_superadmin = auth()->user()->can('superadmin');
    @endphp
    <div class="row">
        @if(!empty($alerts['connection_failed']))
        <div class="col-sm-12">
            <div class="alert alert-danger alert-dismissible mb-4 ps-4">
                <button type="button" class="btn-close h-100 py-0 pe-4" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close"></button>
                <ul>
                    <li>{{$alerts['connection_failed']}}</li>
                </ul>
            </div>
        </div>
        @endif

        <div class="col-lg-6">
            <div class="hrm-box mb-5">
		        <div class="hrm-box-head bb-0">
		            <h4><img src="{{asset('new_assets/images/apps/packet.png')}}" class="me-3"> @lang('woocommerce::lang.sync_product_categories'):</h4>
		        </div>
		        <div class="hrm-box-body">
                    @if(!empty($alerts['not_synced_cat']) )
                        <div class="alert alert-warning alert-dismissible mb-0 ps-4">
                            <button type="button" class="btn-close h-100 py-0 pe-4" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close"></button>
                            <ul>
                                @if(!empty($alerts['not_synced_cat']))
                                    <li>{{$alerts['not_synced_cat']}}</li>
                                @endif
                              
                            </ul>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline mt-5">
                        <div>
                            {!! Form::open(['url' => action('WebsiteController@syncCategories'), 'id' => 'docus', 'method' => 'post']) !!}
                                {{ method_field('PUT') }}
                                <input type="hidden" value="{{$location->id}}" name="location" id="location">
                                <button type="submit" class="btn main-bg-light text-white" id="sync_product_"@if(count($category) == 0 ) disabled @endif > <i class="fas fa-sync me-2"></i> @lang('woocommerce::lang.sync')</button>
                                <span class="last_sync_cat d-block"></span>
                            {!! Form::close() !!}  
                        </div>
                        <div>
                            {!! Form::open(['url' => action('WebsiteController@syncedCategories'), 'id' => 'docused_cat', 'method' => 'post']) !!}
                                {{ method_field('PUT') }}
                                <input type="hidden" value="{{$location->id}}" name="location" >
                                <button type="submit" class="btn btn-danger" id=""> <i class="fas fa-redo me-2"></i> @lang('lang_v1.update_synced_cat')</button>
                            {!! Form::close() !!}   
                        </div>  
                    </div>
                </div>
           </div>
        </div>
        <div class="col-lg-6">
            <div class="hrm-box mb-5">
		        <div class="hrm-box-head bb-0">
		            <h4><img src="{{asset('new_assets/images/apps/packet.png')}}" class="me-3"> @lang('lang_v1.sync_brands'):</h4>
		        </div>
		        <div class="hrm-box-body">
                    @if(!empty($alerts['not_synced_brand']))
                        <div class="alert alert-warning alert-dismissible mb-0 ps-4">
                            <button type="button" class="btn-close h-100 py-0 pe-4" data-bs-dismiss="alert" data-dismiss="alert" aria-label="Close"></button>
                            <ul>
                                @if(!empty($alerts['not_synced_brand']))
                                    <li>{{$alerts['not_synced_brand']}}</li>
                                @endif
                               
                            </ul>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline mt-5">
                        <div>
                            {!! Form::open(['url' => action('WebsiteController@syncBrands'), 'id' => 'docusBrands', 'method' => 'post']) !!}
                                {{ method_field('PUT') }}
                                <input type="hidden" value="{{$location->id}}" name="location" id="location">
                                <button type="submit" class="btn main-bg-light text-white" id="sync_product_"@if(count($brand) == 0 ) disabled @endif > <i class="fas fa-sync me-2"></i> @lang('woocommerce::lang.sync')</button>
                                <span class="last_sync_cat d-block"></span>
                            {!! Form::close() !!} 
                        </div>
                        <div>
                            {!! Form::open(['url' => action('WebsiteController@syncedBrands'), 'id' => 'docused_Brands', 'method' => 'post']) !!}
                                {{ method_field('PUT') }}
                                <input type="hidden" value="{{$location->id}}" name="location" >
                                <button type="submit" class="btn btn-danger" id=""> <i class="fas fa-redo me-2"></i> @lang('lang_v1.update_synced_Brands')</button>
                            {!! Form::close() !!}   
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</section>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready( function() {
        syncing_text = '<i class="fas fa-sync me-2"></i> ' + "{{__('woocommerce::lang.syncing')}}...";
        update_sync_date();
       
 $("#docus").submit(function(e) {
            console.log('1111');
    e.preventDefault();
    var url = $('form#docus').attr('action');
    var method = $('form#docus').attr('method');
    var data = $('form#docus').serialize();
        console.log('2222');
        $(this).attr('disabled', true);
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
             console.log('3333');
            if (result.success) {
            
                console.log('dddd');
             
           //   window.location.reload(true);
            location.reload();
           
                toastr.success(result.msg);
              
            } else {
                toastr.error(result.msg);
            }
                  $('#sync_product_categories').html(btn_html);
                    $('#sync_product_categories').removeAttr('disabled');
                    $(window).unbind('beforeunload');
        }
    });
}); 


$("#docused_cat").submit(function(e) {
            console.log('1111');
    e.preventDefault();
    var url = $('form#docused_cat').attr('action');
    var method = $('form#docused_cat').attr('method');
    var data = $('form#docused_cat').serialize();
        console.log('2222');
        $(this).attr('disabled', true);
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
             console.log('3333');
            if (result.success) {
            
                console.log('dddd');
             
           //   window.location.reload(true);
          //  location.reload();
           
                toastr.success(result.msg);
              
            } else {
                toastr.error(result.msg);
            }
                  $('#sync_product_categories').html(btn_html);
                    $('#sync_product_categories').removeAttr('disabled');
                    $(window).unbind('beforeunload');
        }
    });
});

 $("#docusBrands").submit(function(e) {
            console.log('1111');
    e.preventDefault();
    var url = $('form#docusBrands').attr('action');
    var method = $('form#docusBrands').attr('method');
    var data = $('form#docusBrands').serialize();
        console.log('2222');
        $(this).attr('disabled', true);
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
             console.log('3333');
            if (result.success) {
            
                console.log('dddd');
             
           //   window.location.reload(true);
            location.reload();
           
                toastr.success(result.msg);
              
            } else {
                toastr.error(result.msg);
            }
                  $('#sync_product_categories').html(btn_html);
                    $('#sync_product_categories').removeAttr('disabled');
                    $(window).unbind('beforeunload');
        }
    });
}); 


$("#docused_Brands").submit(function(e) {
            console.log('1111');
    e.preventDefault();
    var url = $('form#docused_Brands').attr('action');
    var method = $('form#docused_Brands').attr('method');
    var data = $('form#docused_Brands').serialize();
        console.log('2222');
        $(this).attr('disabled', true);
    $.ajax({
        method: method,
        dataType: "json",
        url: url,
        data:data,
        success: function(result){
             console.log('3333');
            if (result.success) {
            
                console.log('dddd');
             
           //   window.location.reload(true);
          //  location.reload();
           
                toastr.success(result.msg);
              
            } else {
                toastr.error(result.msg);
            }
                  $('#sync_product_categories').html(btn_html);
                    $('#sync_product_categories').removeAttr('disabled');
                    $(window).unbind('beforeunload');
        }
    });
});


/* */
        //Sync Product Categories
       /* $('#sync_product_categories').click( function(){
            $(window).bind('beforeunload', function(){
                return true;
            });
            var btn_html = $(this).html(); 
          
            $(this).html(syncing_text); 
          //  $(this).attr('disabled', true);
            $.ajax({
                url: "{{action('WebsiteController@syncCategories',$location->id)}}",
                dataType: "json",
            
                timeout: 0,
                success: function(result){
                    if(result.success){
                        toastr.success(result.msg);
                        update_sync_date();
                    } else {
                        toastr.error(result.msg);
                    }
                    $('#sync_product_categories').html(btn_html);
                    $('#sync_product_categories').removeAttr('disabled');
                    $(window).unbind('beforeunload');
                }
            });          
        });*/

        //Sync Products
        $('.sync_products').click( function(){
            $(window).bind('beforeunload', function(){
                return true;
            });
            var btn = $(this);
            var btn_html = btn.html(); 
            btn.html(syncing_text); 
            btn.attr('disabled', true);
            var type = $(this).data('sync-type');

            $.ajax({
                url: "{{action('WebsiteController@syncProducts')}}?type=" + type,
                dataType: "json",
                timeout: 0,
                success: function(result){
                    if(result.success){
                        toastr.success(result.msg);
                        update_sync_date();
                    } else {
                        toastr.error(result.msg);
                    }
                    btn.html(btn_html);
                    btn.removeAttr('disabled');
                    $(window).unbind('beforeunload');
                }
            });          
        });

        //Sync Orders
        $('#sync_orders').click( function(){
            $(window).bind('beforeunload', function(){
                return true;
            });
            var btn = $(this);
            var btn_html = btn.html(); 
            btn.html(syncing_text); 
            btn.attr('disabled', true);

            $.ajax({
                url: "{{action('WebsiteController@syncOrders')}}",
                dataType: "json",
                timeout: 0,
                success: function(result){
                    if(result.success){
                        toastr.success(result.msg);
                        update_sync_date();
                    } else {
                        toastr.error(result.msg);
                    }
                    btn.html(btn_html);
                    btn.removeAttr('disabled');
                    $(window).unbind('beforeunload');
                }
            });            
        });
    });

    function update_sync_date() {
        $.ajax({
            url: "{{action('WebsiteController@getSyncLog')}}",
            dataType: "json",
            timeout: 0,
            success: function(data){
                if(data.categories){
                    $('span.last_sync_cat').html('<small>{{__("woocommerce::lang.last_synced")}}: ' + data.categories + '</small>');
                }
                if(data.new_products){
                    $('span.last_sync_new_products').html('<small>{{__("woocommerce::lang.last_synced")}}: ' + data.new_products + '</small>');
                }
                if(data.all_products){
                    $('span.last_sync_all_products').html('<small>{{__("woocommerce::lang.last_synced")}}: ' + data.all_products + '</small>');
                }
                if(data.orders){
                    $('span.last_sync_orders').html('<small>{{__("woocommerce::lang.last_synced")}}: ' + data.orders + '</small>');
                }
                
            }
        });     
    }

    //Reset Synced Categories
    $(document).on('click', 'button#reset_categories', function(){
        var checkbox = document.createElement("div");
        checkbox.setAttribute('class', 'checkbox');
        checkbox.innerHTML = '<label><input type="checkbox" id="yes_reset_cat"> {{__("woocommerce::lang.yes_reset")}}</label>';
        swal({
          title: LANG.sure,
          text: "{{__('woocommerce::lang.confirm_reset_cat')}}",
          icon: "warning",
          content: checkbox,
          buttons: true,
          dangerMode: true,
        }).then((confirm) => {
            if(confirm) {
                if($('#yes_reset_cat').is(":checked")) {
                    $(window).bind('beforeunload', function(){
                        return true;
                    });
                    var btn = $(this);
                    btn.attr('disabled', true);
                    $.ajax({
                        url: "{{action('WebsiteController@resetCategories')}}",
                        dataType: "json",
                        success: function(result){
                            if(result.success == true){
                                toastr.success(result.msg);
                            } else {
                                toastr.error(result.msg);
                            }
                            btn.removeAttr('disabled');
                            $(window).unbind('beforeunload');
                            location.reload();
                        }
                    });
                }
            }
        });
    });

    //Reset Synced products
    $(document).on('click', 'button#reset_products', function(){
        var checkbox = document.createElement("div");
        checkbox.setAttribute('class', 'checkbox');
        checkbox.innerHTML = '<label><input type="checkbox" id="yes_reset_product"> {{__("woocommerce::lang.yes_reset")}}</label>';
        swal({
          title: LANG.sure,
          text: "{{__('woocommerce::lang.confirm_reset_product')}}",
          icon: "warning",
          content: checkbox,
          buttons: true,
          dangerMode: true,
        }).then((confirm) => {
            if(confirm) {
                if($('#yes_reset_product').is(":checked")) {
                    $(window).bind('beforeunload', function(){
                        return true;
                    });
                    var btn = $(this);
                    btn.attr('disabled', true);
                    $.ajax({
                        url: "{{action('WebsiteController@resetProducts')}}",
                        dataType: "json",
                        success: function(result){
                            if(result.success == true){
                                toastr.success(result.msg);
                            } else {
                                toastr.error(result.msg);
                            }
                            btn.removeAttr('disabled');
                            $(window).unbind('beforeunload');
                            location.reload();
                        }
                    });
                }
            }
        });
    });

</script>
@endsection