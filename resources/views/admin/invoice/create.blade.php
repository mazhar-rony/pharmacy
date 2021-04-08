@extends('layouts.backend.app')

@section('title', 'Invoice')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    
<!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
    
<!-- Bootstrap DatePicker Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    
<!-- Wait Me Css -->
    {{--  <link href="{{ asset('assets/backend/plugins/waitme/waitMe.css') }}" rel="stylesheet" />  --}}
    
    <style>
        .loader {
            position: absolute;
            height: 80px;;
            right: -5px;
            bottom: 10px;
        }
        input::-webkit-outer-spin-button, 
        input::-webkit-inner-spin-button { 
            margin-left: 5px; 
        } 
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        INVOICE
                    </h2>
                </div>
                <div class="body">                        
                    <div class="row clearfix">
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group form-float">
                                <label for="invoice">Invoice No</label>
                                <input id="invoice" name="invoice" type="text" class="form-control align-center"
                                    value="{{ $invoice_no }}" 
                                    style="border: 1px solid; 
                                    border-color: #ced4da; 
                                    background-color: #D8FDBA;
                                    font-size: 14px;" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label for="date">Date</label>
                            <div class="form-group">
                                <div class="form-line" id="bs_datepicker_container">
                                    <input type="text" id="invoice_date" name="invoice_date" class="form-control invoice_date" data-date-format="dd/mm/yyyy" placeholder="Choose a date...">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('category') ? 'focused error' : '' }}">
                                    <label for="category">Select Category</label>
                                    <select name="category" id="category" data-live-search="true" 
                                        class="form-control show-tick @error('category') is-invalid @enderror" required>
                                            <option value="">Nothing Selected</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('product') ? 'focused error' : '' }}">
                                    <label for="product">Select Product</label>
                                    <img class="loader" id="loader" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                    <select name="product" id="product" data-live-search="true" 
                                        class="form-control selectpicker show-tick @error('product') is-invalid @enderror" required>
                                            <option value="" disabled selected>Nothing Selected</option>
                                    </select>
                                </div>
                                @error('product')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <div class="form-group form-float">
                                <label for="stock">Stock</label>
                                <input type="text" class="form-control align-center" name="stock" id="stock" value="" 
                                    style="border: 1px solid; 
                                    border-color: #ced4da; 
                                    background-color: #D8FDBA;
                                    font-size: 14px;" readonly>
                            </div>
                        </div>

                        <input type="hidden" id="cost" name="cost" value="">

                        <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                            <label for="">Add +</label>                            
                            {{--  <button type="button" class="form-control btn btn-success waves-effect addmoreevent" style="margin-top: 25px;">  --}}
                                <button type="button" class="form-control btn btn-success waves-effect addmoreevent">
                                <i class="material-icons">local_grocery_store</i>
                                {{--  <span>Add</span>  --}}
                            </button>
                        </div>
                    </div>                                             
                </div>
                <div class="body">
                    <form action="{{ route('admin.invoice.store') }}" method="POST" id="invForm">
                    @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Product Name</th>
                                        <th width="10%">QTY</th>
                                        <th width="12%">Unit Price</th>
                                        <th width="17%">Total Price</th>
                                        <th width="7%">Action</th>                                   
                                    </tr>
                                </thead>
                                
                                <tbody id="addRow" class="addRow">
                                    
                                </tbody>
                                    <tr>
                                        <td colspan="4" class="text-right" style="font-weight: bold;">Discount</td>
                                        <td>
                                            <input type="number" id="discount" name="discount" value="0"
                                                class="form-control form-control-sm text-right discount"
                                                min="0" step=".01">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right" style="font-weight: bold;">Total Amount</td>
                                        <td>
                                            <input type="text" id="total_amount" name="total_amount" value="0"
                                                class="form-control form-control-sm text-right total_amount" 
                                                style="background-color: #D8FDBA;" readonly>
                                        </td>
                                        <td></td>
                                    </tr>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <textarea name="description" id="description" class="form-control"
                                placeholder="Write description here..."></textarea>
                        </div>
                        <br>
                        <div class="row clearfix">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                                
                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('customer') ? 'focused error' : '' }}">
                                    <select name="customer" id="customer" data-live-search="true" 
                                        class="form-control show-tick @error('customer') is-invalid @enderror" required>
                                            <option value="" disabled selected>Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }} ( contact: {{ $customer->phone }} )</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('customer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group form-float">
                                    <label for="">Payment Type:</label>
                                
                                    <input name="payment_type" type="radio" id="cash" value="cash" class="with-gap radio-col-pink" checked />
                                    <label for="cash">CASH</label>
                                    <input name="payment_type" type="radio" id="cheque" value="cheque" class="with-gap radio-col-pink" />
                                    <label for="cheque">CHEQUE</label>
                                </div>
                            </div>
                            <div class="bank_info" style="display:none">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">                                
                                    <div class="form-group form-float">
                                        <div class="form-line {{ $errors->has('bank') ? 'focused error' : '' }}">
                                            <select name="bank" id="bank" data-live-search="true" 
                                                class="form-control show-tick @error('bank') is-invalid @enderror">
                                                    <option value="" disabled selected>Select Bank</option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('bank')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">                                
                                    <div class="form-group form-float">
                                        <div class="form-line {{ $errors->has('account') ? 'focused error' : '' }}">
                                            <img class="loader" id="loader_account" src="{{Storage::disk('public')->url('ajax-loader.gif')}}" alt="">
                                            <select name="account" id="account" data-live-search="true" 
                                                class="form-control selectpicker show-tick @error('account') is-invalid @enderror">
                                                    <option value="" disabled selected>Select Account No</option>
                                            </select>
                                        </div>
                                        @error('account')
                                            <span class="invalid-feedback" role="alert">
                                                <strong style="color: red">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.invoice.index') }}">BACK</a>
                        <button type="submit" id="submitButton" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    
<!-- Autosize Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/autosize/autosize.js') }}"></script>

<!-- Moment Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/momentjs/moment.js') }}"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
    
<!-- Bootstrap Datepicker Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>

<!-- Html Table Content for Add Products -->
    <script id="document-template" type="text/x-handlebars-template">
        <tr id="delete_add_more_item" class="delete_add_more_item">
            <input type="hidden" name="invoice" value="@{{invoice}}">
            <input type="hidden" name="invoice_date" value="@{{invoice_date}}">
            <input type="hidden" name="stock[]" class="form-control form-control-sm text-center stock" value="@{{stock}}">
            <input type="hidden" id="cost" name="cost[]" value="@{{cost}}">
            <td>
                <input type="hidden" name="category[]" value="@{{category}}">
                @{{category_name}}
            </td>
            <td>
                <input type="hidden" name="product[]" class="form-control form-control-sm text-right product" value="@{{product}}">
                @{{product_name}}
            </td>
            <td>
                <input type="number" class="form-control form-control-sm text-center quantity"
                    name="quantity[]" min="1" value="1">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm text-center unit_price"
                    name="unit_price[]" value="0" min="0" step=".01">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm text-right total_price"
                    name="total_price[]" value="0" readonly>
            </td>
            <td>
                <button class="btn btn-danger btn-sm waves-effect removeitem" type="button">
                    <i class="material-icons">disabled_by_default</i>
                </button>
            </td>
        </tr>
    </script>

<!-- Add to Cart Event -->
    <script>
        $(document).ready(function(){
            $(document).on("click",".addmoreevent",function(){
                var invoice_date = $('#invoice_date').val();
                var invoice = $('#invoice').val();
                var category = $('#category').val();
                var category_name = $('#category').find('option:selected').text();
                var product = $('#product').val();
                var product_name = $('#product').find('option:selected').text();
                var stock = $('#stock').val();
                var cost = $('#cost').val();
                
                if(category == ''){
                    toastr.error('Category is required.', 'Error',{
                        closeButton:true,
                        progressBar:true,
                    });
                }
                else if(product == ''){
                    toastr.error('Product is required.', 'Error',{
                        closeButton:true,
                        progressBar:true,
                    });
                }
                else if(!isNaN(stock) && stock > 0){                    
                    if(checkDuplicate(product)){
                        //alert("back to function");
                        toastr.warning('Item already added, Quantity Increased !', 'Warning',{
                            closeButton:true,
                            progressBar:true,
                        });
                    }
                    else{
                        var source = $("#document-template").html();
                        var template = Handlebars.compile(source);
                        var data = {
                            invoice_date:invoice_date,
                            invoice:invoice,
                            category:category,
                            category_name:category_name,
                            product:product,
                            product_name:product_name,
                            stock:stock,
                            cost:cost
                            };
                        var html = template(data);
                        $("#addRow").append(html);
                    }                                       
                }
                else{
                    toastr.error('Out of Stock', 'Error',{
                        closeButton:true,
                        progressBar:true,
                    });
                }
            });

            function checkDuplicate(prod){
                var result = false;
                $(".product").each(function(){
                    var value = $(this).val();
                    //alert(prod);
                    //alert(value);                    
                    if(value == prod){                 
                        var quantity = $(this).closest("tr").find("input.quantity").val();
                        
                        quantity = parseInt(quantity) + parseInt(1);
                        //trigger make changes Total Price
                        $(this).closest("tr").find("input.quantity").val(quantity).trigger("keyup");
                        
                        //alert("done");
                        result = true;                        
                    }                    
                });
                //alert(result);
                return result;                
            }

            
            $(document).on("click", ".removeitem", function(event){
                $(this).closest("#delete_add_more_item").remove();
                totalAmountPrice();
            });

            $(document).on("keyup click", ".unit_price, .quantity", function(){
                var unit_price = $(this).closest("tr").find("input.unit_price").val();
                var qty = $(this).closest("tr").find("input.quantity").val();                
                //var stock_limit = $('#stock').val();
                var stock_limit = $(this).closest("tr").find("input.stock").val();

                $(this).closest("tr").find("input.quantity").attr({"max": stock_limit});

                //if(qty <= stock_limit){
                    //console.log(qty);

                var total_price = unit_price * qty;
                $(this).closest("tr").find("input.total_price").val(total_price.toFixed(2));
                //totalAmountPrice();
                $('#discount').trigger('keyup');

                //}
                /*else{
                    toastr.error('Quantity is more than Stock Limit !', 'Error',{
                        closeButton:true,
                        progressBar:true,
                    });
                }*/


            });

            $(document).on('keyup click', '#discount', function(){
                totalAmountPrice();
            });


            function totalAmountPrice(){
                var sum = 0;
                $(".total_price").each(function(){
                    var value = $(this).val();
                    if(!isNaN(value) && value.length != 0){
                        sum += parseFloat(value);
                    }
                });
                var discount = parseFloat($('#discount').val());
                if(!isNaN(discount) && discount.length != 0){
                    sum -= parseFloat(discount);
                }
                $("#total_amount").val(sum.toFixed(2));
            }
        });
    </script>

<!-- Show Bank Info for Cheque Payment -->

    <script>
        $(document).on('change', 'input[name=payment_type]', function(){
            var payment_type = $(this).val();
            if(payment_type == 'cheque'){
                $('.bank_info').show();
                $('#bank').attr({"required": true});
                $('#account').attr({"required": true});
            }else{
                $('.bank_info').hide();
                $('#bank').attr({"required": false});
                $('#account').attr({"required": false});
            }
        });
    </script>

<!-- Date Picker Select Today -->
    <script type="text/javascript">    
        $(document).ready(function() {
            
            $('.invoice_date').datepicker('setDate', 'now');

            $(".invoice_date").datepicker({
                endDate: new Date()
            });
            
            //Not Working....
            /*$('#datepicker').datepicker({
                //format: "dd-mm-yyyy",
                //autoclose:true,
                //minDate: new Date(year, 0, 1),
                //maxDate:new Date(year, 11, 31)
           
            });*/              
        });
    </script>

<!-- Dependency Dropdown for Products -->
    <script>    
        //$(function() {
        var loader = $('#loader'),
        category = $('select[name="category"]'),
        product = $('select[name="product"]');

        loader.hide();
        product.attr('disabled','disabled');

            $(document).on('change', '#category', function(){
                var category = $(this).val();
                if(category){
                    loader.show();
                    product.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getProducts')}}",
                        type: "GET",
                        data: {category:category},                   
                        success: function(data){
                            var option = '<option value="">Nothing Selected</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.name+'</option>';
                            });
                            product.removeAttr('disabled');
                            $('#product').html(option);
                            //product.html(option);
                            loader.hide();
                            $('#stock').val('');
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            product.change(function(){
                var id = $(this).val();
                if(!id){
                    product.attr('disabled','disabled');
                }
            })
                    
        //});
    </script>

<!-- Dependency Dropdown for Stock & Cost -->
    <script>
        $(document).on('change', '#product', function(){
            var product = $(this).val();
                $.ajax({
                    url: "{{route('admin.invoice.getQuantity')}}",
                    type: "GET",
                    data: {product:product},                   
                    success: function(data){
                        $('#stock').val(data.quantity);
                        $('#cost').val(data.price);
                    },
                    error: function(xhr, status, error) {
                       
                    },
                });
        });
    </script>

<!-- Dependency Dropdown for Account No -->
    <script>    
        //$(function() {
        var loader_account = $('#loader_account'),
        bank = $('select[name="bank"]'),
        account = $('select[name="account"]');

        loader_account.hide();
        account.attr('disabled','disabled');

            $(document).on('change', '#bank', function(){
                var bank = $(this).val();
                if(bank){
                    loader_account.show();
                    account.attr('disabled','disabled');

                    $.ajax({
                        url: "{{route('admin.invoice.getBankAccounts')}}",
                        type: "GET",
                        data: {bank:bank},                   
                        success: function(data){
                            var option = '<option value="">Select Acount No</option>';
                            $.each(data, function(key,value){
                                option += '<option value="'+value.id+'">'+value.account_number+'</option>';
                            });
                            account.removeAttr('disabled');
                            $('#account').html(option);
                            //account.html(option);
                            loader_account.hide();
                            $(".selectpicker").selectpicker("refresh");
                        },
                        error: function(xhr, status, error) {
                            // check status && error
                            //console.log(error);
                        },
                    });
                }
            });

            account.change(function(){
                var id = $(this).val();
                if(!id){
                    account.attr('disabled','disabled');
                }
            })
                    
        //});
    </script>
   
@endpush