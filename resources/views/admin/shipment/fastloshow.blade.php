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
             <th data-field="number" style="text-align: center;">Sender Name</th>
             <th data-field="number" style="text-align: center;">Sender Mobile</th>
             <th data-field="number" style="text-align: center;">Sender Country</th>
             <th data-field="number" style="text-align: center;">Sender City</th>
             <th data-field="progress" style="text-align: center;">Status</th>
           </tr>
          <tr>
            <td><strong>{{$m['output']['sender_address']['sender_name']}}</strong></td>
            <td><strong>{{ $m['output']['sender_address']['sender_mobile1']}}</strong></td>
            <td><strong>{{$m['output']['sender_address']['sender_country']}}</strong></td>
            <td><strong>{{$m['output']['sender_address']['sender_city']}}</strong></td>
            <td><strong>{{$m['output']['shipment_data']['status_name']}}</strong></td>
         </tr>
    
  </table>
        </div>
      </div>
    </div>
</section>

@endsection
