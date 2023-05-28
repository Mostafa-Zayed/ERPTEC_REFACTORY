<div class="modal-dialog" role="document">
  <div class="modal-content">

    {!! Form::open(['url' => action('\Modules\Affilate\Http\Controllers\AffilateController@storepaid'), 'method' => 'post', 'id' => 'paid_add_form' ]) !!}
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">@lang( 'affilate::lang.add_paid' )</h4>
    </div>

    <div class="modal-body">
      <div class="form-group">
        {!! Form::label('amount', __( 'affilate::lang.amount' ) . ':*') !!}
          {!! Form::text('amount', $remind, ['class' => 'form-control', 'data-max' => $remind, 'required', 'placeholder' => __( 'affilate::lang.amount' )]); !!}
          <span id="amount_error" class="hide" style="color: #e80a0a;">{{__('messages.amount_more_than_max')}}</span>
      </div>

     
      <div class="form-group @if($id) hide @endif">
        {!! Form::label('user_id', __( 'affilate::lang.user' ) . ':') !!}
           {!! Form::select('user_id', $users, $id, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required']); !!}
      </div>
      @if($user)
       <div class="form-group">
        {!! Form::label('transaction_number', $user->transaction_number) !!}

      </div>
      @endif
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary">@lang( 'messages.save' )</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">@lang( 'messages.close' )</button>
    </div>

    {!! Form::close() !!}

  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    
        
        $( "#amount" ).keyup(function( event ) {
            var max = $("#amount").data('max');
            var amount = $("#amount").val();
            if(max < amount){
                $("#amount_error").removeClass("hide");
            }else{
                $("#amount_error").addClass("hide");
            }
        
        console.log(max);
        console.log(amount);
        }).keydown(function( event ) {
          if ( event.which == 13 ) {
            event.preventDefault();
          }
        });
</script>