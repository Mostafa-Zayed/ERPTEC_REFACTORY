<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form2' , 'files' => true ]) !!}

     <input type="hidden" name="type" value="2">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.Shipping company' )</h4>
    </div>
        <input type="hidden" name="business_id" value="{{Request()->session()->get('user.business_id')}}">
    <div class="modal-body">
           <div class="form-group">
        {!! Form::label('user_id', __( 'sale.carrier_agent_users' ) . ':') !!}
       {!! Form::select('user_id', $carriers, null, ['class' => 'form-select select2', 'style' => 'width:100%']); !!}
      </div>  
      	<div class="form-group">
			    
			{!! Form::text('name',null, ['class' => 'form-control', 'style' => 'width:100%','placeholder' => __( 'sale.name' )]); !!}
			
			<input type="hidden" value="" name="selected_products" id="selected_products">
			
			</div>
      
        	<div class="form-group">
  
			 {!! Form::text('name_ar',null, ['class' => 'form-control', 'style' => 'width:100%','placeholder' => __( 'sale.name_ar' )]); !!}
			
			<input type="hidden" value="" name="selected_products" id="selected_products">
			
			</div>
			
	     <div class="form-group">
        {!! Form::label('desc', __( 'sale.description' ) . ':*') !!}
          {!! Form::textarea('desc', null, ['class' => 'form-control', 'placeholder' => __( 'sale.description' ) ]); !!}
      </div>  
      <div class="form-group">
            {!! Form::textarea('desc_ar', null, ['class' => 'form-control', 'placeholder' => __( 'sale.description_ar' ) ]); !!}
      </div>  
   
      <div class="form-group">
        {!! Form::label('phone', __( 'sale.phone' ) . ':*') !!}
          {!! Form::text('phone', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.phone' ) ]); !!}
      </div> 
      
      
          <div class="form-group">
            {!! Form::label('photo', __('lang_v1.ship_image') . ':') !!}
            {!! Form::file('photo', ['id' => 'upload_image', 'accept' => 'image/*']); !!}
            <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
          </div>
          
        
       
    
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}
    
    
    
     <script>
        $(document).ready( function () {
          
             
              var img_fileinput_setting = {
        showUpload: false,
        showPreview: true,
        browseLabel: LANG.file_browse_label,
        removeLabel: LANG.remove,
        previewSettings: {
            image: { width: 'auto', height: 'auto', 'max-width': '100%', 'max-height': '100%' },
        },
    };
              $('#upload_image').fileinput(img_fileinput_setting);
        });
    </script>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->