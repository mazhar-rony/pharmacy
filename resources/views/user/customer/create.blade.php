@extends('layouts.backend.app')

@section('title', 'Customer')

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
                        ADD NEW CUSTOMER
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('user.customer.store') }}" method="POST">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ !empty(old('name')) ? old('name') : '' }}">
                                <label class="form-label">Customer Name</label>
                               
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('organization') ? 'focused error' : '' }}">
                                <input type="text" id="organization" class="form-control @error('organization') is-invalid @enderror" 
                                    name="organization" value="{{ !empty(old('organization')) ? old('organization') : '' }}">
                                <label class="form-label">Organization</label>
                               
                            </div>
                            @error('organization')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('phone') ? 'focused error' : '' }}">
                                <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ !empty(old('phone')) ? old('phone') : '' }}">
                                <label class="form-label">Phone</label>
                               
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('address') ? 'focused error' : '' }}">
                                <textarea rows="2" class="form-control no-resize @error('address') is-invalid @enderror" 
                                    name="address">{{ !empty(old('address')) ? old('address') : '' }}</textarea>
                                <label class="form-label">Address</label>
                               
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('user.customer.index') }}">BACK</a>
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