@extends('layouts.app')
@section('title', 'Brands')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>@lang( 'brand.brands' )
        <small>@lang( 'brand.manage_your_brands' )</small>
    </h1>
    <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
    </ol> -->
</section>
<br>
@include('layouts.navs.products_nav')
<!-- Main content -->
<section class="content">
    @component('components.widget', ['class' => 'box-primary', 'title' => __( 'brand.all_your_brands' )])
        @can('brand.create')
            @slot('tool')
                <div class="box-tools">
                    <button type="button" class="btn btn-block btn-primary btn-modal" 
                        data-href="{{action('BrandController@create')}}" 
                        data-container=".brands_modal">
                        <i class="fa fa-plus"></i> @lang( 'messages.add' )</button>
                </div>
            @endslot
        @endcan
        @can('brand.view')
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="brands_table">
                    <thead>
                        <tr>
                            <th>@lang( 'brand.brands' )</th>
                            <th>@lang( 'brand.note' )</th>
                            <th>@lang( 'messages.action' )</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endcan
    @endcomponent

    <div class="modal fade brands_modal" tabindex="-1" role="dialog" 
    	aria-labelledby="gridSystemModalLabel">
    </div>

</section>
<!-- /.content -->

@endsection

@section('javascript')
<script>

    $(document).ready(function(){
        
        // show more
        $(document).on('click','button.more_btn',function(){
            let divElement = $('div#more_div');
            if(divElement.hasClass('hide')){
                $('div#more_div').removeClass('hide');
            } else{
                $('div#more_div').addClass('hide');
            }
            // $('div#more_div').removeClass('hide');
        });
        
        // store
    //     $(document).on('submit', 'form#brand_add_form', function(e) {
    //         console.log('submit');
    //     e.preventDefault();
    //     let form = new FormData();
    //     let form_data = $('form#brand_add_form').serializeArray();
        
    //     $.each(form_data, function (key, input) {
    //         form.append(input.name, input.value);
    //     });
    //     var form_test = $(this);
        
    //     let logoFile = $('input#logo')[0].files[0];
        
    //     form.append('logo',logoFile);
        
    //     $.ajax({
    //         method: 'POST',
    //         url: $(this).attr('action'),
    //         dataType: 'json',
    //         data: form,
    //         processData: false,
    //         contentType: false,
    //         beforeSend: function(xhr) {
    //             __disable_submit_button(form_test.find('button[type="submit"]'));
    //         },
    //         success: function(result) {
    //             if (result.success === true) {
    //                 $('div.brands_table').modal('hide');
    //                 toastr.success(result.msg);
    //                 brands_table.ajax.reload();
    //             } else {
    //                 toastr.error(result.msg);
    //             }
    //         },
    //     });
    // });
    });
</script>
@endsection
