@extends('layouts.backend.app')

@section('title', 'Proprietor')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <form action="{{ route('admin.proprietor.update', $proprietor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT PROPRIETOR
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" required value="{{ !empty(old('name')) ? old('name') : $proprietor->name }}">
                                <label class="form-label">Proprietor Name</label>
                                
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('designation') ? 'focused error' : '' }}">
                                <input type="text" id="designation" class="form-control @error('designation') is-invalid @enderror" 
                                    name="designation" required value="{{ !empty(old('designation')) ? old('designation') : $proprietor->designation }}">
                                <label class="form-label">Designation</label>
                                
                            </div>
                            @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('phone') ? 'focused error' : '' }}">
                                <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" required value="{{ !empty(old('phone')) ? old('phone') : $proprietor->phone }}">
                                <label class="form-label">Phone</label>
                                
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.proprietor.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-pink">
                        <h2 class="text-center">
                            PROPRIETOR IMAGE
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" onchange="loadFile(event)">
                            
                            @if (isset($proprietor->image))
                    
                                    <img id="preview" src="{{ Storage::disk('public')->url('proprietor/'.$proprietor->image) }}"
                                    height="350px" width="270px" alt="Proprietor Image">
                                
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
            </div>
        </div>
    </form>
    <!-- Vertical Layout | With Floating Label -->
</div>
@endsection

@push('js')
<!-- Preview Image -->
    <script type="text/javascript">
        
        var loadFile = function(event) {
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function() {
                //preview.style.height = '380px';
                preview.style.height = '350px';
                preview.style.width = '270px';
               
            URL.revokeObjectURL(preview.src) // free memory
            }
        };
          
    </script>
@endpush