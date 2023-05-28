<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\StateController@update', [$brand->id]), 'method' => 'post', 'id' => 'campaigns_edit_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.City' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('name', __( 'sale.name' ) . ':*') !!}
          {!! Form::text('name', $brand->name, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name' )]); !!}
      </div>
      <div class="form-group">
        {!! Form::label('name_ar', __( 'sale.name_ar' ) . ':*') !!}
          {!! Form::text('name_ar', $brand->name_ar, ['class' => 'form-control', 'required', 'placeholder' => __( 'sale.name_ar' )]); !!}
      </div> 
     @php
     $city = App\Models\City::find($brand->city_id);
     @endphp
  <div class="form-group">
        {!! Form::label('country_id', __( 'sale.country' ) . ':*') !!}
          {!! Form::select('country_id', $trafic, null , ['class' => 'form-control', 'required']); !!}
      </div>
  <div class="form-group">
        {!! Form::label('city_id', __( 'sale.city' ) . ':*') !!}
        
          <select name="city_id" id="city_id" class="city_id form-control select2">
              <option value="{{$brand->city_id}}">{{ !empty($city)?  $city->name : $brand->city_id}}</option>
          </select>
      </div>
     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.update' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
           $("Select[name='country_id']").change(function(){
        
              var id= $(this).val();
             
              var url = "{{ url ('/city/cityy')}}";
              var token = $("input[name='_token']").val();
           
              $.ajax({
                  url: url,
                  method: 'POST',
                  data: {id:id, _token:token},
                  success: function(data) {
                     
                      $(".city_id").html('');
                    $(".city_id").html(data.options);
                   
                  
                     
                  },
                   failed: function(data) {
                successmessage = 'No Delivery in This City';
                
                $(".ship").html(successmessage);
            },
                 
                });
              }); 
</script>