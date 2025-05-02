@extends('layouts.app')
@section('page-title')
Login
@endsection
@section('header-css')
@endsection
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden shadow-lg">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome</h5>
                                        <p>Sign in to continue.</p>
                                    </div>
                                </div>
                                <div class="col-6 align-self-center">
                                    <img src="{{asset('/frontend/assets/img/logo.png')}}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{route('/home')}}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('')}}" alt="" class="rounded-circle"
                                                     height="34">
                                            </span>
                                    </div>
                                </a>

                                <a href="{{route('/home')}}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{asset('backend/assets/images/logo.svg')}}" alt="" class="rounded-circle"
                                                     height="34">
                                            </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input id="password" type="password" aria-label="Password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   name="password" required autocomplete="current-password"
                                                   aria-describedby="password-addon">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                        class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <div class="row">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button class="btn btn-outline-primary waves-effect waves-light" type="submit"><i class="fa fa-key"></i>
                                                    {{ __('Login') }}
                                                </button>
                                                <div class="p-1"></div>
                                                <a href="{{ route('/home') }}" class="btn btn-outline-dark waves-effect waves-light">
                                                    {{ __('Continue to website') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 d-grid">

                                    </div>

                                    <div class="mt-2 text-center">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link text-muted" href="{{ route('password.request') }}">
                                                <i class="mdi mdi-lock me-1"></i>{{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                        <p>Don't have an account ? <a href="{{route('register')}}" class="fw-medium text-primary"> Signup now </a> </p> </div>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
