<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentController@updateimage', [$id]), 'method' => 'post', 'id' => '','files'=> true ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.update_shipping_image' )</h4>
    </div>

    <div class="modal-body">
      
    
    
        <div class="form-group">
            {!! Form::label('photo', __('lang_v1.ship_image') . ':') !!}
            {!! Form::file('photo', ['id' => 'upload_image', 'accept' => 'image/*']); !!}
            <small><p class="help-block">@lang('purchase.max_file_size', ['size' => (config('constants.document_size_limit') / 1000000)]) <br> @lang('lang_v1.aspect_ratio_should_be_1_1')</p></small>
          </div>
       
     
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
            image: { width: 'auto', height: 'auto', 'max-width': '100%', 'height': '100%' },
        },
    };
              $('#upload_image').fileinput(img_fileinput_setting);
        });
    </script>

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->