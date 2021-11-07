@extends('layouts.master-without-nav')

@section('title'){{ __("Login") }} @endsection

@section('body')
<body>
@endsection

@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="text-center mb-4">
                    <a href="{{url('/')}}" class="auth-logo mb-5 d-block">
                        <img src="{{ URL::asset('assets/images/logo-dark.png')}}" alt="" height="30" class="logo logo-dark">
                        <img src="{{ URL::asset('/assets/images/logo-light.png')}}" alt="" height="30" class="logo logo-light">
                    </a>
                    <h4>{{ __("Sign in") }}</h4>
                    <p class="text-muted mb-4">{{ __("Sign in to continue to Chatvia.") }}</p>
                </div>

                <div class="card">
                    <div class="card-body p-4">
                        <div class="p-3">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                
                                <div class="form-group">
                                    <label>{{ __("Email") }}</label>
                                    <div class="input-group mb-3 bg-soft-light input-group-lg rounded-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-light text-muted">
                                                <i class="ri-user-2-line"></i>
                                            </span>
                                        </div>
                                        <input id="email" type="email" class="form-control bg-soft-light border-light @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'admin@themesbrand.com') }}" required autocomplete="email" autofocus placeholder="{{ __("Enter Email") }}">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-4">
                                    <div class="float-right">
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-muted font-size-13">{{ __('Forgot Password?') }}</a>
                                        @endif
                                    </div>
                                    <label>{{ __("Password") }}</label>
                                    <div class="input-group mb-3 bg-soft-light input-group-lg rounded-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-light text-muted">
                                                <i class="ri-lock-2-line"></i>
                                            </span>
                                        </div>
                                        <input id="password" type="password" class="form-control bg-soft-light border-light @error('password') is-invalid @enderror" name="password" value="password" required autocomplete="current-password" placeholder="{{ __("Enter Password") }}">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="custom-control custom-checkbox mb-4">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                                </div>

                                <div>
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">{{ __("Sign in") }}</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <p>{{ __("Don't have an account ?") }}<a href="{{url('register')}}" class="font-weight-medium text-primary"> {{ __("Signup now") }} </a> </p>
                    <p>{{ __("© 2020 Chatvia. Crafted with") }}<i class="mdi mdi-heart text-danger"></i>{{ __("by Themesbrand") }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
