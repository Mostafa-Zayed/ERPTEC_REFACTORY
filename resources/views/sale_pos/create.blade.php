@extends('layouts.app')

@section('title', __('sale.pos_sale'))

@section('content')
<section class="content no-print">
	<input type="hidden" id="amount_rounding_method" value="{{$pos_settings['amount_rounding_method'] ?? ''}}">
	@if(!empty($pos_settings['allow_overselling']))
		<input type="hidden" id="is_overselling_allowed">
	@endif
	@if(session('business.enable_rp') == 1)
        <input type="hidden" id="reward_point_enabled">
    @endif
    @php
		$is_discount_enabled = $pos_settings['disable_discount'] != 1 ? true : false;
		$is_rp_enabled = session('business.enable_rp') == 1 ? true : false;
	@endphp
	{!! Form::open(['url' => action('SellPosController@store'), 'method' => 'post', 'id' => 'add_pos_sell_form' ]) !!}
	
	<div class="row mb-12">
		<div class="col-md-12">
			<div class="row">
				<div class="@if(empty($pos_settings['hide_product_suggestion'])) col-md-7 @else col-md-10 col-md-offset-1 @endif no-padding pr-12">
					<div class="box box-solid mb-12">
						<div class="box-body pb-0">
							{!! Form::hidden('location_id', $default_location->id ?? null , ['id' => 'location_id', 'data-receipt_printer_type' => !empty($default_location->receipt_printer_type) ? $default_location->receipt_printer_type : 'browser', 'data-default_payment_accounts' => $default_location->default_payment_accounts ?? '']); !!}
							<!-- sub_type -->
							{!! Form::hidden('sub_type', isset($sub_type) ? $sub_type : null) !!}
							<input type="hidden" id="item_addition_method" value="{{$business_details->item_addition_method}}">
								@include('sale_pos.partials.pos_form')

								@include('sale_pos.partials.pos_form_totals')

								@include('sale_pos.partials.payment_modal')


								@if(empty($pos_settings['disable_suspend']))
									@include('sale_pos.partials.suspend_note_modal')
								@endif

								@if(empty($pos_settings['disable_recurring_invoice']))
									@include('sale_pos.partials.recurring_invoice_modal')
								@endif
							</div>
						</div>
					</div>
				@if(empty($pos_settings['hide_product_suggestion']) && !isMobile())
				<div class="col-md-5 no-padding">
					@include('sale_pos.partials.pos_sidebar')
				</div>
				@endif
			</div>
		</div>
	</div>
	@include('sale_pos.partials.pos_form_actions')
	{!! Form::close() !!}
</section>

<!-- This will be printed -->
<section class="invoice print_section" id="receipt_section">
</section>
<div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	@include('contact.create', ['quick_add' => true])
</div>
@if(empty($pos_settings['hide_product_suggestion']) && isMobile())
	@include('sale_pos.partials.mobile_product_suggestions')
@endif
<!-- /.content -->
<div class="modal fade register_details_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<div class="modal fade close_register_modal" tabindex="-1" role="dialog" 
	aria-labelledby="gridSystemModalLabel">
</div>
<!-- quick product modal -->
<div class="modal fade quick_add_product_modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle"></div>

@include('sale_pos.partials.configure_search_modal')

@include('sale_pos.partials.recent_transactions_modal')

@include('sale_pos.partials.weighing_scale_modal')

@stop
@section('css')
	<!-- include module css -->
    @if(!empty($pos_module_data))
        @foreach($pos_module_data as $key => $value)
            @if(!empty($value['module_css_path']))
                @includeIf($value['module_css_path'])
            @endif
        @endforeach
    @endif
@stop
@section('javascript')
	<script src="{{ asset('public/js/pos.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('public/js/printer.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('public/js/product.js?v=' . $asset_v) }}"></script>
	<script src="{{ asset('public/js/opening_stock.js?v=' . $asset_v) }}"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tagmanager/3.0.2/tagmanager.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
	@include('sale_pos.partials.keyboard_shortcuts')

	<!-- Call restaurant module if defined -->
    @if(in_array('tables' ,$enabled_modules) || in_array('modifiers' ,$enabled_modules) || in_array('service_staff' ,$enabled_modules))
    	<script src="{{ asset('public/js/restaurant.js?v=' . $asset_v) }}"></script>
    @endif
    <!-- include module js -->
    @if(!empty($pos_module_data))
	    @foreach($pos_module_data as $key => $value)
            @if(!empty($value['module_js_path']))
                @includeIf($value['module_js_path'], ['view_data' => $value['view_data']])
            @endif
	    @endforeach
	@endif
	
<script>
	
    $(document).ready(function(){
        
        // get customer addresss
        $(document).on('change','Select[name="contact_id"]',function(event){
            let id= $(this).val();
            let contact = $("Select[name='contact_id']").val();
            let token = $("input[name='_token']").val();
            $.ajax({
                url: "{{route('ajax.customer.address')}}",
                method: 'POST',
                data: {id:id, _token:token, contact:contact},
                success: function(data) {
                    $("select#address_id").html('');
                    $("select#address_id").html(data.options); 
                    $('div#customer_address').removeClass('hide');
                },
                failed: function(data) {
                    
                },
                 
            });
        });
        
        // get addres shipment
        $(document).on('change','select#address_id',function(event){
            let id= $(this).val();
            let contact_id = $("Select[name='contact_id']").val();
            let token = $("input[name='_token']").val();
            $.ajax({
                url : "{{route('ajax.address.shipment')}}",
                method: "POST",
                data: {id:id,_token:token,contact_id:contact_id},
                success: function(data){
                    console.log(data);
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
        
        // get address info
        $(document).on('change','select#address_id',function(event){
            let id= $(this).val();
            let contact_id = $("Select[name='contact_id']").val();
            let token = $("input[name='_token']").val();
            $.ajax({
                url : "{{route('ajax.address.info')}}",
                method: "POST",
                data: {id:id,_token:token,contact_id:contact_id},
                success: function(data){
                    $('div#address_info').html('');
                    $('div#address_info').html(data.options)
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
        
        
        // get shipment accounts
        $(document).on('change','select#shipment_company_id',function(event){
            let companyId = $(this).val();
            let companyName = $(this).find(':selected').text();
            let token = $("input[name='_token']").val();
            let url = "{{ route('shipment.company.accounts', ":id") }}";
            url = url.replace(':id', companyId);
            $.ajax({
                url: url,
                method: 'GET',
                data: {id: companyId, _token: token},
                success: function(result){
                    
                    $('select#shipment_account_id').html = '';
                       $('select#shipment_account_id').html(result.data);
                   // if((result.success == true) && (result.data.length) > 0){
                   //    $('select#shipment_account_id').html = '';
                   //    $('select#shipment_account_id').html(result.data);
                   // }else {
                   //     toastr.error('Company ' + companyName + ' no has any accounts');
                   // }
                },
                error: function(error){
                    console.log(error);
                }
            });
            
        });
        
        // get shipment company details
        $(document).on('change','select#shipment_company_id',function(event){
            let companyName = $(this).find(':selected').text().trim();
            if(companyName === 'Voo'){
                $.ajax({
                    url: "{{route('shipment.voo.areas')}}",
                    method: "POST",
                    success: function(data){
                        $('div#voo_area').html('');
                        $('div#voo_area').html(data.options);
                        $('div#voo_area').show();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
                $.ajax({
                    url: "{{route('shipment.voo.courier')}}",
                    method: "POST",
                    success: function(data){
                        $('div#voo_courier').html('');
                        $('div#voo_courier').html(data.options);
                        $('div#voo_courier').show();
                    }
                });
            }else {
                $('div#voo_area').hide();
                $('div#voo_courier').hide();
            }
        });
        
        // get shipment charge
        $(document).on('change','select#shipment_company_id',function(event){
            let addressId = $('select#address_id').val();
            let companyId = $(this).val();
            let token = $("input[name='_token']").val();
            $.ajax({
                url : "{{route('shipment.shipcharge')}}",
                method: "POST",
                data: {id:companyId,_token:token,address_id:addressId},
                success: function(data){
                    $("#shipping_charges_show").val(data.value);
                    // $("#shipping_charges_show").change();
                    $('input#shipping_charges_modal').val(data.value);
                    $('input#shipping_charges').val(data.value);
                    // $('input#shipping_charges_modal').change();
                    
                    
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
    });
</script>
@endsection