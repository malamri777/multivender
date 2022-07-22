@extends('seller.layouts.app')
@section('panel_content')

<div class="aiz-titlebar mt-2 mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Add Existing Product') }}</h1>
        </div>
    </div>
</div>

<form class="" action="{{route('supplier.products.exist.store')}}" method="POST" enctype="multipart/form-data" id="form">
    <div class="row gutters-5">
        <div class="col-lg-12">
            @csrf
            <input type="hidden" name="product_id" value="">
            <input type="hidden" name="warehouse_product_id" value="">
            <input type="hidden" name="added_by" value="seller">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Product Information')}}</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('SKU')}}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="sku" id="sku" required>
                            @include('backend.inc.form-span-error', ['field' => 'sku'])
                        </div>
                        <div class="col-md-2">
                            <button id="sku_btn" type="button" class="btn btn-dark">{{ translate('Search') }}</button>
                        </div>

                    </div>
                    <div id="product_name_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Name')}}</label>
                        <div class="col-md-8">
                            <input id="product_name" type="text" class="form-control" name="name" disabled>
                        </div>
                    </div>
                    <div id="product_warehouse_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Warehouse')}}</label>
                        <div class="col-md-8">
                            <select class="form-control aiz-selectpicker" name="warehouse_id" id="warehouse_option"
                                data-live-search="true" required="true">
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'warehouse_id'])
                        </div>
                    </div>
                    <div id="new_product" style="text-align: center; font-family: Poppins, Helvetica, sans-serif; color: #1b1b28; margin: 20px;">
                        Create New Warehouse Product
                    </div>

                    <div id="product_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Unit price')}} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="{{ translate('Unit price') }}" name="price" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'price'])
                        </div>
                    </div>

                    <div id="product_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Quantity')}} <span class="text-danger">*</span></label>
                        <div class="col-md-8">
                            <input type="number" lang="en" min="0" value="0" step="1" placeholder="{{ translate('Quantity') }}" name="quantity" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'quantity'])
                        </div>
                    </div>

                    <div id="product_input" class="form-group row">
                        <label class="col-sm-3 control-label" for="start_date">{{translate('Sale Price Date Range')}}</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control aiz-date-range" name="date_range" placeholder="{{translate('Select Date')}}" data-time-picker="true" data-format="DD-MM-Y" data-separator=" to " autocomplete="off">
                        </div>
                    </div>

                    <div id="product_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Sale Price')}} </label>
                        <div class="col-md-5">
                            <input type="number" lang="en" min="0" value="0" step="0.01" placeholder="{{ translate('Sale Price') }}" name="sale_price" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'sale_price'])
                        </div>
                        <div class="col-md-3">
                            <select id="type_option" class="form-control aiz-selectpicker" name="sale_price_type">
                                <option value="amount">{{translate('Flat')}}</option>
                                <option value="percent">{{translate('Percent')}}</option>
                            </select>
                            @include('backend.inc.form-span-error', ['field' => 'sale_price_type'])
                        </div>
                    </div>

                    <div id="product_input" class="form-group row">
                        <label class="col-md-3 col-from-label">{{translate('Low Stock Quantity Warning')}}</label>
                        <div class="col-md-8">
                            <input type="number" lang="en" min="0" value="0" step="1" placeholder="{{ translate('Low Stock Quantity') }}" name="low_stock_quantity" class="form-control" required>
                            @include('backend.inc.form-span-error', ['field' => 'low_stock_quantity'])
                        </div>
                    </div>

                </div>
            </div>

        <div class="col-12">
            <div class="mar-all text-center mb-2">
                <button type="submit" class="btn btn-primary">{{ translate('Save Product') }}</button>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script')
<script type="text/javascript">


        var clicked = false;
        $('#sku_btn').on('click',function(){
            if(!clicked){
                get_product_by_sku()
                clicked = true;
                setInterval(function(){
                    clicked = false;
                },3000)
            }
        })



        $(document).ready(function() {
            $("[id='product_input']").hide();
            $("#product_warehouse_input").hide();
            $("#product_name_input").hide();
            $('#new_product').hide()
        })

        $('#warehouse_option').change(function(){
            get_product_by_sku($('#warehouse_option').val())
        })

        function loadWarehouses(html){
            $('#warehouse_option').empty();
            $('#warehouse_option').append(html);
            AIZ.plugins.bootstrapSelect('refresh');
        }



        function get_product_by_sku(warehouse){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                url:'{{ route('supplier.products.sku') }}',
                data:{
                    sku: $('#sku').val(),
                    warehouse: warehouse
                },
                success: function(result) {
                    console.log(result);
                    if(result.product){
                        $("#product_warehouse_input").show();
                        $("#product_name_input").show();
                        $('#product_name').val(result.product.name);
                        $('#form input[name=product_id]').val(result.product.id);
                        $("[id='product_input']").hide();
                        $('#new_product').hide()
                        loadWarehouses(result.html)

                        if(result.warehouse_product != false && result.warehouse_product != null){
                            loadWarehouses(result.html)
                            $('#new_product').hide()
                            $('#form input[name=warehouse_product_id]').val(result.warehouse_product.id);
                            $("[id='product_input']").show();
                            $('#form input[name=price]').val(result.warehouse_product.price)
                            $('#form input[name=sale_price]').val(result.warehouse_product.sale_price)
                            $('#form input[name=quantity]').val(result.warehouse_product.quantity)
                            $('#form input[name=low_stock_quantity]').val(result.warehouse_product.low_stock_quantity)
                            $('#form input[name=date_range]').val(result.warehouse_product.sale_price_start_date+' to '+result.warehouse_product.sale_price_end_date)
                            $('#type_option').val(result.warehouse_product.sale_price_type)
                            $('#type_option').selectpicker('refresh');
                        }else if(result.warehouse_product == false){
                            $('#new_product').show()
                            $('#form input[name=warehouse_product_id]').val('');
                            $('#form input[name=price]').val('')
                            $('#form input[name=sale_price]').val('')
                            $('#form input[name=quantity]').val('')
                            $('#form input[name=low_stock_quantity]').val('')
                            $('#form input[name=date_range]').val('')
                            $("[id='product_input']").show();
                            $('#form input[name=price]').prop('required',true);
                            $('#form input[name=low_stock_quantity]').prop('required',true);
                            $('#form input[name=date_range]').prop('required',true);
                            $('#type_option').prop('required',true);
                            $('#type_option').val('')
                            $('#type_option').selectpicker('refresh');
                        }

                    }else{
                        $("[id='product_input']").hide();
                        $("#product_warehouse_input").hide();
                        $("#product_name_input").hide();
                    }

                },
                catch: (e) => {
                    console.log("error", e);
                }
            });
        }

</script>
@endsection
