<option>Select</option>
@foreach($cities as $a)
<option value="{{$a->id}}">{{$a->name}}</option>
@endforeach