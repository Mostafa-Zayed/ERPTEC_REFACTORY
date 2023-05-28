
<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('Admin\ShipmentZoneController@citystore'), 'method' => 'post', 'id' =>'campaigns_add_form' ]) !!}

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'sale.city to zone' )</h4>
    </div>
        <input type="hidden" name="business_id" value="{{Request()->session()->get('user.business_id')}}">
    <div class="modal-body">
        
        <div class="form-group">
        {!! Form::label('country', __( 'sale.country' ) . ':*') !!}
          {!! Form::select('country', $country,null, ['class' => 'form-select select2 select22', 'required' ]); !!}
      </div>
         <div class="form-group">
        {!! Form::label('city_id', __( 'sale.city' ) . ':*') !!}
        <select name="city_id" id="city_id" class="form-select select2 select22">
         
        </select>
      </div>  
      <div class="form-group">
        {!! Form::label('state_id', __( 'sale.state' ) . ':*') !!}
        <select name="state_id[]" id="state_id" multiple class="form-control select2" style="height: auto !important; width: -webkit-fill-available;">
         
        </select>
      </div> 
          <div class="form-group">
        {!! Form::label('zone_id', __( 'sale.zone' ) . ':*') !!}
          {!! Form::select('zone_id', $zones,null, ['class' => 'form-select select2 select22', 'required' ]); !!}
      </div>
     
  

     
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
      
$('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('.select22').each(function() {
        // var dropdownParent = $(document.body);
        if ($(this).parents('.modal.in:first').length !== 0){
            dropdownParent = $(this).parents('.modal.in:first');
            $(this).select2({
                dropdownParent: dropdownParent
            });
        }
    });
});
        $(document).ready(function(){
             $("Select[name='country']").change(function(){
        
              var id= $(this).val();
              var url = "{{ url ('/cities')}}";
              var token = $("input[name='_token']").val();
              $.ajax({
                  url: url,
                  method: 'POST',
                  data: {id:id, _token:token},
                  success: function(data) {
                     
                    
                    $("[name='city_id']").html('');
                    $("[name='city_id']").html(data.options);
                     
                  }
                });
              });
              
              
              $("Select[name='city_id']").change(function(){
                  
        
              var id= $(this).val();
              var url = "{{ url ('/city/state')}}";
              var token = $("input[name='_token']").val();
              $.ajax({
                  url: url,
                  method: 'POST',
                  data: {id:id, _token:token},
                  success: function(data) {
                     
                    
                    $("[name='state_id[]']").html('');
                    $("[name='state_id[]']").html(data.options);
                     
                  }
                });
              });
        
           });
           
           
           
</script>
