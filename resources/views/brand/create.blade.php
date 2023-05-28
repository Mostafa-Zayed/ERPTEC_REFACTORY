<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('BrandController@store'), 'method' => 'post', 'id' => $quick_add ? 'quick_add_brand_form' : 'brand_add_form', 'files' => true]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'brand.add_brand' )</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            
            {{--
            <div class="mb-3">
                @input(['type' => 'text','name' => 'name','label' => true])
                    __( 'brand.brand_name' )
                @input
            </div>
            --}}
            <div class="mb-3">
                {!! Form::label('name', __( 'brand.brand_name' ) . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'brand.brand_name' ) ]); !!}
            </div>
            
            <div class="mb-3">
                {!! Form::label('name_ar', __( 'brand.brand_name' ) . ':*') !!}
                {!! Form::text('name_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'brand.brand_name' ) ]); !!}
            </div>
            
            <div class="mb-3">
                {!! Form::label('description', __( 'brand.short_description' ) . ':') !!}
                {!! Form::text('description', null, ['class' => 'form-control','placeholder' => __( 'brand.short_description' )]); !!}
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn btn-primary center-block more_btn" data-target="#more_div">@lang('lang_v1.shop_info') <i class="fa fa-chevron-down"></i></button>
            </div>
            <div id="more_div" class="hide">
                
                <div class="col-md-12"><hr/></div>
                  
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('logo', __('lang_v1.image') . ' :') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                {!! Form::file('logo',['class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('meta_title', __('contact.meta_title') . ':') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                {!! Form::text('meta_title', null, ['class' => 'form-control', 'placeholder' => __('contact.meta_title')]); !!}
                            </div>
                        </div>
                    </div>    
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('meta_description', __('contact.meta_description') . ':') !!}
                            <div class="input-group">
                                {!! Form::textarea('meta_description', null,['rows' => 100 ,'cols' => 100,'class' => 'form-control','style' => 'min-height: 100px;']) !!}
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn main-bg-dark text-white">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->