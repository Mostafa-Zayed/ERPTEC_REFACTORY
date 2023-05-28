@extends('layouts.app')
@section('title', __('affilate::lang.affilate'))

@section('content')
@include('affilate::layouts.nav')
{{--
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang('affilate::lang.affilate')</h1>
</section>
--}}

<!-- Main content -->
<section class="content">
    @php
        $is_superadmin = auth()->user()->can('superadmin');
    @endphp
    <!--  @if(!empty($alerts['connection_failed']))
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                <li>{{$alerts['connection_failed']}}</li>
            </ul>
        </div>
    </div>
    @endif-->
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between">
            <h4><i class="fas fa-tag"></i> @lang('affilate::lang.affilate_link')</h4>
        </div>
        <div class="default-box-body">
            <div class="row">
                <div class="col-sm-12">
                    <input class="form-control" type="text" id="affilate_url" value="{{action('\Modules\Affilate\Http\Controllers\AffilateUserController@create',['business_id' => $business->id])}}" disable readonly> 
                </div>  
                <div class="col-sm-12 mt-4">
                    <button type="button" class="main-light-btn w-100 mybtn1" onclick="myFunction()" onmouseout="outFunc()"  id="copy_url"> @lang('affilate::lang.copy_url')</button>
                    <span class="last_sync_cat"></span>
                </div>
            </div>
       </div>
    </div>
</section>
@stop
@section('javascript')

<script>
function myFunction() {
  var copyText = document.getElementById('affilate_url');
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  
  var tooltip = document.getElementsByClassName("tooltiptex");
  tooltip.innerHTML = "Copied: " + copyText.value();
}

function outFunc() {
  var tooltip = document.getElementsByClassName("tooltiptex");
  tooltip.innerHTML = "Copy to clipboard";
}
</script>

<script type="text/javascript">
  
</script>
@endsection