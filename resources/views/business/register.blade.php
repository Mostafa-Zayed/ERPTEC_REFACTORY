@extends('layouts.auth2')
@section('title', __('lang_v1.register'))


@section('content')
<link rel="stylesheet" href="{{asset('public/new_assets/intlTelInput/css/intlTelInput.min.css')}}"/>
<div class="login-form col-md-12 col-xs-12 right-col-content-register">
    
    <p class="form-header text-white">@lang('business.register_and_get_started_in_minutes')</p>
    {!! Form::open(['url' => route('business.postRegister'), 'method' => 'post', 
                            'id' => 'business_register_form','files' => true ]) !!}
        @include('business.partials.register_form')
        {!! Form::hidden('package_id', $package_id); !!}
    {!! Form::close() !!}
</div>
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        
        /* change language */
        $('#change_lang').change( function(){
            window.location = "{{ route('business.getRegister') }}?lang=" + $(this).val();
        });
        
        
        $(".time_zone").val("Africa/Cairo").change();
        $("#country").val("Egypt").change();
        $(".currency").val("35").change();
        
        $("Select[name='country']").change(function(){
            console.log('sdfd');
        });
    })
</script>
@endsection