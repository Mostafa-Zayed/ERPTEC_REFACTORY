@extends('layouts.app')
@section('title', __('shipment::lang.shipment'))

@section('content')
    @include('shipment::layouts.nav')
    <section class="content">
        <div class="default-box">
            <div class="default-box-head d-flex align-items-center justify-content-between">
                <h4><i class="fas fa-shopping-basket"></i> {{__('sale.all_shipment Prices')}}</h4>
                @can('sell.view')
                <button type="button" class="main-dark-btn btn-modal" data-href="{{route('shipment.zones.price.create')}}" data-container=".zone_price_modal">
                    <i class="fa fa-plus"></i> @lang( 'messages.add' )
                </button>
                @endcan
            </div>
            <div class="default-box-body">
                <div class="table-responsive">
                    <table class="main_light_table table table-bordered table-striped" id="zones_price_table" style="text-align: center;">
                        <thead>
                            <tr>
                                <!--<th>id</th>-->
                                <th>@lang( 'sale.zone' )</th>
                                <th>@lang( 'sale.shipment' )</th>
                                <th>@lang( 'sale.price' )</th>
                                <th>@lang( 'sale.extra' )</th>
                                <th>@lang( 'messages.action' )</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="modal fade zone_price_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    </section>
@endsection
@section('javascript')
    
    <script>
        $(document).ready( function () {
            
            
            /*
            * show tables
            */
            let zonesPriceTable = $('#zones_price_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/shipment/zones/price',
                        type: 'Get',
                        // dataSrc: ""
                    },
                    columns: [
                        // {data: 'id', name: 'id'},
                        {data: 'zone', name: 'zone'},
                        {data: 'shipment_company', name: 'shipment_company'},
                        {data: 'value', name: 'value'},
                        {data: 'extra', name: 'extra'},
                        {data: 'action', name: 'action'},
                    ]
                });
            
            
            
            
            
            
            
            // store zone
            $(document).on('submit','form#zones_price_add_form',function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: formData,
                success: function(result){
                    $('div.zone_price_modal').modal('hide');
                    toastr.success(result.msg);
                    zonesPriceTable.ajax.reload();
                },
                error: function(error){
                    let errors = error.responseJSON;
                    // console.log(errors,'test');
                
                //   errorsHtml = '<div class="alert alert-danger"><ul>';
                  $.each(errors.errors,function (k,v) {
                        //  errorsHtml += '<li>'+ v + '</li>';
                        toastr.error(v);
                  });
                //   errorsHtml += '</ul></di>';

                //   $( 'form#zone_add_form' ).append( errorsHtml );
                }
            });
            });
            
            // delete
            
            
        });
        
        // send stor
        
    </script>
@endsection