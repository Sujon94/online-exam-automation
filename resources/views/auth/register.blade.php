@extends('layouts.app')
@section('page-title')
    Sign up
@endsection
@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Sign up</h5>
                                        <p>Get your free abadhutit account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-center">
                                    <img src="{{asset('/frontend/assets/img/logo.png')}}" alt=""  class="img-fluid">

                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="p-2">
                                <form method="POST" class="needs-validation" novalidate action="{{route('register')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">{{ __('Full Name') }}</label>
                                        <input value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="Enter name"
                                               required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="userprofession" class="form-label">{{ __('Profession') }}</label>
                                        <select class="form-control @error('profession') is-invalid @enderror" id="userprofession" required name="profession">
                                            <option value="">Your Profession</option>
                                            @foreach(\App\Entities\backend\lookup\LProfessionType::all() as $p)
                                                <option value="{{$p->profession_type_id}}" {{ (old('profession') == $p->profession_type_id) ? 'selected' : '' }}>{{$p->type_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('profession')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="usermobile" class="form-label">{{ __('Mobile') }}</label>
                                        <input value="{{old('mobile')}}" type="tel" class="form-control @error('mobile') is-invalid @enderror" id="usermobile" name="mobile"
                                               placeholder="Enter your mobile" required>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">{{ __('Email (Uses Login / User Name)') }}</label>
                                        <input value="{{old('email')}}" type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="useremail" placeholder="Enter email"
                                               required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password"
                                               class="form-label">{{ __('Password') }}</label>

                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password-confirm"
                                               class="form-label">{{ __('Confirm Password') }}</label>

                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required
                                               autocomplete="new-password">
                                    </div>

                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">
                                            Sign up
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>Already have an account ? <a href="{{route('login')}}" class="fw-medium text-primary">
                                    Login</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{--<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endsection
@section('footer-script')
    <!-- validation init -->
    <script src="{{asset('backend/assets/js/pages/validation.init.js')}}"></script>
@endsection