@extends('layouts.app')
@section('title', 'shipment')

@section('content')

<section class="content-header">
    
    <h1>@lang( 'sale.Shipping company' )
      
    </h1>
    
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
                                    <th   style="text-align: center;">AWB</th>
                                    <th   style="text-align: center;">Pickup Date</th>
                                    <th   style="text-align: center;">Consignee Name</th>
                                    <th   style="text-align: center;"> Address</th>
                                    <th   style="text-align: center;">Phone</th>
                                    <th   style="text-align: center;">Mobile</th>
                                 </tr>
                                <tr>
                                           
                                @foreach($m as $value )
                                 
                                    <td><strong>{{$value['AWB']}}</strong></td>
                                    <td><strong>{{ $value['Pickup Date']}}</strong></td>
                                    <td><strong>{{ $value['Consignee Name']}}</strong></td>
                                    <td><strong>{{$value['Adress']}}</strong></td>
                                    <td><strong>{{ $value['Telephone']}}</strong></td>
                                    <td><strong>{{ $value['Mobile']}}</strong></td>
                                    </tr>
                                    
                             @endforeach

              </table>
        </div>
      </div>
    </div>
</section>

@endsection
