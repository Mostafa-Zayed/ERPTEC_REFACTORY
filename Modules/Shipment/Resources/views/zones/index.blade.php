@extends('layouts.app')
@section('title', __('shipment::lang.shipment'))

@section('content')
    @include('shipment::layouts.nav')
    <section class="content">
        <div class="default-box">
            <div class="default-box-head d-flex align-items-center justify-content-between">
                <h4><i class="fas fa-shopping-basket"></i> {{__('sale.all_zones')}}</h4>
                @can('sell.view')
                <div>
                    <button type="button" class="main-dark-btn btn-modal" data-href="{{route('shipment.zones.create')}}" data-container=".zones_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )
                    </button>
                    <button type="button" class="main-light-btn btn-modal" data-href="{{route('shipment.zones.create.city')}}" data-container=".zones_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add City to zone' )
                    </button>
                </div>
                @endcan
            </div>
            <div class="default-box-body">
                <div class="table-responsive">
                    <table class="main_light_table table table-bordered table-striped" id="zones_table">
                        <thead>
                            <tr>
                                <th>@lang( 'sale.name' )</th>
                                <th>@lang( 'sale.name_ar' )</th>
                                <th>@lang( 'sale.description' )</th>
                                <th>@lang( 'messages.action' )</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="modal fade zones_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    </section>
@endsection
@section('javascript')
    
    <script>
        $(document).ready( function () {
            
            
            /*
            * show tables
            */
            let zonesTable = $('#zones_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/shipment/zones',
                        type: 'Get',
                        // dataSrc: ""
                    }, 
                    columnDefs: [
                        {
                            targets: 3,
                            orderable: false,
                            searchable: false,
                        },
                    ],
                });
            
            
            
            
            
            
            
            // store zone
            $(document).on('submit','form#zone_add_form',function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                method: "POST",
                data: formData,
                success: function(result){
                    $('div.zones_modal').modal('hide');
                    toastr.success(result.msg);
                    zonesTable.ajax.reload();
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
            
            
            // add city to zone
            $(document).on('submit','form#zone_store_city',function(event){
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: "{{route('shipment.zones.store.city')}}",
                    method: 'POST',
                    data: formData,
                    success: function(result){
                        console.log(result);
                        $('div.zones_modal').modal('hide');
                        toastr.success(result.msg);
                        zonesTable.ajax.reload();
                    }
                });
                // console.log(stateId);
            });
            
            
        });
        
        // send stor
        
    </script>
@endsection