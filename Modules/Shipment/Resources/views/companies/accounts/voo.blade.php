@extends('layouts.app')
@section('title', __('shipment::lang.shipment'))

@section('content')
    @include('shipment::layouts.nav')
    <section class="content-header">
        <h1>{{$company->name}}
            <small>@lang('shipment::lang.add_account')</small>
        </h1>
    </section>
    <section class="content">
        <div class="main-bg mt-4">
            <div class="section-body">
                {!! Form::open(['url' => route('shipment.accounts.store')])!!}
                    
                    {!! Form::hidden('shipment_company_id',$company->id) !!}
                    
                    <div class="form-group">
                        {!! Form::label('name', 'Account Name :') !!}
                        {!! Form::text('name',null,['class' => 'form-control','required']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::label('token', 'Voo Token :') !!}
                        {!! Form::textarea('token',null,['rows' => 10,'cols' => 100,'class' => 'form-control','required','style' => 'min-height: 100px;']) !!}
                    </div>
                    
                    <div class="form-group">
                        {!! Form::submit('Add Account',['class' => 'main-light-btn m-auto']) !!}
                    </div>
                {!! Form::close()!!}
            </div>
        </div>
    </section>    
@endsection
