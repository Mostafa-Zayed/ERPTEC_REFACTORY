<div class="pos-tab-content">
    <div class="row">
    	<div class="col-lg-4 col-md-6">
            <div class="form-group">
            	{!! Form::label('website_app_url',  __('lang_v1.website_app_url') . ':') !!}
            	{!! Form::text('website_app_url', $default_settings['website_app_url'], ['class' => 'form-control','placeholder' => __('lang_v1.website_app_url')]); !!}
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                {!! Form::label('website_app_code',  __('lang_v1.website_app_code') . ':') !!}
                {!! Form::text('website_app_code', $default_settings['website_app_code'], ['class' => 'form-control','placeholder' => __('lang_v1.website_app_code')]); !!}
            </div>
        </div> 
       <div class="col-lg-4 col-md-6 ">
            <div class="form-group">
                {!! Form::label('order_url',  __('lang_v1.order_url') . ':') !!} @show_tooltip(__('lang_v1.order_url_to_sync_new_order_to_erp'))
                {!! Form::text('order_url', $order_url,  ['class' => 'form-control','readonly']); !!}
            </div>
        </div><!-- -->
 <!--       <div class="col-lg-4 col-md-6">
            <div class="form-group">
            	{!! Form::label('website_app_secret', __('lang_v1.website_app_secret') . ':') !!}
                <input type="password" name="website_app_secret" value="{{$default_settings['website_app_secret']}}" id="website_app_secret" class="form-control">
            </div>
        </div>
        <div class="clearfix"></div>
      
        <div class="col-lg-4 col-md-6">
            <div class="checkbox">
                <label>
                    <br/>
                    {!! Form::checkbox('enable_auto_sync', 1, !empty($default_settings['enable_auto_sync']), ['class' => 'input-icheck'] ); !!} @lang('woocommerce::lang.enable_auto_sync')
                </label>
                @show_tooltip(__('woocommerce::lang.auto_sync_tooltip'))
            </div>
        </div>-->
    </div>
</div>