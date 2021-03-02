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
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <form action="{{ route('admin.invoice.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            INVOICE
                        </h2>
                    </div>
                    <div class="body">
                        <form>
                            <div class="row clearfix">
                                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                    <div class="form-group form-float">
                                        <label for="invoice">Invoice No</label>
                                        <input id="invoice" type="text" class="form-control align-center" 
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
                                            <input type="text" id="" class="form-control invoice_date" data-date-format="dd/mm/yyyy" placeholder="Choose a date...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                    <div class="form-group form-float">
                                        <div class="form-line {{ $errors->has('category') ? 'focused error' : '' }}">
                                            <label for="category">Select Category</label>
                                            <select name="category" id="category" data-live-search="true" 
                                                class="form-control show-tick @error('category') is-invalid @enderror">
                                                    <option value="" selected disabled>Nothing Selected</option>
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
                                                class="form-control selectpicker show-tick @error('product') is-invalid @enderror">
                                                    <option value="" selected disabled>Nothing Selected</option>
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
                                        <label for="quantity">Stock</label>
                                        <input type="text" class="form-control align-center invoice" id="quantity" 
                                            style="border: 1px solid; 
                                            border-color: #ced4da; 
                                            background-color: #D8FDBA;
                                            font-size: 14px;" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-12">
                                    {{--  <label for=""></label>                               --}}
                                    <button type="button" class="form-control btn btn-success waves-effect" style="margin-top: 25px;">
                                        <i class="material-icons">local_grocery_store</i>
                                        {{--  <span>Add</span>  --}}
                                    </button>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Vertical Layout | With Floating Label -->
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

    <!-- Date Picker Select Today -->
    <script>    
        $(document).ready(function() {
            
            $('.invoice_date').datepicker('setDate', 'now');
            
            //Not Working....
            /*$('#datepicker').datepicker({
                //format: "dd-mm-yyyy",
                //autoclose:true,
                //minDate: new Date(year, 0, 1),
                //maxDate:new Date(year, 11, 31)
           
            });*/              
        });
    </script>
    <script>         
        var loader = $('#loader'),
        category = $('select[name="category"]'),
        product = $('select[name="product"]');

        loader.hide();
        product.attr('disabled','disabled');

        category.change(function(){
            var id = $(this).val();
            if(id){
                loader.show();
                product.attr('disabled','disabled');

                $.get('{{url('/admin/invoice/products?category=')}}'+id)
                    .success(function(data){
                        var option = '<option value="" selected disabled>Nothing Selected</option>';
                        data.forEach(function(row){
                            option += '<option value="'+row.id+'">'+row.name+'</option>'
                        })
                        product.removeAttr('disabled');
                        product.html(option);
                        loader.hide();
                        $(".selectpicker").selectpicker("refresh");
                    })
            }
        })

        product.change(function(){
            var id = $(this).val();
            if(!id){
                product.attr('disabled','disabled');
            }
        })
    </script>

@endpush