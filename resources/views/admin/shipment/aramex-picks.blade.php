@extends('layouts.app')
@section('title', 'shipment')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
   
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
           <th data-field="number">Tracks Key</th>
           <th data-field="number">Updatee Code</th>
           <th data-field="number">Update Description</th>
         </tr>
        <tr>
             <td><strong>{{$m['TrackingResults'][0]['Key']}}</strong></td>
             <td><strong>{{$m['TrackingResults'][0]['Value'][0]['UpdateCode']}}</strong></td>
             <td><strong>{{$m['TrackingResults'][0]['Value'][0]['UpdateDescription']}}</strong></td>
        </tr>
    
  </table>
        </div>
      </div>
    </div>
    
</section>

@endsection
