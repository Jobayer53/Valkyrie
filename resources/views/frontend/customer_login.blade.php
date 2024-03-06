@extends('frontend.master')
@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="">
    <div class="">
        <div class="row align-items-start justify-content-between">
        
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                @if (session('login'))
                    <div class="alert alert-danger">{{ session('login') }}</div>
                    
                @endif
                @if (session('add_cart'))
                    <div class="alert alert-danger">{{ session('add_cart') }}</div>
                    
                @endif
                @if (session('add_wishlist'))
                    <div class="alert alert-danger">{{ session('add_wishlist') }}</div>
                    
                @endif
                <form class="border p-3 rounded" action="{{ route('customer.login.check') }}" method="POST">				
                    @csrf
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email"class="form-control" placeholder="Email*">
                        @error('email')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password"name="password" class="form-control" placeholder="Password*">
                        @error('password')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="#">Lost Your Password?</a>
                            </div>	
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                    <div class="new-account mt-5 text-center">
                        <p class="text-dark">Don't have an account? <a class="text-danger" href="{{ route('customer.register') }}"> Sign up</a> Here</p>
                    </div>
                </form>
               
            </div>
            
            {{-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3">
                    <h3>Register</h3>
                </div>
                <form class="border p-3 rounded">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Full Name *</label>
                            <input type="text" class="form-control" placeholder="Full Name">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" class="form-control" placeholder="Email*">
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Password *</label>
                            <input type="password" class="form-control" placeholder="Password*">
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
                    </div>
                    <div class="new-account mt-5 text-center">
                        <p class="text-dark">Already have an Account?<a class="text-dark" href="{{ route('customer.login') }}">Sign in</a> Here</p>
                    </div>
                </form>
            </div> --}}
            
        </div>
    </div>
</section>
<!-- ======================= Login End ======================== -->
@endsection