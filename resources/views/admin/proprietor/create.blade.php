@extends('layouts.backend.app')

@section('title', 'Proprietor')

@push('css')
    
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ADD NEW PROPRIETOR
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.proprietor.store') }}" method="POST">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" required value="{{ !empty(old('name')) ? old('name') : '' }}">
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
                                    name="designation" required value="{{ !empty(old('designation')) ? old('designation') : '' }}">
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
                                    name="phone" required value="{{ !empty(old('phone')) ? old('phone') : '' }}">
                                <label class="form-label">Phone</label>
                               
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.proprietor.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
</div>
@endsection

@push('js')

@endpush