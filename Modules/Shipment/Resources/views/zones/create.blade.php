<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => route('shipment.zones.store'), 'method' => 'post', 'id' => 'zone_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'shipment::lang.zones' )</h4>
    </div>
        <input type="hidden" name="business_id" value="{{$business}}">
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('name', __( 'sale.name' ) . ':*') !!}
          {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __( 'sale.name' ) ]); !!}
      </div> 
      
      <div class="form-group">
        {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
          {!! Form::text('name_ar', null, ['class' => 'form-control', 'placeholder' => __( 'sale.name_ar' ) ]); !!}
      </div>  
    <div class="form-group">
        {!! Form::label('desc', __( 'sale.description' ) . ':*') !!}
          {!! Form::textarea('desc', null, ['class' => 'form-control', 'placeholder' => __( 'sale.description' ) ]); !!}
      </div>   
      <div class="form-group">
        {!! Form::label('desc_ar', __( 'sale.description_ar' ) . ':*') !!}
          {!! Form::textarea('desc_ar', null, ['class' => 'form-control', 'placeholder' => __( 'sale.description_ar' ) ]); !!}
      </div>  

    
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->