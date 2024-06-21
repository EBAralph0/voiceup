@extends('layouts.app')

@section('content')
<div class="p-4">
    <section class="vh-90">
        <div class="container-fluid h-custom">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
              <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                  <p class="lead fw-normal mb-0 me-3">Register with</p>
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-facebook-f"></i>
                  </button>
      
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-twitter"></i>
                  </button>
      
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-floating mx-1">
                    <i class="fab fa-linkedin-in"></i>
                  </button>
                </div>
      
                <div class="divider d-flex align-items-center my-4">
                  <p class="text-center fw-bold mx-3 mb-0">Or</p>
                </div>
      
                <!-- name input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <input id="name" placeholder="Enter valid name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  <label class="form-label" for="name">{{ __('Name') }}</label>
                </div>
                
      
                <!-- email input -->
                <div data-mdb-input-init class="form-outline mb-3">
                    <input id="email" type="email" placeholder="Enter valid email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  <label class="form-label" for="email">{{ __('Email Address') }}</label>
                </div>
                
                
                
                <!-- password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                    <input id="password" type="password" placeholder="Enter valid password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  <label class="form-label" for="form3Example4">{{ __('Password') }}</label>
                </div>

                <!-- pasword input -->
                <div data-mdb-input-init class="form-outline mb-3">
                    <input id="password-confirm" type="password" placeholder="Same as the previous" class="form-control" name="password_confirmation" required autocomplete="new-password">

                    <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>

                  <label class="form-label" for="form3Example4">{{ __('Password') }}</label>
                </div>
               
      
                <div class="text-center text-lg-start mt-4 pt-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                  <p class="small fw-bold mt-2 pt-1 mb-0">Have an account? <a href="#!"
                      class="link-danger">Log in</a></p>
                </div>
      
              </form>
            </div>
          </div>
        </div>
        {{-- <div
          class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
          <!-- Copyright -->
          <div class="text-white mb-3 mb-md-0">
            Copyright © 2020. All rights reserved.
          </div>
          <!-- Copyright -->
      
          <!-- Right -->
          <div>
            <a href="#!" class="text-white me-4">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#!" class="text-white me-4">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#!" class="text-white me-4">
              <i class="fab fa-google"></i>
            </a>
            <a href="#!" class="text-white">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
          <!-- Right -->
        </div> --}}
      </section>
    </div>
@endsection
