@extends('layouts.app')
@section('title', 'shipment')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'sale.Shipping company' )
      
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
    
</section>

<section class="content">
    
     <div class="row">
      <div class="col-sm-12 col-xs-12">
        <h4>{{ __('sale.shipments status') }}:</h4>
      </div>

              <div class="col-sm-12 col-xs-12">
                    <div class="table-responsive">
                          <table class="table bg-gray">
                                <tr class="bg-green">
                                    <th      style="text-align: center;">Number</th>
                                    <th      style="text-align: center;">First Name</th>
                                    <th      style="text-align: center;">Last Name</th>
                                    <th      style="text-align: center;"> Phone</th>
                                    <th      style="text-align: center;">Date</th>
                                    <th      style="text-align: center;">Status</th>
                                    <th      style="text-align: center;">Action</th>
                                 </tr>
                                <tr>
                                    
                                  @foreach($theresult['deliveries']  as $values )
                                  
                                    <td><strong>{{ $values['trackingNumber']}}</strong></td>
                                    <td><strong>{{ $values['receiver']['firstName']}}</strong></td>
                                    <td><strong>{{ $values['receiver']['lastName']}}</strong></td>
                                    <td><strong>{{ $values['receiver']['phone']}}</strong></td>
                                    <td><strong>{{$values['createdAt']}}</strong></td>
                                    <td><strong>{{ $values['state']['value']}}</strong></td>
                                    <td>
                                     <a  class="btn btn-success" href="{{ route('bosta-shipment',$values['_id']) }}">Show</a>
                                      <br><br>
                                          
                                         </td>
                                    </tr>
                                    @endforeach
    
              </table>
        </div>
      </div>
    </div>
</section>

@endsection
