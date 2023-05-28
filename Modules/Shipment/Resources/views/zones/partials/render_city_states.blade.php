<option>Select</option>
@foreach($states as $a)
<option value="{{$a->id}}">{{$a->name_ar}}</option>
@endforeach