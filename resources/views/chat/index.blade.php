@extends('layouts.app')

@section('title', 'Brands')

@section('vue')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'brand.brands' )
        <small>@lang( 'brand.manage_your_brands' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <button v-on:click="getMessage">click</button>
            {{--
            <div class="col-md-4 offset-4">
                <ul class="list-group">
                    <li class="list-group-item active">Chat Room</li>
                    <app-message v-for="value in chat.message">@{{value}}</app-message>
                    <input type="text" class="form-control"  v-model="message" placeholder="Type your message here..." v-on:keyup.enter="send">
                </ul>    
            </div>
            --}}
        </div>
    </div>
</section>
@endsection
@section('javascript')
    {{-- <script src="{{asset('public/js/script.js')}}"></script> --}}
    <script>
        // let component = {};
        // console.log(component);
    </script>
@endsection