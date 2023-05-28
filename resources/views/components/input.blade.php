@label(['name' => $name])
    {{ $slot }}
@endlabel
<input type="{{$type ?? 'text' }}" name="{{$name}}" class="form-control">