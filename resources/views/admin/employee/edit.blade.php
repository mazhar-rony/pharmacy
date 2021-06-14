@extends('layouts.backend.app')

@section('title', 'Employee')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <form action="{{ route('admin.employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row clearfix">
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIT EMPLOYEE
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ !empty(old('name')) ? old('name') : $employee->name }}" required>
                                <label class="form-label">Name</label>
                                
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
                                    name="designation" value="{{ !empty(old('designation')) ? old('designation') : $employee->designation }}" required>
                                <label class="form-label">Designation</label>
                                
                            </div>
                            @error('designation')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('address') ? 'focused error' : '' }}">
                                <input type="text" id="address" class="form-control @error('address') is-invalid @enderror" 
                                    name="address" value="{{ !empty(old('address')) ? old('address') : $employee->address }}" required>
                                <label class="form-label">Address</label>
                                
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('phone') ? 'focused error' : '' }}">
                                <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ !empty(old('phone')) ? old('phone') : $employee->phone }}" required>
                                <label class="form-label">Phone</label>
                                
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>                        
                        {{--  <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('advance') ? 'focused error' : '' }}">
                                <input type="number" id="advance" class="form-control @error('advance') is-invalid @enderror" 
                                    name="advance" min="0" step=".01" value="{{ !empty(old('advance')) ? old('advance') : round($employee->advance, 2) }}" required>
                                <label class="form-label">Advance</label>
                                
                            </div>
                            @error('advance')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>  --}}
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('salary') ? 'focused error' : '' }}">
                                <input type="number" id="salary" class="form-control @error('salary') is-invalid @enderror" 
                                    name="salary" min="0" step=".01" value="{{ !empty(old('salary')) ? old('salary') : round($employee->salary, 2) }}" required>
                                <label class="form-label">salary</label>
                                
                            </div>
                            @error('salary')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.employee.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="body">
                        <div class="form-group form-float">
                            <label class="form-label">Employee Image</label>
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" onchange="loadFile(event)">
                            
                            @if (isset($employee->image))
                    
                                    <img id="preview" src="{{ Storage::disk('public')->url('employee/'.$employee->image) }}"
                                    height="270px" width="270px" alt="Employee Image">
                                
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
<!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Preview Image -->
    <script type="text/javascript">
        
        var loadFile = function(event) {
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function() {
                //preview.style.height = '380px';
                preview.style.height = '270px';
                preview.style.width = '270px';
               
            URL.revokeObjectURL(preview.src) // free memory
            }
        };
          
    </script>
@endpush