<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('StoreNumberController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_trafic_form' : 'campaigns_add_form', 'class' => 'add-product-form' ]) !!}

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">@lang( 'sale.shipping_type' )</h4>
            </div>
            <input type="hidden" name="business_id" value="{{Request()->session()->get('user.business_id')}}">
            <div class="modal-body">
                <div class="mb-3">
                    {!! Form::label('location_id',  __('purchase.business_location') . ':') !!}
                    {!! Form::select('location_id', $business_locations, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                </div> 
                <div class="mb-3">
                    {!! Form::label('name', __( 'sale.name' ) . ':*') !!}
                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name' ) ]); !!}
                </div> 
                <div class="mb-3">
                    {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
                    {!! Form::text('name_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name_ar' ) ]); !!}
                </div>  
                <div class="mb-3">
                    {!! Form::label('value', __( 'sale.value' ) . ':*') !!}
                    {!! Form::text('value', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.value' ) ]); !!}
                </div>  
            </div>
        
            <div class="modal-footer">
                <button type="submit" class="btn main-bg-dark text-white">@lang( 'messages.save' )</button>
                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
            </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->