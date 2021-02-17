@extends('layouts.backend.app')

@section('title', 'Product')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ADD NEW PRODUCT
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ !empty(old('name')) ? old('name') : '' }}">
                                <label class="form-label">Product Name</label>
                                
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('quantity') ? 'focused error' : '' }}">
                                <input type="number" id="quantity" class="form-control @error('quantity') is-invalid @enderror" 
                                    name="quantity" min="0" value="{{ !empty(old('quantity')) ? old('quantity') : '' }}">
                                <label class="form-label">Quantity</label>
                                
                            </div>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('price') ? 'focused error' : '' }}">
                                <input type="number" id="price" class="form-control @error('price') is-invalid @enderror" 
                                    name="price" min="0" step=".01" value="{{ !empty(old('price')) ? old('price') : '' }}">
                                <label class="form-label">Unit Price</label>
                                
                            </div>
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                                <label class="form-label">Product Image</label>
                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" onchange="loadFile(event)">
                                
                                <img id="preview">
                            
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.product.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Category and Supplier
                        </h2>
                    </div>
                    <div class="body">
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
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('supplier') ? 'focused error' : '' }}">
                                <label for="tag">Select Supplier</label>
                                <select name="supplier" id="supplier" data-live-search="true" 
                                    class="form-control show-tick @error('supplier') is-invalid @enderror">
                                        <option value="" selected disabled>Nothing Selected</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->organization }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('supplier')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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

<!-- Preview Image -->
    <script type="text/javascript">
        
        var loadFile = function(event) {
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function() {
                preview.style.height = '100px';
                preview.style.width = '100px';
               
            URL.revokeObjectURL(preview.src) // free memory
            }
        };
          
    </script>
@endpush