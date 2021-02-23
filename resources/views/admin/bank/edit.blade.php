@extends('layouts.backend.app')

@section('title', 'Bank')

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
                        EDIT BANK
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.bank.update', $bank->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ !empty(old('name')) ? old('name') : $bank->name }}">
                                <label class="form-label">Supplier Name</label>
                               
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('phone') ? 'focused error' : '' }}">
                                <input type="text" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                    name="phone" value="{{ !empty(old('phone')) ? old('phone') : $bank->phone }}">
                                <label class="form-label">Contact No</label>
                               
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('address') ? 'focused error' : '' }}">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror" 
                                    rows="2" name="address">{{ !empty(old('address')) ? old('address') : $bank->address }}</textarea>
                                <label class="form-label">Address</label>
                               
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.bank.index') }}">BACK</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
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