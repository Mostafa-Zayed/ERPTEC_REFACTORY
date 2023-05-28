
<div class="form-group">
	<div class="input-group">
        {!! Form::label('ships_zone', __('sale.shipzones') . ':') !!}
        <select class="form-control form-select select2" name="voo_area">
            <option value=" ">select</option>
            
            @forelse($areas as $a)
                <option value="{{$a['id']}}">{{$a['name']}}</option>
            @empty
                <option value=" ">None</option>
            @endforelse
        </select>
	</div>
</div>
