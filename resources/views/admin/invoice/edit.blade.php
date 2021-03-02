@extends('layouts.backend.app')

@section('title', 'Product')

@push('css')
    
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            PRODUCT
                        </h2>
                    </div>
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#product_info" data-toggle="tab" aria-expanded="false">
                                    <i class="material-icons">info</i> EDIT PRODUCT INFO
                                </a>
                            </li>
                            <li role="presentation" class="">
                                <a href="#change_quantity_and_price" data-toggle="tab" aria-expanded="true">
                                    <i class="material-icons">change_history</i> ADD MORE QUANTITY OR UPDATE PRICE
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade active in" id="product_info">
                                <form action="{{route('admin.product.update', $product->id)}}" method="POST" 
                                    class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="name">Product Name</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                                                        placeholder="Product Name" value="{{ !empty(old('name')) ? old('name') : $product->name }}">
                                                </div>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="category">Select Category</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('category') ? 'focused error' : '' }}">
                                                    <select name="category" id="category" data-live-search="true" 
                                                        class="form-control show-tick @error('category') is-invalid @enderror">
                                                        @foreach ($categories as $category)
                                                            <option {{ $product->category_id == $category->id ? 'selected' : '' }}
                                                                value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
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
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="supplier">Select Supplier</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('supplier') ? 'focused error' : '' }}">
                                                    <select name="supplier" id="supplier" data-live-search="true" 
                                                        class="form-control show-tick @error('supplier') is-invalid @enderror">
                                                        @foreach ($suppliers as $supplier)
                                                            <option {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}
                                                                value="{{ $supplier->id }}">{{ $supplier->organization }}
                                                            </option>
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
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="quantity">Quantity</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('quantity') ? 'focused error' : '' }}">
                                                    <input type="number" id="quantity" name="quantity" min="0" 
                                                        class="form-control @error('quantity') is-invalid @enderror" 
                                                        placeholder="Product quantity"
                                                        value="{{ !empty(old('quantity')) ? old('quantity') : $product->quantity }}">
                                                </div>
                                                @error('quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="price">Unit Price</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('price') ? 'focused error' : '' }}">
                                                    <input type="number" id="price" name="price" min="0" step=".01"
                                                        class="form-control @error('price') is-invalid @enderror" 
                                                        placeholder="Product price" 
                                                        value="{{ !empty(old('price')) ? old('price') : number_format(round($product->price, 2), 2) }}">
                                                </div>
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="image">Product Image</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" 
                                                    name="image" onchange="loadFile(event)">
                                                    
                                                @if (isset($product->image))
                                
                                                <img id="preview" src="{{ Storage::disk('public')->url('product/'.$product->image) }}"
                                                height="100px" width="100px" alt="Profile Image">
                                            
                                                @else
                                                {
                                                    <img id="preview">
                                                }
                                                    
                                                @endif
                                                
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                             
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.product.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div role="tabpanel" class="tab-pane fade" id="change_quantity_and_price">
                                <form action="{{route('admin.product.price', $product->id)}}" method="POST" 
                                    class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                            <label for="total_quantity">Total Quantity</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="total_quantity" name="total_quantity" value="{{  $product->quantity }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label col-md-offset-2">
                                            <label for="average_price">Average Unit Price</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="average_price" name="average_price" value="{{  number_format(round($product->price, 2), 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                            <label for="stock">In Stock</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="stock" name="stock" value="{{  $product->quantity }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label col-md-offset-2">
                                            <label for="old_price">Old Unit Price</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" id="old_price" name="old_price" value="{{  number_format(round($product->price, 2), 2) }}" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label">
                                            <label for="quantity">Add More</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('quantity') ? 'focused error' : '' }}">
                                                    <input type="number" id="quantity_more" onkeyup="totalQuantity()" onchange="totalQuantity()" class="form-control @error('quantity') is-invalid @enderror" 
                                                        name="quantity" min="0" value="{{ !empty(old('quantity')) ? old('quantity') : '' }}">                                                    
                                                </div>
                                                @error('quantity')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3 form-control-label col-md-offset-2">
                                            <label for="price">New Unit Price</label>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
                                            <div class="form-group">
                                                <div class="form-line {{ $errors->has('price') ? 'focused error' : '' }}">
                                                    <input type="number" id="new_price" onkeyup="avgPrice()" onchange="avgPrice()" class="form-control @error('price') is-invalid @enderror" 
                                                        name="price" min="0" step=".01" value="{{ !empty(old('price')) ? old('price') : '' }}" disabled>                                                    
                                                </div>
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong style="color: red">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                 
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-5 col-md-offset-5 col-sm-offset-4 col-xs-offset-4">
                                            <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.product.index') }}">BACK</a>
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

<script type="text/javascript">
    
    <!-- Preview Image -->
    var loadFile = function(event) {
        var preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.onload = function() {
            preview.style.height = '100px';
            preview.style.width = '100px';
           
        URL.revokeObjectURL(preview.src) // free memory
        }
    };

    <!-- Revice Quantity -->
    function totalQuantity(){
        var addMore = parseInt(document.getElementById('quantity_more').value);
        var stock = parseInt(document.getElementById('stock').value);
        var oldPrice = parseFloat(document.getElementById('old_price').value);

        if(addMore){
            document.getElementById('total_quantity').value = addMore + stock;
            document.getElementById('new_price').disabled = false;
        }
        else{
            document.getElementById('total_quantity').value = stock;
            document.getElementById('average_price').value = oldPrice;
            document.getElementById('new_price').value = '';
            document.getElementById('new_price').disabled = true;
        }
    };

    <!-- Revice Price -->
    function avgPrice(){
        var addMore = parseInt(document.getElementById('quantity_more').value);
        var stock = parseInt(document.getElementById('stock').value);
        var oldPrice = parseFloat(document.getElementById('old_price').value);
        var newPrice = parseFloat(document.getElementById('new_price').value);

        if(newPrice){
            document.getElementById('average_price').value = (((stock * oldPrice) + (addMore * newPrice)) / (addMore + stock)).toFixed(2);
        }
        else{
            document.getElementById('average_price').value = oldPrice;
        }
        
    };

    
</script>

@endpush