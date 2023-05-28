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
           <th data-field="number">Entity</th>
           <th data-field="number">References</th>
           <th data-field="number">Status</th>
         </tr>
        <tr>
             <td><strong>{{$m['Entity']}}</strong></td>
             <td><strong>{{$m['Reference']}}</strong></td>
             <td><strong>{{$m['LastStatus']}}</strong></td>
        </tr>
    
  </table>
        </div>
      </div>
    </div>
    
</section>

@endsection
