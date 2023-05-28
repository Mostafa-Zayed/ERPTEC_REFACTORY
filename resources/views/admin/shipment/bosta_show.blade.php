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
             <th data-field="number" style="text-align: center;">Number</th>
             <th data-field="number" style="text-align: center;">Address</th>
             <th data-field="number" style="text-align: center;">Shiped From</th>
             <th data-field="number" style="text-align: center;">Shiped To</th>
             <th data-field="progress" style="text-align: center;">Actions</th>
           </tr>
          <tr>
            <td><strong>{{$theresult['trackingNumber']}}</strong></td>
            <td><strong>{{ $theresult['pickupAddress']['firstLine']}}</strong></td>
            <td><strong>{{ $theresult['pickupAddress']['city']['name']}}</strong></td>
            <td><strong>{{ $theresult['dropOffAddress']['city']['name']}}</strong></td>
            <td><strong>{{ $theresult['state']['value']}}</strong></td>
         </tr>
    
  </table>
        </div>
      </div>
    </div>
</section>

@endsection
