<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentPriceController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.City' )</h4>
    </div>
        <input type="hidden" name="business_id" value="{{Request()->session()->get('user.business_id')}}">
    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('shipment_id', __( 'sale.shipment' ) . ':*') !!}
          {!! Form::select('shipment_id', $shipments,null, ['class' => 'form-select select2', 'required' ]); !!}
      </div>
      
     <div class="form-group">
        {!! Form::label('to', __( 'sale.zone' ) . ':*') !!}
          {!! Form::select('to', $zones,null, ['class' => 'form-select select2', 'required' ]); !!}
      </div> 
    
     
     <div class="form-group">
        {!! Form::label('value', __( 'sale.price' ) . ':*') !!}
          {!! Form::text('value', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.value' ) ]); !!}
      </div> 
      <div class="form-group">
        {!! Form::label('shipping_cost', __( 'sale.shipping_cost' ) . ':') !!}
          {!! Form::text('shipping_cost', 0, ['class' => 'form-control',  'placeholder' => __( 'sale.shipping_cost' ) ]); !!}
      </div>  
      <div class="form-group">
        {!! Form::label('extra', __( 'sale.extra' ) . ':*') !!}
          {!! Form::text('extra', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.extra' ) ]); !!}
      </div>  
    
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->