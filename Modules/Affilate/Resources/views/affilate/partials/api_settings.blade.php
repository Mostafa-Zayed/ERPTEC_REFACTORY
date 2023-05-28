<div class="pos-tab-content">
    <div class="row">
    	<div class="col-xs-4">
            <div class="form-group">
            	{!! Form::label('cscart_app_url',  __('cscart::lang.cscart_app_url') . ':') !!}
            	{!! Form::text('cscart_app_url', $default_settings['cscart_app_url'], ['class' => 'form-control','placeholder' => __('cscart::lang.cscart_app_url')]); !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
                {!! Form::label('cscart_consumer_key',  __('cscart::lang.email') . ':') !!}
                {!! Form::text('cscart_consumer_key', $default_settings['cscart_consumer_key'], ['class' => 'form-control','placeholder' => __('cscart::lang.cscart_consumer_key')]); !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="form-group">
            	{!! Form::label('cscart_consumer_secret', __('cscart::lang.api_key') . ':') !!}
                <input type="password" name="cscart_consumer_secret" value="{{$default_settings['cscart_consumer_secret']}}" id="cscart_consumer_secret" class="form-control">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-xs-4">
            <div class="form-group">
                {!! Form::label('location_id',  __('business.business_locations') . ':') !!} @show_tooltip(__('cscart::lang.location_dropdown_help'))
                {!! Form::select('location_id', $locations, $default_settings['location_id'], ['class' => 'form-control']); !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="checkbox">
                <label>
                    <br/>
                    {!! Form::checkbox('enable_auto_sync', 1, !empty($default_settings['enable_auto_sync']), ['class' => 'input-icheck'] ); !!} @lang('cscart::lang.enable_auto_sync')
                </label>
                @show_tooltip(__('cscart::lang.auto_sync_tooltip'))
            </div>
        </div>
    </div>
</div>