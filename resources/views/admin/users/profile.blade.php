@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h2>User Details</h2>
                </div>
                <div class="card-body">
                    <form action="{{route('profile.update')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ Auth::user()->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Current Password</label>
                            <input type="password" class="form-control" name="current_password" >

                            @if (session('current_password'))
                                <strong class="text text-danger">{{session('current_password')}}</strong>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" >


                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" >
                            @error('password')
                                <strong class="text text-danger">{{$message}}</strong>
                            @enderror
                            @if (session('confirm_password'))
                                <strong class="text text-danger">{{session('confirm_password')}}</strong>
                            @endif
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" >Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h2>Edit Profile Photo</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('photo.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Upload Photo </label>
                            <input type="file" name="image" class="form-control">
                        </div>
                        <div class="mb-3">
                           <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
