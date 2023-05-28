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
           <th data-field="number" style="text-align: center;">Bar code</th>
           <th data-field="number" style="text-align: center;">Description</th>
           <th data-field="number" style="text-align: center;">Service Type</th>
           <th data-field="number" style="text-align: center;">Service Category</th>
           <th data-field="number" style="text-align: center;">Customer Name</th>
         </tr>
        <tr>
             <td><strong>{{ $m['Value']['Barcode']}}</strong></td>
             <td><strong>{{ $m['Value']['Description']}}</strong></td>
             <td><strong>{{ $m['Value']['ServiceType']}}</strong></td>
             <td><strong>{{ $m['Value']['ServiceCategory']}}</strong></td>
             <td><strong>{{ $m['Value']['CustomerName']}}</strong></td>
        </tr>
    
  </table>
        </div>
      </div>
    </div>
</section>

@endsection
