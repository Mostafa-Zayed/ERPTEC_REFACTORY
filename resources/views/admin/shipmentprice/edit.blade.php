<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentPriceController@update', [$brand->id]), 'method' => 'post', 'id' => 'campaigns_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.City' )</h4>
    </div>

      <div class="modal-body">
      <div class="form-group">
        {!! Form::label('shipment_id', __( 'sale.shipment' ) . ':*') !!}
          {!! Form::select('shipment_id', $shipments,$brand->shipment_id, ['class' => 'form-select select2', 'required' ]); !!}
      </div>
      
     <div class="form-group">
        {!! Form::label('to', __( 'sale.zone' ) . ':*') !!}
          {!! Form::select('to', $zones,$brand->to, ['class' => 'form-select select2', 'required' ]); !!}
      </div> 
    
     
     <div class="form-group">
        {!! Form::label('value', __( 'sale.price' ) . ':*') !!}
          {!! Form::text('value', $brand->value, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.value' ) ]); !!}
      </div>
      <div class="form-group">
        {!! Form::label('shipping_cost', __( 'sale.shipping_cost' ) . ':*') !!}
          {!! Form::text('shipping_cost', $brand->shipping_cost, ['class' => 'form-control',  'placeholder' => __( 'sale.shipping_cost' ) ]); !!}
      </div>  
      <div class="form-group">
        {!! Form::label('extra', __( 'sale.extra' ) . ':*') !!}
          {!! Form::text('extra', $brand->extra, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.extra' ) ]); !!}
      </div>  
    
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->