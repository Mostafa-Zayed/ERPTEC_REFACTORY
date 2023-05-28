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
              <th data-field="number">Shipment Number</th>
              <th data-field="number">Status</th>
              <th data-field="number">Date</th>
              <th data-field="number">Time</th>
            </tr>
          <tr>
                <td><strong>{{$m['payload'][0]['shipment_id']}}</strong></td>
                <td><strong>{{$m['payload'][0]['status']}}</strong></td>
                <td><strong>{{$m['payload'][0]['date']}}</strong></td>
                <td><strong>{{$m['payload'][0]['time']}}</strong></td>

           </tr>
        
          </table>
        </div>
      </div>
    </div>
</section>

@endsection
