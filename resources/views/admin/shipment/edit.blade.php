<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentController@update', [$brand->id]), 'method' => 'post', 'id' => 'campaigns_edit_form','files'=> true ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.Shipping company' )</h4>
    </div>

    <div class="modal-body">
           <div class="form-group">
        {!! Form::label('user_id', __( 'sale.carrier_agent_users' ) . ':') !!}
       {!! Form::select('user_id', $carriers, $brand->user_id, ['class' => 'form-select select2', 'style' => 'width:100%']); !!}
      </div>  
      <div class="form-group">
        {!! Form::label('name', __( 'sale.name' ) . ':*') !!}
          {!! Form::text('name', $brand->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name' ) ]); !!}
      </div> 
      
      <div class="form-group">
        {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
          {!! Form::text('name_ar', $brand->name_ar, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name_ar' ) ]); !!}
      </div>  
    <div class="form-group">
        {!! Form::label('desc', __( 'sale.description' ) . ':*') !!}
          {!! Form::textarea('desc', $brand->desc, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.description' ) ]); !!}
      </div>   
      <div class="form-group">
        {!! Form::label('desc_ar', __( 'sale.description_ar' ) . ':*') !!}
          {!! Form::textarea('desc_ar', $brand->desc_ar, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.description_ar' ) ]); !!}
      </div>  
   
      <div class="form-group">
        {!! Form::label('phone', __( 'sale.phone' ) . ':*') !!}
          {!! Form::text('phone', $brand->phone, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.phone' ) ]); !!}
      </div>  
    
    
        <!--<div class="form-group">-->
        <!--    {!! Form::label('photo', __('lang_v1.ship_image') . ':') !!}-->
        <!--    {!! Form::file('photo', ['id' => 'upload_image', 'accept' => 'image/*']); !!}-->
        <!--    <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>-->
        <!--  </div>-->
       
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
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