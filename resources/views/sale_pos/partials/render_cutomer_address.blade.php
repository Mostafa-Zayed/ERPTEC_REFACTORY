<div class="col-md-2">
	<div class="form-group">
	    {{--
	 {!! Form::label('country', __('sale.country') . ':') !!}
	 --}}
	 <input type="text" name="country" id="country" value="{{$address->country->country_name}}" class="form-control" readonly>
	</div>
</div>

<div class="col-md-2">
	<div class="form-group">
	 {{-- {!! Form::label('city', __('sale.city') . ':') !!} --}}
	 <input type="text" name="city" id="city" value="{{$address->city->name}}" class="form-control" readonly>
	</div>
</div>

<div class="col-md-6">
	<div class="form-group">
	 {{-- {!! Form::label('state', __('sale.address') . ':') !!} --}}
	 <input type="text" name="state" id="state" value="{{$address->state->name}}"  class="form-control" readonly>
	</div>
</div>
<div class="col-md-2">
   <div class="form-group">
     	<button type="button" class="btn btn-primary" id="edit-address" data-href="{{route('address.edit', ['id' => $address->id])}}"><i class="fas fa-edit"></i>@lang('lang_v1.edit_address')</button>
    </div>
</div>