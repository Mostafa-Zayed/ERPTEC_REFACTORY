<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentZoneController@update', [$brand->id]), 'method' => 'post', 'id' => 'campaigns_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.zones' )</h4>
    </div>

    <div class="modal-body">
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

    
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->