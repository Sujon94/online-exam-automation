@extends('frontend.layouts.default')
@section('header-style')
    <style media="(min-width:992px)" rel="stylesheet">
        .timer-content{
            width: 59%!important;
            height: 50%!important;
        }
    </style>
    <style media="(min-width:768px)" rel="stylesheet">
        .timer-content{
            width: 59%!important;
        }
    </style>
@endsection
@section('content')
    <section class="our-course section-padding-courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <form action="#" name="skill-test">

                        <div id="content"></div>

                        <input type="hidden" id="t" name="t" value="{{$examId}}">
                        <input type="hidden" id="i" name="i" value="{{$clientIp}}">
                    </form>
                </div>
                <div class="col-lg-3 d-flex justify-content-center mt-1">
                    <div class="rounded-circle bg-danger timer-content">
                        <div class="d-flex justify-content-center text-center rounded-circle bg-light w-100 p-5 h-100">
                            <div>
                                <span id="min" style="font-size: 30px;">00</span><span style="font-size: 30px;">:</span><span id="secnd" style="font-size: 30px;">00</span>
                                <br>
                                <span id="timerDiv" data-time="{{$duration}}" style="color: red;">Time is ticking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer-script')
    <script src="{{ asset('backend/assets/libs/notify.js') }}"></script>
    <script type="text/javascript" src="{{asset('frontend/assets/js/skillTestPage.js')}}"></script>
@endsection