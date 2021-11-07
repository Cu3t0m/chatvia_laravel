@extends('layouts.master-without-nav')

@section('title'){{ __("Reset Password") }} @endsection

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
                        <img src="{{ URL::asset('assets/images/logo-light.png')}}" alt="" height="30" class="logo logo-light">
                    </a>

                    <h4>{{ __('Confirm Password') }}</h4>
                    <p class="text-muted mb-4">{{ __('Please confirm your password before continuing.') }}</p>
                    
                </div>
            <div class="card">

                <div class="card-body p-4">
                    <div class="p-3">
                
                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group mb-4">
                            <label for="password">{{ __('Password') }}</label>
                            <div class="input-group mb-3 bg-soft-light input-group-lg rounded-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-light text-muted">
                                        <i class="ri-lock-2-line"></i>
                                    </span>
                                </div>
                                <input id="password" type="password" class="form-control bg-soft-light border-light @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ __("Enter Password") }}">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>    
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">
                                {{ __('Confirm Password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="mt-5 text-center">
            <p>{{ __("Remember It ?") }} <a href="{{url('auth-login')}}" class="font-weight-medium text-primary"> {{ __("Signin") }} </a> </p>
            <p>{{ __("© 2020 Chatvia. Crafted with") }} <i class="mdi mdi-heart text-danger"></i> {{ __("by Themesbrand") }}</p>
        </div>
    </div>
</div>
</div>
</div>

@endsection