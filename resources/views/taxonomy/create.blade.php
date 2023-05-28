<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('TaxonomyController@store'), 'method' => 'post', 'id' => 'category_add_form', 'files' => true ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'messages.add' )</h4>
    </div>

    <div class="modal-body">
        <div class="row">
      <input type="hidden" name="category_type" value="{{$category_type}}">
      @php
        $name_label = !empty($module_category_data['taxonomy_label']) ? $module_category_data['taxonomy_label'] : __( 'category.category_name' );
        $cat_code_enabled = isset($module_category_data['enable_taxonomy_code']) && !$module_category_data['enable_taxonomy_code'] ? false : true;

        $cat_code_label = !empty($module_category_data['taxonomy_code_label']) ? $module_category_data['taxonomy_code_label'] : __( 'category.code' );

        $enable_sub_category = isset($module_category_data['enable_sub_taxonomy']) && !$module_category_data['enable_sub_taxonomy'] ? false : true;

        $category_code_help_text = !empty($module_category_data['taxonomy_code_help_text']) ? $module_category_data['taxonomy_code_help_text'] : __('lang_v1.category_code_help');
      @endphp
      <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('name', $name_label . ':*') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => $name_label]); !!}
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('name_ar', $name_label . ':*') !!}
              {!! Form::text('name_ar', null, ['class' => 'form-control', 'required', 'placeholder' => __('lang_v1.category_name_ar')]); !!}
          </div>    
      </div>
      
      <div class="col-md-6">
          <div class="form-group">
                {!! Form::label('description', __( 'lang_v1.description' ) . ':') !!}
                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __( 'lang_v1.description'), 'rows' => 3, 'style' => 'min-height: 80px;']); !!}
            </div>
      </div>
      <div class="col-md-6">
          <div class="form-group">
                {!! Form::label('description_ar', __( 'lang_v1.description_ar' ) . ':') !!}
                {!! Form::textarea('description_ar', null, ['class' => 'form-control', 'placeholder' => __( 'lang_v1.description_ar'), 'rows' => 3, 'style' => 'min-height: 80px;']); !!}
            </div>
      </div>
      @if($cat_code_enabled)
      <div class="form-group">
        {!! Form::label('short_code', $cat_code_label . ':') !!}
        {!! Form::text('short_code', null, ['class' => 'form-control', 'placeholder' => $cat_code_label]); !!}
        <p class="help-block">{!! $category_code_help_text !!}</p>
      </div>
      @endif
      
      @if(!empty($parent_categories) && $enable_sub_category)
        <div class="form-group">
            <div class="checkbox">
              <label>
                 {!! Form::checkbox('add_as_sub_cat', 1, false,[ 'class' => 'toggler', 'data-toggle_id' => 'parent_cat_div' ]); !!} @lang( 'lang_v1.add_as_sub_txonomy' )
              </label>
            </div>
        </div>
        <div class="form-group hide" id="parent_cat_div">
          {!! Form::label('parent_id', __( 'category.select_parent_category' ) . ':') !!}
          {!! Form::select('parent_id', $parent_categories, null, ['class' => 'form-control']); !!}
        </div>
      @endif
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
                            {!! Form::label('ordering_number', __('contact.ordering_number') . ':') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                {!! Form::text('order_level', null, ['class' => 'form-control', 'placeholder' => __('contact.ordering_number')]); !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('banner', __('contact.banner') . ':') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                {!! Form::file('banner',['class' => 'form-control']); !!}
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('icon', __('contact.icon') . ':') !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                {!! Form::file('icon',['class' => 'form-control']); !!}
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
                
                {{--
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('commetion_rate', __('contact.commetion_rate') . ':') !!}
                        <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-info"></i>
                          </span>
                          {!! Form::text('commetion_rate', null, ['class' => 'form-control', 'placeholder' => __('contact.commetion_rate')]); !!}
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('type', __('contact.type') . ':') !!}
                        <div class="input-group">
                          <span class="input-group-addon">
                              <i class="fa fa-info"></i>
                          </span>
                          {!! Form::text('type', null, ['class' => 'form-control', 'placeholder' => __('contact.type')]); !!}
                        </div>
                    </div>
                </div>
                
                --}}
            </div>    
        </div>    
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->