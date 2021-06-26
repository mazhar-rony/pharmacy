@extends('layouts.backend.app')

@section('title', 'Bank')

@push('css')
<!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        ADD NEW BRANCH
                    </h2>
                </div>
                <div class="body">
                    <form action="{{ route('admin.branch.store') }}" method="POST">
                        @csrf
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('bank') ? 'focused error' : '' }}">
                                <label for="bank">Select Bank</label>
                                <select name="bank" id="bank" data-live-search="true" 
                                    class="form-control show-tick @error('bank') is-invalid @enderror">
                                        <option value="" selected disabled>Nothing Selected</option>
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
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" 
                                    name="name" value="{{ !empty(old('name')) ? old('name') : '' }}">
                                <label class="form-label">Branch Name</label>
                               
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
                                    name="phone" value="{{ !empty(old('phone')) ? old('phone') : '' }}">
                                <label class="form-label">Contact No</label>
                               
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('city') ? 'focused error' : '' }}">
                                <input type="text" id="city" class="form-control @error('city') is-invalid @enderror" 
                                    name="city" value="{{ !empty(old('city')) ? old('city') : '' }}">
                                <label class="form-label">City</label>
                               
                            </div>
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('location') ? 'focused error' : '' }}">
                                <input type="text" id="location" class="form-control @error('location') is-invalid @enderror" 
                                    name="location" value="{{ !empty(old('location')) ? old('location') : '' }}">
                                <label class="form-label">Location</label>
                               
                            </div>
                            @error('location')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('address') ? 'focused error' : '' }}">
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                    rows="2" name="address">{{ !empty(old('address')) ? old('address') : '' }}</textarea>
                                <label class="form-label">Address</label>
                               
                            </div>
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong style="color: red">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <a type="button" class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.branch.index') }}">BACK</a>
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
<!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
@endpush