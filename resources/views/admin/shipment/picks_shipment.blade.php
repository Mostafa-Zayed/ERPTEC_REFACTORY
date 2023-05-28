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
                                    <th> Tracking Number</th>
                                    <th>Price</th>
                                    <th>Package Type</th>
                                    <th>Status</th>
                                 </tr>
                                <tr>
                                    
                                  @foreach($m['payload']['data'] as $values )
                                  
                                    <td><strong>{{ $values['tracking_number']}}</strong></td>
                                    <td><strong>{{ $values['price']}}</strong></td>
                                    <td><strong>{{ $values['package_type']}}</strong></td>
                                    <td><strong>{{ $values['status']}}</strong></td>

                                    </tr>
                                    
                                    @endforeach
    
              </table>
        </div>
      </div>
    </div>
</section>

@endsection
