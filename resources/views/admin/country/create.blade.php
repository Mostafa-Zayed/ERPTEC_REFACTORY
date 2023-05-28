<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\CountryController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.Country' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('country_name', __( 'sale.Country' ) . ':*') !!}
          {!! Form::text('country_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name' ) ]); !!}
      </div> 
      
      <div class="form-group">
        {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
          {!! Form::text('name_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name_ar' ) ]); !!}
      </div>  
      <div class="form-group">
        {!! Form::label('phonecode', __( 'sale.phone_code' ) . ':*') !!}
          {!! Form::text('phonecode', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.phone_code' ) ]); !!}
      </div>
      <div class="form-group">
        {!! Form::label('country_code', __( 'sale.country_code' ) . ':*') !!}
          {!! Form::text('country_code', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.country_code' ) ]); !!}
      </div> 
      
    
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->