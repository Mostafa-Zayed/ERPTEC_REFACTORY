<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentZoneController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.zones' )</h4>
    </div>
        <input type="hidden" name="business_id" value="{{Request()->session()->get('user.business_id')}}">
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('name', __( 'sale.name' ) . ':*') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name' ) ]); !!}
      </div> 
      
      <div class="form-group">
        {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
          {!! Form::text('name_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name_ar' ) ]); !!}
      </div>  
    <div class="form-group">
        {!! Form::label('desc', __( 'sale.description' ) . ':*') !!}
          {!! Form::textarea('desc', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.description' ) ]); !!}
      </div>   
      <div class="form-group">
        {!! Form::label('desc_ar', __( 'sale.description_ar' ) . ':*') !!}
          {!! Form::textarea('desc_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.description_ar' ) ]); !!}
      </div>  

    
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->