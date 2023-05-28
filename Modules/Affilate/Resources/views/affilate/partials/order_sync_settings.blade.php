<div class="pos-tab-content">
    <div class="row">
        <div class="col-xs-7">
        	@php
        		$pos_sell_statuses = [
        			'final' => __('lang_v1.final'),
        			'draft' => __('sale.draft'),
        			'quotation' => __('lang_v1.quotation')
        		];

        		$woo_order_statuses = [
        			'F' => __('cscart::lang.failed'),
        			'D' => __('cscart::lang.has been declined'),
        			'B' => __('cscart::lang.has been backordered'),
        			'I' => __('cscart::lang.has been canceled'),
        			'P' => __('cscart::lang.has been processed'),
        			'H' => __('cscart::lang.has been payment ways'),
        			'A' => __('cscart::lang.has been repayment period'),
        			'C' => __('cscart::lang.has been completed'),
        			'G' => __('cscart::lang.has been order shipping'),
        			'E' => __('cscart::lang.Revision and preparation in progress'),
        			'J' => __('cscart::lang.Under initial review'),
        			'O' => __('cscart::lang.has been placed successfully'),
        			'Y' => __('cscart::lang.Awaiting call')
        		
        		];

        	@endphp
        	<table class="table">
        		<tr>
        			<th>@lang('cscart::lang.cscart_order_status')</th>
        			<th>@lang('cscart::lang.equivalent_pos_sell_status')</th>
                    <th>@lang('cscart::lang.equivalent_shipping_status')</th>
        		</tr>
        		@foreach($woo_order_statuses as $key => $value)
        		<tr>
        			<td>
        				{{$value}}
        			</td>
        			<td>
        				{!! Form::select("order_statuses[$key]", $pos_sell_statuses, $default_settings['order_statuses'][$key] ?? null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')]); !!}
        			</td>
                    <td>
                        {!! Form::select("shipping_statuses[$key]", $shipping_statuses, $default_settings['shipping_statuses'][$key] ?? null, ['class' => 'form-control select2', 'style' => 'width: 100%;', 'placeholder' => __('messages.please_select')]); !!}
                    </td>
        		</tr>
        		@endforeach
        	</table>
        </div>
    </div>
</div>