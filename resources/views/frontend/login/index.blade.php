@extends('frontend.layouts.default')
@section('header-style')
@endsection
@section('content')
    <!--Start Eduspace banner Section-->
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>User Login</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Login</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->

    <!--Start login-form Section-->
    <section class="login-form section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content">
                        <div class="login-title text-center">
                            <h4>Login with your account</h4>
                        </div>
                        <div class="login-area">
                            <form action="{{route('login.login-user-details')}}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" id="u_email" name="u_email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="password" id="u_password" name="u_password" required>
                                </div>
                                <div class="login-button">
                                    <button type="submit" class="login-btn">Login</button>
                                </div>
                                <div class="login-info form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                    <span><a href="#">Forgot password</a> Or <a href="{{route('registration.index')}}">Register</a></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End login-form Section-->
@endsection
@section('footer-script')
<script type="text/javascript">

    $(document).ready(function () {
        //Code here
    });
</script>
@endsection