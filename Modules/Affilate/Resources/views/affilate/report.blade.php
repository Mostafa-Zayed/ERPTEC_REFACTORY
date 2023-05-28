@extends('layouts.app')
@section('title', __('affilate::lang.affilate_report'))

@section('content')
@include('affilate::layouts.nav')
{{--
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>@lang( 'affilate::lang.affilate_report' )
        </h1>
    </section>
--}}
    <div class="default-box">
        <div class="default-box-head d-flex align-items-center justify-content-between">
            <h4><i class="fas fa-filter"></i> {{__('report.filters')}}</h4>
        </div>
        <div class="default-box-body">
            <div class="row">
             
                @can('user.view')
                    <div class="col-md-3">
                        <div class="form-group">
                            {!! Form::label('created_by',  __('report.user') . ':') !!}
                            {!! Form::select('created_by', $sales_representative, null, ['class' => 'form-control select2', 'style' => 'width:100%']); !!}
                        </div>
                    </div>
                @endcan
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('shipping_status',  __('lang_v1.shipping_status') . ':') !!}
                        {!! Form::select('shipping_status', $shipping_statuses, null, ['placeholder' => __('lang_v1.none'),'class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div>
    
                <!--<div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('order_status',  __('lang_v1.order_status') . ':') !!}
                        {!! Form::select('order_status', $order_statuses, null, ['placeholder' => __('lang_v1.none'),'class' => 'form-control select2', 'style' => 'width:100%']); !!}
                    </div>
                </div>-->
                
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_payment_status',  __('purchase.payment_status') . ':') !!}
                        {!! Form::select('sell_list_filter_payment_status', ['paid' => __('lang_v1.paid'), 'due' => __('lang_v1.due'), 'partial' => __('lang_v1.partial'), 'overdue' => __('lang_v1.overdue')], null, ['class' => 'form-control select2', 'style' => 'width:100%', 'placeholder' => __('lang_v1.all')]); !!}
                    </div>
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('sell_list_filter_date_range', __('report.date_range') . ':') !!}
                        {!! Form::text('sell_list_filter_date_range', null, ['placeholder' => __('lang_v1.select_a_date_range'), 'class' => 'form-control', 'readonly']); !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="default-box">
        <div class="default-box-body">
            <div class="table-responsive">
                <table class="main_light_table table table-bordered table-striped ajax_view" id="sell_retail_table">
                    <thead>
                        <tr>
                            <th>@lang('lang_v1.view_details')</th>
                            <th>@lang('messages.date')</th> 
                            <th>@lang('sale.invoice_no')</th>
                            @can('shipping.show')
                                <th>@lang('lang_v1.shipping_status')</th>
                            @endcan
                            <th>@lang('sale.payment_status')</th>
                            <th>@lang('lang_v1.payment_method')</th>
                            <th>@lang('sale.total_amount')</th>
                            <th>@lang('sale.affilate_name')</th>
                            <th>@lang('sale.commissions_amount')</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr class="bg-gray font-17 footer-total text-center">
                            <td colspan="3"><strong>@lang('sale.total'):</strong></td>
                            @can('shipping.show')
                                <td colspan="1" id="ship_status_count"></td>
                            @endcan
                            <td id="footer_payment_status_count"></td>
                            <td id="payment_method_count"></td>
                            <td><span class="display_currency" id="footer_sale_total" data-currency_symbol ="true"></span></td> 
                            <td colspan="1"></td>
                            <td><span class="display_currency" id="footer_amount_total" data-currency_symbol ="true"></span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    
    <div class="modal fade edit_payment_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
    
    <div class="modal fade trafic_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>

@stop
@section('javascript')

<script type="text/javascript">
$(document).ready( function(){
    //Date range as a button
    $('#sell_list_filter_date_range').daterangepicker(
        dateRangeSettings,
        function (start, end) {
            $('#sell_list_filter_date_range').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
            sell_retail_table.ajax.reload();
        }
    );
    $('#sell_list_filter_date_range').on('cancel.daterangepicker', function(ev, picker) {
        $('#sell_list_filter_date_range').val('');
        sell_retail_table.ajax.reload();
    });

    sell_retail_table = $('#sell_retail_table').DataTable({
        processing: true,
        serverSide: true,
       /* bFilter: false,*/
        aaSorting: [[1, 'desc']],
        "ajax": {
            "url": "/affilate/report",
            "data": function ( d ) {
                if($('#sell_list_filter_date_range').val()) {
                    var start = $('#sell_list_filter_date_range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                    var end = $('#sell_list_filter_date_range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                    d.start_date = start;
                    d.end_date = end;
                }
                d.is_direct_sale = 1;

                d.location_id = $('#sell_list_filter_location_id').val();
                d.customer_id = $('#sell_list_filter_customer_id').val();
                d.shipping_status = $('#shipping_status').val();
                d.shipmentstatus = $('#shipmentstatus').val();
                d.order_status = $('#order_status').val();
                d.shipment_id = $('#shipment_id').val();
                d.payment_status = $('#sell_list_filter_payment_status').val();
                d.created_by = $('#created_by').val();
                d.trafic_id = $('#trafic_id').val();
                d.city = $('#city').val();
                d.state = $('#state').val();
                d.campaign_id = $('#campaign_id').val();
                d.sales_cmsn_agnt = $('#sales_cmsn_agnt').val();
                d.service_staffs = $('#service_staffs').val();
                
              

                d = __datatable_ajax_callback(d);
            }
        },
        columns: [
          
             { data: 'view' , orderable: false, "searchable": false },
       
            { data: 'paid_on', name: 'paid_on'  },
            { data: 'invoice_no', name: 'invoice_no'  },
          
              @can('shipping.show')
             { data: 'shipping_status', name: 'shipping_status'},
              @endcan
             
             
            { data: 'payment_status', name: 'payment_status'},
            { data: 'payment_methods', orderable: false, "searchable": false},
            { data: 'final_total', name: 'final_total'},
            { data: 'added_by', name: 'added_by'},
            { data: 'amount', name: 'affilate_commissions.amount'},
       
         
      

       
          
        ],
        "fnDrawCallback": function (oSettings) {

            $('#footer_sale_total').text(sum_table_col($('#sell_retail_table'), 'final-total'));
            $('#footer_amount_total').text(sum_table_col($('#sell_retail_table'), 'amount-total'));
              $('#footer_shipping_charges').text(sum_table_col($('#sell_retail_table'), 'shipping_charges'));
            $('#footer_total_paid').text(sum_table_col($('#sell_retail_table'), 'total-paid'));

            $('#footer_total_remaining').text(sum_table_col($('#sell_retail_table'), 'payment_due'));
            
            $('#products_count').text(sum_table_col($('#sell_retail_table'), 'products_count'));

            $('#footer_total_sell_return_due').text(sum_table_col($('#sell_retail_table'), 'sell_return_due'));

            $('#footer_payment_status_count').html(__sum_status_html($('#sell_retail_table'), 'payment-status-label'));
            
            $('#ship_status_count').html(__sum_status_html($('#sell_retail_table'), 'shipping-status-label'));
            $('#order_status_count').html(__sum_status_html($('#sell_retail_table'), 'order-status-label'));

            $('#service_type_count').html(__sum_status_html($('#sell_retail_table'), 'service-type-label'));
            $('#payment_method_count').html(__sum_status_html($('#sell_retail_table'), 'payment-method'));

            __currency_convert_recursively($('#sell_retail_table'));
        },
        createdRow: function( row, data, dataIndex ) {
            $( row ).find('td:eq(6)').attr('class', 'clickable_td');
              $( row ).find('td:eq(0)').attr('class', 'selectable_td');
        }
    });

    $(document).on('change', '#sell_list_filter_location_id, #sell_list_filter_customer_id, #sell_list_filter_payment_status,#order_status, #created_by,#trafic_id,#city,#state,#campaign_id,#shipping_status,#shipment_id, #sales_cmsn_agnt, #service_staffs',  function() {
        sell_retail_table.ajax.reload();
    });
   
    
    
           
   var detailRows = [];

    $('#sell_retail_table tbody').on('click', '.view_sell', function() {
        var tr = $(this).closest('tr');
        var row = sell_retail_table.row(tr);
        var idx = $.inArray(tr.attr('id'), detailRows);
      //  console.log(tr);
     //   console.log(row);
     //   console.log(idx);
        if (row.child.isShown()) {
            $(this)
                .find('i')
                .removeClass('fa-eye')
                .addClass('fa-eye-slash');
            row.child.hide();

            // Remove from the 'open' array
            detailRows.splice(idx, 1);
            
        //   console.log(detailRows);
            
        } else {
            $(this)
                .find('i')
                .removeClass('fa-eye-slash')
                .addClass('fa-eye');

            row.child(get_stock_transfer_details(row.data())).show();

            // Add to the 'open' array
            if (idx === -1) {
                detailRows.push(tr.attr('id'));
            }
            
           //   console.log(detailRows+2);
        }
    });

    // On each draw, loop over the `detailRows` array and show any child rows
    $('#sell_retail_table').on('draw', function() {
        $.each(detailRows, function(i, id) {
            $('#' + id + ' .view_sell').trigger('click');
            
           //  console.log(id);
        });
    });          
            
     function get_stock_transfer_details(rowData) {
    var div = $('<div/>')
        .addClass('loading')
        .text('Loading...');
       /*  console.log(rowData);
         console.log(rowData.DT_RowAttr);
         console.log(rowData.DT_RowAttr.id);
         console.log(rowData.DT_RowId);
         console.log(rowData.id);*/
    $.ajax({
        url: '/sellss/details/' + rowData.DT_RowAttr.id,
        dataType: 'html',
        success: function(data) {
            div.html(data).removeClass('loading');
        },
    });

    return div;
}
});


   function getSelectedRows() {
            var selected_rows = [];
            var i = 0;
            $('.row-select:checked').each(function () {
                selected_rows[i++] = $(this).val();
            });
        $('input#selected_products').val(selected_rows);
            return selected_rows; 
        }
        
       $(document).on('click', '#edit-selected', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edit').val(selected_rows);
                    $('form#bulk_edit_form').submit();
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            })       
 
       $(document).on('click', '#edit-selected2', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edits').val(selected_rows);
                    $('form#bulk_edit_form2').submit();
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            })       
     /* $(document).on('click', '#edit-selected3', function(e){
                e.preventDefault();
                var selected_rows = getSelectedRows();
                
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edits').val(selected_rows);
                    $('form#bulk_edit_form3').submit();
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            })       */
 
    
      $(document).on('submit', 'form#assignchange', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();
              
                if(selected_rows.length > 0){
                    $('input#selected_products').val(selected_rows);
                  
                            var form = $('form#assignchange')

                            var data = form.serialize();
                                $.ajax({
                                    method: form.attr('method'),
                                    url: form.attr('action'),
                                    dataType: 'json',
                                    data: data,
                                    success: function(result) {
                                        if (result.success == 1) {
                                            toastr.success(result.msg);
                                            sell_retail_table.ajax.reload();
                                              $('div.payment_modal').modal('hide');
                                            form
                                            .find('#selected_products')
                                            .val('');
                                        } else {
                                            toastr.error(result.msg);
                                        }
                                    },
                                });
                      
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            })   
            
      $(document).on('submit', 'form#bulk_edit_form3', function(e) {
                e.preventDefault();
                var selected_rows = getSelectedRows();
              
                if(selected_rows.length > 0){
                    $('input#selected_products_for_edits2').val(selected_rows);
                  
                            var form = $('form#bulk_edit_form3')

                            var data = form.serialize();
                                $.ajax({
                                    method: form.attr('method'),
                                    url: form.attr('action'),
                                    dataType: 'json',
                                    data: data,
                                    success: function(result) {
                                        if (result.success == 1) {
                                            
                                               if (result.success == 1 && result.receipt.html_content != '') {
                                                     console.log('3');  
                                                     var i;
                                                     
                                                        $('#receipt_section').html(result.receipt.html_content);     
                                                  __currency_convert_recursively($('#receipt_section'));
                                                  
                                                   
                                                  __print_receipt('receipt_section');
                                                 //   window.print('receipt_section');      
                                                 for (i = 0; i < result.receipt.html_content.length; i++) {             } 
                                                     
                                                   //  console.log(result.receipt.html_content);  
                                                   
                                                     
                                                     console.log(result.receipt.html_content.length);  
                                                   
                                                }
                                            toastr.success(result.msg);
                                            sell_retail_table.ajax.reload();
                                              $('div.payment_modal').modal('hide');
                                            form
                                            .find('#selected_products')
                                            .val('');
                                        } else {
                                            toastr.error(result.msg);
                                        }
                                    },
                                });
                      
                } else{
                    $('input#selected_products').val('');
                    swal('@lang("lang_v1.no_row_selected")');
                }    
            });
            
            
     
       
</script>
<script src="{{ asset('js/payment.js?v=' . $asset_v) }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        
        
@endsection
