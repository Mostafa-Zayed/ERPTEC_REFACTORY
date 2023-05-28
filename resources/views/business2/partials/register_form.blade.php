@php
  
 $date_now = new \DateTime();
 
 $date = $date_now->format('d/m/Y');

@endphp

{!! Form::hidden('language', request()->lang); !!}
<fieldset>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('first_name', __('business.first_name') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                {!! Form::text('first_name', null, ['class' => 'form-control','placeholder' => __('business.first_name'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('last_name', __('business.last_name') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                {!! Form::text('last_name', null, ['class' => 'form-control','placeholder' =>  __('business.last_name')]); !!}
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('name', __('business.business_name') . ':*' ) !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-suitcase"></i></span>
                {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('business.business_name'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('username', __('business.username') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                {!! Form::text('username', null, ['class' => 'form-control','placeholder' => __('business.username'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('email', __('business.email') . ':') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                {!! Form::text('email', null, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('password', __('business.password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                {!! Form::password('password', ['class' => 'form-control','placeholder' => __('business.password'), 'required']); !!}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('confirm_password', __('business.confirm_password') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                {!! Form::password('confirm_password', ['class' => 'form-control','placeholder' => __('business.confirm_password'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('country', __('business.country') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                {!! Form::text('country', null, ['class' => 'form-control','placeholder' => __('business.country'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('currency_id', __('business.currency') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon"><i class="fas fa-money-bill-alt"></i></span>
                {!! Form::select('currency_id', $currencies, '', ['class' => 'form-control select2_register','placeholder' => __('business.currency_placeholder'), 'required']); !!}
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
        @if(!empty($system_settings['superadmin_enable_register_tc']))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('accept_tc', 0, false, ['required', 'class' => 'input-icheck']); !!}
                    <u>
                        <a class="terms_condition cursor-pointer" data-toggle="modal" data-target="#tc_modal">
                            @lang('lang_v1.accept_terms_and_conditions') <i></i>
                        </a>
                    </u>
                </label>
            </div>
            @include('business.partials.terms_conditions')
        @endif
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-6">
        <div class="form-group" style="display:none;">
            {!! Form::label('time_zone', __('business.time_zone') . ':*') !!}
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fas fa-clock"></i>
                </span>
                {!! Form::select('time_zone', $timezone_list, config('app.timezone'), ['class' => 'form-control select2_register','placeholder' => __('business.time_zone'), 'required']); !!}
            </div>
        </div>
    </div>
    
</fieldset>
<div class="col-md-6">
    <div class="forom-group">
        <input type="submit" value="Register" class="btn btn-primary"></div>
    </div>    
</div>    