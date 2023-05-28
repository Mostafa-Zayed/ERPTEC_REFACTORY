@extends('layouts.app')
@section('title', __('affilate::lang.balance'))

@section('content')
@include('affilate::layouts.nav')
{{--
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'affilate::lang.balance' )
    </h1>
</section>
--}}
<!-- Main content -->
<section class="content">
    <div class="default-box">
        <div class="default-box-body">
            <div class="table-responsive">
            	<table class="main_light_table table table-bordered table-striped" id="sync_log_table">
            		<thead>
            			<tr>
                          
            				<th>@lang( 'messages.date' )</th>
            				<th>@lang( 'affilate::lang.user' )</th>
            				<th>@lang( 'affilate::lang.total_commetion' )</th>
                            <th>@lang( 'affilate::lang.total_paid' )</th>
                            <th >@lang( 'affilate::lang.total_remind' )</th>
                        	<th>@lang( 'affilate::lang.action' )</th>
            			</tr>
            		</thead>
        	    </table>
            </div>
        </div>
    </div>
    <div class="modal fade expense_category_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel"></div>
</section>
<!-- /.content -->
@stop
@section('javascript')
<script type="text/javascript">
    $(document).ready( function () {
        var sync_log_table =  $('#sync_log_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewbalance')}}",
            "order": [[ 1, "desc" ]],
            columnDefs: [ {
                "targets": 4,
                "orderable": false
            } ],
            columns: [
             
                {data: 'created_at', name: 'created_at', "searchable": false},
                {data: 'added_by', name: 'first_name'},
                {data: 'total_commetion', name: 'total_commetion', "searchable": false},
                {data: 'total_paid', name: 'total_paid', "searchable": false},
                {data: 'total_remind', name: 'total_remind', "searchable": false},
                {data: 'action', name: 'action', "searchable": false},
            ],
            createdRow: function( row, data, dataIndex ) {
                /*if( data.log_details != ''){
                    $( row ).find('td:eq(0)').addClass('details-control');
                }*/
            },
        });


       
        // Array to track the ids of the details displayed rows
        var detailRows = [];
      $(document).on('submit', 'form#paid_add_form', function(e) {
        e.preventDefault();
        var data = $(this).serialize();
            var max = $("#amount").data('max');
            var amount = $("#amount").val();
            if(max < amount){
               return false;
            }
        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.success === true) {
                    $('div.expense_category_modal').modal('hide');
                    toastr.success(result.msg);
                    sync_log_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });
      /*  $('#sync_log_table tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = sync_log_table.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );
     
            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();
     
                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );

                row.child( get_log_details( row.data() ) ).show();
     
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );
     */
        // On each draw, loop over the `detailRows` array and show any child rows
       /* sync_log_table.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+id+' td.details-control').trigger( 'click' );
            } );
        });*/
    });

   /* function get_log_details ( rowData ) {
        var div = $('<div/>')
            .addClass( 'loading' )
            .text( 'Loading...' );
        $.ajax( {
            url: '/affilate/get-log-details/' + rowData.DT_RowId,
            dataType: 'html',
            success: function ( data ) {
                div
                    .html( data )
                    .removeClass( 'loading' );
            }
        } );
     
        return div;
    }*/
    
    
</script>

@endsection
