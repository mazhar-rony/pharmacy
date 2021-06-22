@extends('layouts.backend.app')

@section('title', 'Profile')

@push('css')

@endpush

@section('content')
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card profile-card">
                <div class="profile-header">&nbsp;</div>
                <div class="profile-body">
                    <div class="image-area">
                        <img src="{{ Storage::disk('public')->url('user/'.$user->image) }}" 
                            alt="Profile Image" height="200" width="200" />
                    </div>
                    <div class="content-area">
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->email }}</p>
                        <p>{{ $user->role->name }}</p>
                    </div>
                </div>
                <div class="profile-footer">
                    <ul>
                        <li>
                            <span>Phone</span>
                            <span>{{ $user->phone }}</span>
                        </li>
                        <li>
                            <span>Address</span>
                            <span>{{ $user->address }}</span>
                        </li>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div class="card">
                <div class="header" style="background-color: #ad1455">
                    <h2 class="text-center" style="color: white">
                        PROFILE SETTINGS
                    </h2>
                </div>
                <div class="body">
                    <form class="form-horizontal" action="{{ route('admin.profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name Surname</label>
                            <div class="col-sm-10">
                                <div class="form-line {{ $errors->has('name') ? 'focused error' : '' }}">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ !empty(old('name')) ? old('name') : $user->name }}" 
                                        placeholder="Name Surname">
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <div class="form-line {{ $errors->has('email') ? 'focused error' : '' }}">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ !empty(old('email')) ? old('email') : $user->email }}" 
                                        placeholder="Email Address">
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10">
                                <div class="form-line {{ $errors->has('phone') ? 'focused error' : '' }}">
                                    <input type="phone" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ !empty(old('phone')) ? old('phone') : $user->phone }}" 
                                        placeholder="Phone Number">
                                </div>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong style="color: red">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">Address</label>

                            <div class="col-sm-10">
                                <div class="form-line">
                                    <textarea class="form-control" id="address" name="address" rows="2" 
                                        placeholder="Address">{{ !empty(old('address')) ? old('address') : $user->address }}</textarea>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="image" class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-10">
                                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" onchange="loadFile(event)">
                            
                                 @if (isset($user->image))
                    
                                    <img id="preview" src="{{ Storage::disk('public')->url('user/'.$user->image) }}"
                                    height="70px" width="70px" alt="User Image">
                                
                                @else
                                
                                    <img id="preview">                                
                                    
                                @endif
                            </div>
                        </div>                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">UPDATE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                preview.style.height = '70px';
                preview.style.width = '70px';
               
            URL.revokeObjectURL(preview.src) // free memory
            }
        };
          
    </script>
@endpush