<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
  @php
    $form_id = 'contact_add_form';
    if(isset($quick_add)){
      $form_id = 'quick_add_contact';
    }

    if(isset($store_action)) {
      $url = $store_action;
      $type = 'lead';
      $customer_groups = [];
    } else {
      $url = action('ContactController@store');
      $type = isset($selected_type) ? $selected_type : '';
      $sources = [];
      $life_stages = [];
      $users = [];
    }
  @endphp
    {!! Form::open(['url' => $url, 'method' => 'post', 'id' => $form_id ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang('contact.add_contact')</h4>
    </div>

    <div class="modal-body">
       
        <div class="row"> 

            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('name', __('contact.name') . ':*') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!! Form::text('name', null, ['class' => 'form-control','placeholder' => __('contact.name'), 'required']); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('mobile', __('contact.mobile') . ':*') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-mobile"></i>
                        </span>
                        {!! Form::text('mobile', null, ['class' => 'form-control', 'required', 'placeholder' => __('contact.mobile')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('country_id', __('business.country') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-globe"></i>
                        </span>
                        
                        {!! Form::select('country_id', $countries,null, ['class' => 'form-control form-select select2','id' => 'country_id','placeholder' => __('business.country') ]); !!}
                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('city_id', __('business.state') . ':') !!} 
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        {!! Form::select('city_id', [],null, ['class' => 'form-control', 'id' => 'city_id','placeholder' => __('business.city')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('state_id', __('business.city') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-map-marker"></i>
                        </span>
                        {!! Form::select('state_id', [],null, ['class' => 'form-control', 'placeholder' => __('business.state')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 contact_type_div">
                <div class="form-group">
                    {!! Form::label('type', __('contact.contact_type') . ':*' ) !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        {!! Form::select('type', $types, $type , ['class' => 'form-control', 'id' => 'contact_type','placeholder' => __('messages.please_select'), 'required']); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 shipping_addr_div"><hr></div>
            
            <div class="col-md-8 shipping_addr_div" >
              <strong>{{__('business.landmark')}}</strong><br>
              {!! Form::text('landmark', null, ['class' => 'form-control', 
                    'placeholder' => __('business.landmark'), 'id' => 'landmark']); !!}
                <div id="map"></div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div style="margin-top: 20px;">
                    <button class="btn btn-success" type="button" id="contact-location-id">{{__('lang_v1.add_your_location')}}</button>
                        <input type='hidden' value=''  id='contact-location-value' name='location_map'/>
                        <input type='hidden' value='{{session('business.gps_required')}}'  id='gps_required'/>
                </div>
            </div> 
            
            <div class="col-md-12 shipping_addr_div"><hr></div>
            
            <div class="clearfix"></div>
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('supplier_business_name', __('business.business_name') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-briefcase"></i>
                        </span>
                        {!! Form::text('supplier_business_name', null, ['class' => 'form-control', 'placeholder' => __('business.business_name')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('landline', __('contact.landline') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </span>
                        {!! Form::text('landline', null, ['class' => 'form-control', 'placeholder' => __('contact.landline')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('alternate_number', __('contact.alternate_contact_number') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-phone"></i>
                        </span>
                        {!! Form::text('alternate_number', null, ['class' => 'form-control', 'placeholder' => __('contact.alternate_contact_number')]); !!}
                    </div>
                </div>
            </div>
            
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('email', __('business.email') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-envelope"></i>
                        </span>
                        {!! Form::email('email', null, ['class' => 'form-control','placeholder' => __('business.email')]); !!}
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('contact_id', __('lang_v1.contact_id') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-id-badge"></i>
                        </span>
                        {!! Form::text('contact_id', null, ['class' => 'form-control','placeholder' => __('lang_v1.contact_id')]); !!}
                    </div>
                    <p class="help-block">
                        @lang('lang_v1.leave_empty_to_autogenerate')
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    {!! Form::label('dob', __('lang_v1.dob') . ':') !!}
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        
                        {!! Form::text('dob', null, ['class' => 'form-control dob-date-picker','placeholder' => __('lang_v1.dob'), 'readonly']); !!}
                    </div>
                </div>
            </div>
            
            <div class="clearfix"></div>
    
            {{--
            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('prefix', __( 'business.prefix' ) . ':') !!}
                    {!! Form::text('prefix', null, ['class' => 'form-control', 'placeholder' => __( 'business.prefix_placeholder' ) ]); !!}
                </div>
            </div>
            --}}
    
            
        
        
        </div>
          
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary center-block more_btn" data-target="#more_div">@lang('lang_v1.more_info') <i class="fa fa-chevron-down"></i></button>
            </div>

            <div id="more_div" class="hide">
                {!! Form::hidden('position', null, ['id' => 'position']); !!}
                <div class="col-md-12"><hr/></div>

                <div class="col-md-4">
                    <div class="form-group">
                      {!! Form::label('tax_number', __('contact.tax_no') . ':') !!}
                        <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-info"></i>
                          </span>
                          {!! Form::text('tax_number', null, ['class' => 'form-control', 'placeholder' => __('contact.tax_no')]); !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 opening_balance">
                  <div class="form-group">
                      {!! Form::label('opening_balance', __('lang_v1.opening_balance') . ':') !!}
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fas fa-money-bill-alt"></i>
                          </span>
                          {!! Form::text('opening_balance', 0, ['class' => 'form-control input_number']); !!}
                      </div>
                  </div>
                </div>

                <div class="col-md-4 pay_term">
                  <div class="form-group">
                    <div class="multi-input">
                      {!! Form::label('pay_term_number', __('contact.pay_term') . ':') !!} @show_tooltip(__('tooltip.pay_term'))
                      <br/>
                      {!! Form::number('pay_term_number', null, ['class' => 'form-control width-40 pull-left', 'placeholder' => __('contact.pay_term')]); !!}

                      {!! Form::select('pay_term_type', ['months' => __('lang_v1.months'), 'days' => __('lang_v1.days')], '', ['class' => 'form-control width-60 pull-left','placeholder' => __('messages.please_select')]); !!}
                    </div>
                  </div>
                </div>
                
                <div class="clearfix"></div>
                
                <div class="col-md-4 customer_fields">
                    <div class="form-group">
                      {!! Form::label('customer_group_id', __('lang_v1.customer_group') . ':') !!}
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-users"></i>
                          </span>
                          {!! Form::select('customer_group_id', $customer_groups, '', ['class' => 'form-control']); !!}
                      </div>
                    </div>
                </div>
                
                <div class="col-md-4 customer_fields">
                    <div class="form-group">
                      {!! Form::label('customer_group_id', __('lang_v1.customer_group') . ':') !!}
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-users"></i>
                          </span>
                          {!! Form::select('customer_groups[]', $customer_groups, null, ['class' => 'form-select', 'style' => 'width:100%', 'multiple', 'id' => 'customer_groups']); !!}
                      </div>
                    </div>
                </div>
                
                @php
                  $common_settings = session()->get('business.common_settings');
                  $default_credit_limit = !empty($common_settings['default_credit_limit']) ? $common_settings['default_credit_limit'] : null;
                @endphp
                
                <div class="col-md-4 customer_fields">
                  <div class="form-group">
                      {!! Form::label('credit_limit', __('lang_v1.credit_limit') . ':') !!}
                      <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fas fa-money-bill-alt"></i>
                          </span>
                          {!! Form::text('credit_limit', $default_credit_limit ?? null, ['class' => 'form-control input_number']); !!}
                      </div>
                      <p class="help-block">@lang('lang_v1.credit_limit_help')</p>
                  </div>
                </div>
                

                <div class="col-md-12"><hr/></div>
                <div class="clearfix"></div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('address_line_1', __('lang_v1.address_line_1') . ':') !!}
                        {!! Form::text('address_line_1', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.address_line_1'), 'rows' => 3]); !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('address_line_2', __('lang_v1.address_line_2') . ':') !!}
                        {!! Form::text('address_line_2', null, ['class' => 'form-control', 'placeholder' => __('lang_v1.address_line_2'), 'rows' => 3]); !!}
                    </div>
                </div>
                <div class="clearfix"></div>
              
            
            
         
          
          
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('zip_code', __('business.zip_code') . ':') !!}
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-map-marker"></i>
                    </span>
                    {!! Form::text('zip_code', null, ['class' => 'form-control', 
                    'placeholder' => __('business.zip_code_placeholder')]); !!}
                </div>
            </div>
          </div>

          <div class="clearfix"></div>
          <div class="col-md-12">
            <hr/>
          </div>
          @php
            $custom_labels = json_decode(session('business.custom_labels'), true);
            $contact_custom_field1 = !empty($custom_labels['contact']['custom_field_1']) ? $custom_labels['contact']['custom_field_1'] : __('lang_v1.contact_custom_field1');
            $contact_custom_field2 = !empty($custom_labels['contact']['custom_field_2']) ? $custom_labels['contact']['custom_field_2'] : __('lang_v1.contact_custom_field2');
            $contact_custom_field3 = !empty($custom_labels['contact']['custom_field_3']) ? $custom_labels['contact']['custom_field_3'] : __('lang_v1.contact_custom_field3');
            $contact_custom_field4 = !empty($custom_labels['contact']['custom_field_4']) ? $custom_labels['contact']['custom_field_4'] : __('lang_v1.contact_custom_field4');
            $contact_custom_field5 = !empty($custom_labels['contact']['custom_field_5']) ? $custom_labels['contact']['custom_field_5'] : __('lang_v1.custom_field', ['number' => 5]);
            $contact_custom_field6 = !empty($custom_labels['contact']['custom_field_6']) ? $custom_labels['contact']['custom_field_6'] : __('lang_v1.custom_field', ['number' => 6]);
            $contact_custom_field7 = !empty($custom_labels['contact']['custom_field_7']) ? $custom_labels['contact']['custom_field_7'] : __('lang_v1.custom_field', ['number' => 7]);
            $contact_custom_field8 = !empty($custom_labels['contact']['custom_field_8']) ? $custom_labels['contact']['custom_field_8'] : __('lang_v1.custom_field', ['number' => 8]);
            $contact_custom_field9 = !empty($custom_labels['contact']['custom_field_9']) ? $custom_labels['contact']['custom_field_9'] : __('lang_v1.custom_field', ['number' => 9]);
            $contact_custom_field10 = !empty($custom_labels['contact']['custom_field_10']) ? $custom_labels['contact']['custom_field_10'] : __('lang_v1.custom_field', ['number' => 10]);
          @endphp
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field1', $contact_custom_field1 . ':') !!}
                {!! Form::text('custom_field1', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field1]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field2', $contact_custom_field2 . ':') !!}
                {!! Form::text('custom_field2', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field2]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field3', $contact_custom_field3 . ':') !!}
                {!! Form::text('custom_field3', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field3]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field4', $contact_custom_field4 . ':') !!}
                {!! Form::text('custom_field4', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field4]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field5', $contact_custom_field5 . ':') !!}
                {!! Form::text('custom_field5', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field5]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field6', $contact_custom_field6 . ':') !!}
                {!! Form::text('custom_field6', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field6]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field7', $contact_custom_field7 . ':') !!}
                {!! Form::text('custom_field7', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field7]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field8', $contact_custom_field8 . ':') !!}
                {!! Form::text('custom_field8', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field8]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field9', $contact_custom_field9 . ':') !!}
                {!! Form::text('custom_field9', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field9]); !!}
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('custom_field10', $contact_custom_field10 . ':') !!}
                {!! Form::text('custom_field10', null, ['class' => 'form-control', 
                    'placeholder' => $contact_custom_field10]); !!}
            </div>
          </div>
          <div class="col-md-12 shipping_addr_div"><hr></div>
          <div class="col-md-8 col-md-offset-2 shipping_addr_div" >
              <strong>{{__('lang_v1.shipping_address')}}</strong><br>
              {!! Form::text('shipping_address', null, ['class' => 'form-control', 
                    'placeholder' => __('lang_v1.search_address'), 'id' => 'shipping_address']); !!}
            <div id="map"></div>
          </div>
            </div>
        </div>
        @include('layouts.partials.module_form_part')
    </div>
    
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}
  
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

