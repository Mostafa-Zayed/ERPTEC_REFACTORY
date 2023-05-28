
@extends('layouts.front')

@section('title', __('lang_v1.login'))

@section('content')
    <div class="form-img-des col-md-12 col-xs-12 right-col-content">
        <div class="col-md-10 m-auto">
            <div class="form-img-des-container">
                <div class="row m-0">
                    <div class="col-lg-12 p-0">
                        <div class="form-img-des-img h-100" style="text-align: center;">
                           <!-- <h4>@lang('lang_v1.welcome_to_vowalaa_erp')</h4>    -->
                          
                            <img src="{{asset('images/affiliate.jpg')}}"style="width: 35%;">
                             <br>
                            <br>
                            <a class="btn btn-primary pages-err" href="{{url('/home')}}">تسجيل دخول</a>
                           
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
 
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready(function(){
        $('#change_lang').change( function(){
            window.location = "{{ route('login') }}?lang=" + $(this).val();
        });
    })
</script>
@endsection
