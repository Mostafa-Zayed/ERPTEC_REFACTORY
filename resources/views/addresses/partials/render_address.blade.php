<option value=" ">@lang('lang_v1.select_address')</option>
@forelse($addresses as $a)
<option value="{{$a->id}}" {{isset($transaction) && ($transaction == $a->id) ? 'selected' :  '' }}>{{$a->name}}</option>

@empty
<option value=" ">None</option>
@endforelse