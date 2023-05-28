@php
    $is_disabled = !empty($product->affilate_comm) ? $product->affilate_comm : 0;
    if(empty($product) && !empty($duplicate_product->affilate_comm)){
        $is_disabled = 0;
    }
@endphp
<div class="col-md-3">
	<div class="mb-5">
        <label>
            <!-- <input type="hidden" name="cscart_disable_sync" value="0">-->
          	 <strong>@lang('affilate::lang.affilate_commission')</strong>
          	 @show_tooltip(__('affilate::lang.affilate_commission_help'))
        </label>
        {!! Form::number('affilate_comm', $is_disabled, ['class' => 'form-control']); !!}
  	</div>
</div>
<div class="col-md-3">
	<div class="mb-5">
        <label>
            <!-- <input type="hidden" name="cscart_disable_sync" value="0">-->
            <strong>@lang('affilate::lang.affilate_commission_type')</strong>
            @show_tooltip(__('affilate::lang.affilate_commission_help'))
        </label>
        {!! Form::select('affilate_type', ['fixed'=> __('affilate::lang.fixed'),'percent'=> __('affilate::lang.percent')], 'fixed' , ['class' => 'form-control']); !!}
  	</div>
</div>