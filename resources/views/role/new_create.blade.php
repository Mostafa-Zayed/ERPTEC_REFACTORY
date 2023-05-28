@extends('layouts.app')
@section('title', __('role.add_role'))

@section('content')
<!-- Main content -->
<section>
    <div class="main-bg">
        <div class="section-body">
            {!! Form::open(['url' => action('RoleController@store'), 'method' => 'post', 'id' => 'role_add_form', 'class' => 'add-product-form' ]) !!}
                <!-- Buttons -->
                <!--<div class="add-product-btns d-flex align-items-center flex-wrap mb-3 sticky-top">-->
                <!--    <button type="submit" class="main-dark-btn-lg" id="submit_user_button">@lang( 'messages.save' )</button>-->
                <!--</div>-->
                <!-- Box 1 -->
                <div class="default-box">
                    <div class="default-box-head d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-user-shield"></i> @lang('role.add_role')</h4>
                    </div>
                    <div class="default-box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('name', __( 'user.role_name' ) . ':*') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __( 'user.role_name' ) ]); !!}
                                </div>
                            </div>
                            @if(in_array('service_staff', $enabled_modules))
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>@lang( 'lang_v1.user_type' )</h4>
                                    </div>
                                    <div class="col-md-9 col-md-offset-1">
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('is_service_staff', 1, false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'restaurant.service_staff' ) }}
                                                </label>
                                                @show_tooltip(__('restaurant.tooltip_service_staff'))
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Box 2 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-user"></i> @lang( 'role.user' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'user.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'user.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'user.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'user.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.user.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 3 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-lock-open"></i> @lang( 'user.roles' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'roles.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.view_role' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'roles.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.add_role' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'roles.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.edit_role' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'roles.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.delete_role' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 4 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-parachute-box"></i> @lang( 'role.supplier' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                {{--
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                --}}
                                <div>
                                    <div class="id-check">
                                        <div class="d-flex flex-wrap">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.view', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.view' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.create' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.update', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.update' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.delete', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.supplier.delete' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.enable_add_supplier_to_employee', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.enable_add_supplier_to_employee') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="id-check">
                                        <div class="d-flex flex-wrap">
                                            <!--Mostafa Zayed 22 / Des / 2021 Moved Live 23 / Des / 2021-->
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.view_supplier_groups_only', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.view_supplier_groups_only') }}
                                                </label>
                                            </div>
                                            <!--end-->
                                            <!--Mostafa Zayed 27 / Des / 2021 -->
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'supplier.enable_add_supplier_to_user', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.enable_add_supplier_to_user') }}
                                                </label>
                                            </div>
                                            <!--end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 5 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-male"></i> @lang( 'role.customer' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                {{--
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                --}}
                                <div>
                                    <div class="id-check">
                                        <div class="d-flex flex-wrap">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.view', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.view' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.create' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.update', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.update' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.delete', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.customer.delete' ) }}
                                                </label>
                                            </div>
                                            <!--Mostafa Zayed 27 / Des / 2021 Moved Live 28 / Des / 2021-->
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.enable_add_customer_to_employee', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.enable_add_customer_to_employee') }}
                                                </label>
                                            </div>
                                            <!--end-->
                                        </div>
                                    </div>
                                    <div class="id-check">
                                        <div class="d-flex flex-wrap">
                                            <!--Mostafa Zayed 22 / Des / 2021 Moved Live 23 / Des / 2021-->
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.view_customer_groups_only', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.view_customer_groups_only') }}
                                                </label>
                                            </div>
                                            <!--end-->
                                            <!--Mostafa Zayed 27 / Des / 2021 Moved Live 28 / Des / 2021-->
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'customer.enable_add_customer_to_user', false, 
                                                    [ 'class' => 'input-icheck']); !!}  {{ __('lang_v1.enable_add_customer_to_user') }}
                                                </label>
                                            </div>
                                            <!--end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 6 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-layer-group"></i> @lang( 'stock_adjustment.stock_adjustment' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_adjustment.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'stock_adjustment.list' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_adjustment.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'stock_adjustment.add' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_adjustment.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'stock_adjustment.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 7 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-exchange-alt"></i> @lang( 'lang_v1.stock_transfers' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_transfers.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.list_stock_transfers' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_transfers.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.add_stock_transfer' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_transfers.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.stock_transfer_delete' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'transfer_status', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.stock_transfer_status') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'transfer_unit_price', false,['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.transfer_unit_price') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 8 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-money-bill"></i> @lang( 'role.expensive' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'expense.access', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'expense.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'expense.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'expense.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 9 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-box-open"></i> @lang( 'business.product' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'product.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'product.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                            {!! Form::checkbox('permissions[]', 'product.update', false, 
                                            [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'product.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.product.delete' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'product.opening_stock', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.add_opening_stock' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'view_purchase_price', false,['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.view_purchase_price') }}
                                            </label>
                                            @show_tooltip(__('lang_v1.view_purchase_price_tooltip'))
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'labels.view', false,['class' => 'input-icheck']); !!}
                                                {{ __('barcode.print_labels') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shippingtype', false,['class' => 'input-icheck']); !!}
                                                {{ __('sale.shipping_type') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'storenumber', false,['class' => 'input-icheck']); !!}
                                                {{ __('sale.store_number') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'warranties', false,['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.warranties') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'update_card_stock', false,['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.update_card_stock') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Box 13 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-medal"></i> @lang( 'role.brand' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'brand.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'brand.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'brand.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'brand.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.brand.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Box 15 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-th-large"></i> @lang( 'role.unit' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'unit.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'unit.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'unit.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'unit.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.unit.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 16 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-th"></i> @lang( 'category.category' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'category.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'category.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'category.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'category.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.category.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 10 -->
                @if(in_array('purchases', $enabled_modules) || in_array('stock_adjustment', $enabled_modules) )
                    <div class="default-box default-box-dashed">
                        <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                            <h4><i class="fas fa-pallet"></i> @lang( 'role.purchase' )</h4>
                            <i class="fas fa-caret-down main-color-light"></i>
                        </div>
                        <div class="default-box-body hidden-default-box-body">
                            <div class="row">
                                <div class="form-group check_group">
                                    <div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                        <div class="d-flex flex-wrap">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.view', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.view' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.create' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.update', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.update' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.delete', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase.delete' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.payments', false,['class' => 'input-icheck']); !!}
                                                    {{ __('lang_v1.purchase.payments') }}
                                                </label>
                                                    @show_tooltip(__('lang_v1.purchase_payments'))
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase.update_status', false,['class' => 'input-icheck']); !!}
                                                    {{ __('lang_v1.update_status') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Box 11 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-shopping-cart"></i> @lang( 'sale.general_sales' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="row">
                                        @if(in_array('add_sale', $enabled_modules))
                                            <div class="checkbox col-lg-3 col-md-6">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'direct_sell.access', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.direct_sell.access' ) }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell_retail.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell_retail.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'list_drafts', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.list_drafts' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'list_quotations', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.list_quotations' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'view_own_sell_only', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.view_own_sell_only' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6 d-flex">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell.payments', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.sell.payments') }}
                                            </label>
                                            @show_tooltip(__('lang_v1.sell_payments'))
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_product_price_from_pos_screen', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_product_price_from_pos_screen') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_product_discount_from_sale_screen', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_product_discount_from_sale_screen') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_product_discount_from_pos_screen', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_product_discount_from_pos_screen') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'discount.access', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.discount.access') }}
                                            </label>
                                        </div>
                                      
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell_print', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.sell_print') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell_return', false, ['class' => 'input-icheck']); !!}
                                                {{ __('role.sell_return') }}
                                            </label>
                                        </div> <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'substitution', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.substitution') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell_discount', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.sell_discount') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_product_price_down', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_product_price_down') }}
                                            </label>
                                        </div> 
                                        
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'add_comment', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.add_comment') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-shopping-cart"></i> @lang( 'lang_v1.sell_booking' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="row">
                                       
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell_booking', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.sell_booking') }}
                                            </label>
                                        </div>
                                            
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'create_book', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.create_book') }}
                                            </label>
                                        </div>
                                          <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_book', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_book') }}
                                            </label>
                                        </div>
                                         <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'delete_book', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.delete_book') }}
                                            </label>
                                        </div>
                                          <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'convert_book', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.convert_book') }}
                                            </label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 11 + -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-globe"></i> @lang( 'sale.sale' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="row">
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.view' ) }}
                                            </label>
                                        </div>
                                        @if(in_array('pos_sale', $enabled_modules))
                                            <div class="checkbox col-lg-3 col-md-6">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'sell.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.create' ) }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sell.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.delete' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_product_price_from_sale_screen', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_product_price_from_sale_screen') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'access_shipping', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.access_shipping') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shipping_cost', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.shipping_cost') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'order.show', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.order_status_show') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shipping.show', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.shipping_status_show') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'order.edit', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.order_status_edit') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shipping.edit', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.shipping_status_edit') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'logs.assign', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.logs_assign') }}
                                            </label>
                                        </div>
                                        <!--  <div class="col-md-12">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'edit_product_price_up', false, ['class' => 'input-icheck']); !!}
                                                    {{ __('lang_v1.edit_product_price_up') }}
                                                </label>
                                            </div>
                                        </div>-->
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'check_sell', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.check_sell') }}
                                            </label>
                                        </div>
                                        <div class="checkbox col-lg-3 col-md-6">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'edit_after_confirmation', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.edit_after_confirmation') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 12 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-store-alt"></i> @lang( 'sale.retail_sale' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'retail.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'retail.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'retail.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'retail.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sell.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 14 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-percent"></i> @lang( 'role.tax_rate' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'tax_rate.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'tax_rate.create', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.create' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'tax_rate.update', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.update' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'tax_rate.delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_rate.delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 17 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-file-alt"></i> @lang( 'role.report' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        @if(in_array('purchases', $enabled_modules) || in_array('add_sale', $enabled_modules) || in_array('pos_sale', $enabled_modules))
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'purchase_n_sell_report.view', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.purchase_n_sell_report.view' ) }}
                                                    </label>
                                            </div>
                                        @endif
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'tax_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.tax_report.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'contacts_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.contacts_report.view' ) }}
                                            </label>
                                        </div>
                                        @if(in_array('expenses', $enabled_modules))
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'expense_report.view', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'role.expense_report.view' ) }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'profit_loss_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.profit_loss_report.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'stock_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.stock_report.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'trending_product_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.trending_product_report.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'register_report.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.register_report.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sales_representative.view', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.sales_representative.view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shipment_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.shipment_report_view' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'report_courier', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.report_courier_view' ) }}
                                            </label>
                                        </div>  
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'customer_dues_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'sale.customer_dues_report' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'profit_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'report.profit_report' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'sale_sell_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.sale_sell_report' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'delegate_dues', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.delegate_dues' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'filter_users', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.filter_users' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'user_sell_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'report.user_sell_report' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'opennig_stock_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'report.opennig_stock_report' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 18 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-cogs"></i> @lang( 'role.settings' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'business_settings.access', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.business_settings.access' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'barcode_settings.access', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.barcode_settings.access' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'invoice_settings.access', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.invoice_settings.access' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'connector.api', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'connector::lang.connector' ) }}
                                            </label>
                                        </div>
                                        @if(in_array('expenses', $enabled_modules)) @endif
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'shipment_zones', false, ['class' => 'input-icheck']); !!}
                                                {{ __('lang_v1.shipment_zones') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 19 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-home"></i> @lang( 'role.dashboard' )@show_tooltip(__('tooltip.dashboard_permission'))</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'dashboard.data', true, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.dashboard.data' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'dashboard.view_tutorial', false, 
                                                [ 'class' => 'input-icheck']); !!} {{__('lang_v1.view_tutorial') }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'dashboard.view_playlist', false, 
                                                [ 'class' => 'input-icheck']); !!} {{__('lang_v1.view_playlist') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 20 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-file-invoice-dollar"></i> @lang( 'account.account' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.access', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.access_accounts' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.balance_sheet', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'account.balance_sheet' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.trial_balance', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'account.trial_balance' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.cash_flow', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.cash_flow' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.payment_account_report', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'account.payment_account_report' ) }}
                                            </label>
                                        </div>  
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'account.trans_delete', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'account.trans_delete' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 21 -->
                @if(in_array('tables', $enabled_modules) && in_array('service_staff', $enabled_modules) )
                    <div class="default-box default-box-dashed">
                        <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                            <h4><i class="fas fa-utensils"></i> @lang( 'restaurant.bookings' )</h4>
                            <i class="fas fa-caret-down main-color-light"></i>
                        </div>
                        <div class="default-box-body hidden-default-box-body">
                            <div class="row">
                                <div class="form-group check_group">
                                    <div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                        <div class="d-flex flex-wrap">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'crud_own_bookings', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'restaurant.add_edit_view_own_booking' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'restaurant.kitchen', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'restaurant.kitchen' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'restaurant.orders', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'restaurant.orders' ) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- Box 22 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-hand-holding-usd"></i> @lang( 'lang_v1.access_selling_price_groups' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'access_default_selling_price', true, 
                                                [ 'class' => 'input-icheck']); !!} {{ __('lang_v1.default_selling_price') }}
                                            </label>
                                        </div>
                                        @if(count($selling_price_groups) > 0)
                                            @foreach($selling_price_groups as $selling_price_group)
                                                <div class="checkbox">
                                                    <label>
                                                        {!! Form::checkbox('spg_permissions[]', 'selling_price_group.' . $selling_price_group->id, false, 
                                                        [ 'class' => 'input-icheck']); !!} {{ $selling_price_group->name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 23 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-user-tie"></i> @lang( 'lang_v1.carrier_agent' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'carrier.agent', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.carrier_agent' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'carrier.account', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.carrier_account' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'choose.carrier', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.choose_carrier' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'order.status', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.order_status' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'payment.status', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.payment_status' ) }}
                                            </label>
                                        </div>
                                        <!-- 
                                        <div class="col-md-12">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'shipping.status', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.shipping_status' ) }}
                                                </label>
                                            </div>
                                        </div>  
                                        -->
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'assign.user', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.assign_user' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'assign.company', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.assign_company' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'assign.lead', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.assign_lead' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 24 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-bullhorn"></i> @lang( 'role.marketSetting' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'role.marketSetting', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.marketSetting' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'role.traficResource', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.traficResource' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'role.Campaigns', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.Campaigns' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 25 -->
                <div class="default-box default-box-dashed">
                    <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                        <h4><i class="fas fa-sliders-h"></i> @lang( 'role.ecommerceVowalaa' )</h4>
                        <i class="fas fa-caret-down main-color-light"></i>
                    </div>
                    <div class="default-box-body hidden-default-box-body">
                        <div class="row">
                            <div class="form-group check_group">
                                <div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div>
                                    <div class="d-flex flex-wrap">
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'role.ecommerceVowalaa', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.ecommerceVowalaa' ) }}
                                            </label>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                {!! Form::checkbox('permissions[]', 'role.activeStore', false, 
                                                [ 'class' => 'input-icheck']); !!} {{ __( 'role.activeStore' ) }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Box 26 -->
                @php
                    $business_id = request()->session()->get('user.business_id');
                    $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);
                    if (!empty($package)) {
                        $pack  = \Modules\Superadmin\Entities\Package::where('id',$package->package_id)->first();
                        if (!empty($pack)) { 
                            if(!empty($pack['custom_permissions']['account_module'])) {
                                if($pack['custom_permissions']['account_module'] == 1 ) {
                @endphp
                    <div class="default-box default-box-dashed">
                        <div class="default-box-head default-box-head-show-hide d-flex align-items-center justify-content-between">
                            <h4><i class="fas fa-file-invoice"></i> @lang( 'lang_v1.account_module' )</h4>
                            <i class="fas fa-caret-down main-color-light"></i>
                        </div>
                        <div class="default-box-body hidden-default-box-body">
                            <div class="row">
                                <div class="form-group check_group">
                                    <div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" class="check_all input-icheck" > {{ __( 'role.select_all' ) }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div>
                                        <div class="d-flex flex-wrap">
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'journal.show', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.accounts_show' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'journal.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.accounts_create' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'journal.edit', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.accounts_edit' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'daily.show', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.daily_show' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'daily.create', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.daily_create' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'daily.edit', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.daily_edit' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'daily.delete', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'lang_v1.daily_delete' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'costs_center.show', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'sale.costs_center' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'receipt_payment_papers', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'sale.receipt_payment_papers' ) }}
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    {!! Form::checkbox('permissions[]', 'journal_setting', false, 
                                                    [ 'class' => 'input-icheck']); !!} {{ __( 'sale.journal_setting' ) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @php
                                }
                            }
                    
                        }
                    
                    }   
                @endphp
                <!-- End Box 26 -->
       
                @include('role.partials.new_module_permissions')
                
                <button type="submit" class="main-dark-btn-lg" id="submit_user_button">@lang( 'messages.save' )</button>
            {!! Form::close() !!}
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('javascript')
<style>
    .id-check label .iCheck-helper{
        display: none !important;
    }
</style>
<script type="text/javascript">

$(".id-check label").click(function () {
    $(this).parents(".id-check").siblings(".id-check").find("input[type='checkbox']").prop("checked", false);
    $(this).parents(".id-check").siblings(".id-check").find(".icheckbox_square-blue").removeClass("checked");
});

$topValue = parseInt($('.cr-prod-fixed-top').css('top'));
    $(window).scroll(function() {
        if ($(document).scrollTop() < 132) {
            $('.cr-prod-fixed-top').css('top', $topValue - $(document).scrollTop());
        }
        else {
            $('.cr-prod-fixed-top').css('top', '0');
        }
    });
</script>
@endsection