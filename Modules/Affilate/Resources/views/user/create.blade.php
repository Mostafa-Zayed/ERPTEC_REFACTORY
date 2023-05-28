@extends('layouts.guest')

@section('title', __( 'user.add_user' ))

@section('content')
<style>
    .box-body{
        margin-top: 60px;
    }
    
    .cr-prod-fixed-top{
        
        top:0;
    }
    .d-flex{
        display: flex;
    }
    .align-items-center{
        align-items: center;
    }
    .m-auto{
        margin:auto
    }
    .p-0{
        padding:0
    }
    .h-100{
        height: 100%;    
    }
    .w-100{
        width: 100%;
    }
    .form-img-des-container{
        overflow-x: hidden;
    }
    .form-img-des-container .form-img-des-img img{
        width: 100%;
    }
    .form-img-des-container .form-img-des-img h4 {
        font-size: 20px !important;
        font-weight: 600 !important;
        line-height: 1.7;
    }
    .form-img-des-container .form-img-des-img h4 span{
        color: #52087b;
        font-size: 24px;
    }
    .form-img-des-container .form-img-des-v {
        padding: 50px 10px !important;
    }
</style>

<!-- Content Header (Page header) -->
<div class="form-img-des col-md-12 col-xs-12">
    <div class="col-md-10 m-auto" style="float: unset;">
        <div class="form-img-des-container">
            <div class="row m-0 h-100" style="background: aliceblue;">
                <div class="col-lg-5 p-0">
                    <div class="form-img-des-img">
                        <h4>
أهلا بك- من هنا نبدأ النجاح سوياً       
<br>
                        <span>اشترك الان فى برنامج التسويق بالعمولة</span>

                        </h4>
                        <img src="{{asset('images/aff-reg.png')}}" class="w-100">
                    </div>
                </div>
                <div class="col-lg-7 p-0 h-100 d-flex align-items-center">
                    <div class="form-img-des-v w-100 h-100">
                        {!! Form::open(['url' => action('\Modules\Affilate\Http\Controllers\AffilateUserController@store'), 'method' => 'post', 'id' => 'user_add_form' ]) !!}

       
                          {!! Form::hidden('business_id', $business_id, ['class' => 'form-control']); !!}
                            <div class="row">
                                <div class="col-md-12">
                                
                                  <div class="col-md-2 hide">
                                    <div class="form-group">
                                      {!! Form::label('surname', __( 'business.prefix' ) . ':') !!}
                                        {!! Form::text('surname', null, ['class' => 'form-control', 'placeholder' => __( 'business.prefix_placeholder' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('first_name', __( 'business.first_name' ) . ':*') !!}
                                        {!! Form::text('first_name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'business.first_name' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('last_name', __( 'business.last_name' ) . ':') !!}
                                        {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => __( 'business.last_name' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="clearfix"></div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('email', __( 'business.email' ) . ':*') !!}
                                        {!! Form::text('email', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'business.email' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('contact_number', __( 'contact.mobile' ) . ':*') !!}
                                        {!! Form::text('contact_number', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'contact.mobile' ) ]); !!}
                                    </div>
                                  </div>  
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      {!! Form::label('transaction_number', __( 'contact.transaction_number' ) . ':*') !!}
                                        {!! Form::text('transaction_number', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'contact.transaction_number' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      {!! Form::label('username', __( 'business.username' ) . ':') !!}
                                      @if(!empty($username_ext))
                                        <div class="input-group">
                                          {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __( 'business.username' ) ]); !!}
                                          <span class="input-group-addon">{{$username_ext}}</span>
                                        </div>
                                        <p class="help-block" id="show_username"></p>
                                      @else
                                          {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => __( 'business.username' ) ]); !!}
                                      @endif
                                      <p class="help-block">@lang('lang_v1.username_help')</p>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('password', __( 'business.password' ) . ':*') !!}
                                        {!! Form::password('password', ['class' => 'form-control', 'required', 'placeholder' => __( 'business.password' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      {!! Form::label('confirm_password', __( 'business.confirm_password' ) . ':*') !!}
                                        {!! Form::password('confirm_password', ['class' => 'form-control', 'required', 'placeholder' => __( 'business.confirm_password' ) ]); !!}
                                    </div>
                                  </div>
                                  <div class="col-md-6 hide">
                                    <div class="form-group">
                                      {!! Form::label('role', __( 'user.role' ) . ':*') !!} @show_tooltip(__('lang_v1.admin_role_location_permission_help'))
                                        {!! Form::select('role', $roles, null, ['class' => 'form-control select2']); !!}
                                    </div>
                                  </div>
                                  <div class="clearfix"></div>
                           
                                </div>
                          </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary floating-btn-s" id="submit_user_button">@lang( 'messages.save' )</button>
                            </div>
                        {!! Form::close() !!}
                          @stop
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->

  
@section('javascript')
<script type="text/javascript">
  $(document).ready(function(){
    $('#selected_contacts').on('ifChecked', function(event){
      $('div.selected_contacts_div').removeClass('hide');
    });
    $('#selected_contacts').on('ifUnchecked', function(event){
      $('div.selected_contacts_div').addClass('hide');
    });
  });

  $('form#user_add_form').validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    email: {
                        email: true,
                        remote: {
                            url: "/affilate/register/check-email",
                            type: "post",
                            data: {
                                email: function() {
                                    return $( "#email" ).val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                    username: {
                        minlength: 5,
                        remote: {
                            url: "/affilate/register/check-username",
                            type: "post",
                            data: {
                                username: function() {
                                    return $( "#username" ).val();
                                },
                                @if(!empty($username_ext))
                                  username_ext: "{{$username_ext}}"
                                @endif
                            }
                        }
                    }
                },
                messages: {
                    password: {
                        minlength: 'Password should be minimum 5 characters',
                    },
                    confirm_password: {
                        equalTo: 'Should be same as password'
                    },
                    username: {
                        remote: 'Invalid username or User already exist'
                    },
                    email: {
                        remote: '{{ __("validation.unique", ["attribute" => __("business.email")]) }}'
                    }
                }
            });
  $('#username').change( function(){
    if($('#show_username').length > 0){
      if($(this).val().trim() != ''){
        $('#show_username').html("{{__('lang_v1.your_username_will_be')}}: <b>" + $(this).val() + "{{$username_ext}}</b>");
      } else {
        $('#show_username').html('');
      }
    }
  });
  
    $topValue = parseInt($('.cr-prod-fixed-top').css('top'));
    $(window).scroll(function() {
    /*    if ($(document).scrollTop() < 132) {
            $('.cr-prod-fixed-top').css('top', $topValue - $(document).scrollTop());
        }
        else { }*/
            $('.cr-prod-fixed-top').css('top', '0');
       
    });
    // if(window.innerWidth > 992){
    //     $(window).scroll(function() {
    //         if ($(document).scrollTop() < 66) {
    //             $('.cr-prod-fixed-top').css('top', $topValue - $(document).scrollTop());
    //         }
    //         else {
    //             $('.cr-prod-fixed-top').css('top', '0');
    //         }
    //     })
    // }else{
    //     $(window).scroll(function() {
    //         if ($(document).scrollTop() < 132) {
    //             $('.cr-prod-fixed-top').css('top', $topValue - $(document).scrollTop());
    //         }
    //         else {
    //             $('.cr-prod-fixed-top').css('top', '0');
    //         }
    //     })
    // }
</script>
@endsection
