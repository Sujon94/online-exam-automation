@extends('frontend.layouts.default')
@section('header-style')
    <!-- CSS Files -->
    <link href="{{asset('frontend/assets/bootstrap/css/paper-bootstrap-wizard.css')}}" rel="stylesheet"/>
    <!-- Fonts and Icons -->
    <link href="{{asset('frontend/assets/css/themify-icons.css')}}" rel="stylesheet">

    <style>
        .wizard-container {
            padding-top: 0px;
            z-index: 3;
        }

        .wizard-card .tab-content {
            min-height: 400px;
            padding: 8px 20px 10px;
        }

        .wizard-card .icon-circle {
            /*font-size: 18px;*/
            border: 2.5px solid #82ac82;
            text-align: center;
            border-radius: 50%;
            color: rgba(0, 0, 0, 0.2);
            /*font-weight: 600;*/
            width: auto;
            height: auto;
            background-color: #FFFFFF;
            margin: 0 auto;
            position: relative;
            /*top: -2px;*/
        }

        .btn-next, .btn-finish {
            background-color: #28a745 !important;
        }

        .nav-pills > li {
            width: auto !important;
            margin: 1px;
            position: center !important;
        }

        .nav-pills {
            background-color: transparent;
            position: absolute;
            width: 100%;
            height: 0px !important;
            top: 40px;
            text-align: center;
            /*padding: .25rem!important;*/
        }
    </style>

    <style media="(min-width:992px)" rel="stylesheet">
/*        .timer-content {
            width: 72% !important;
            !*height: 50%!important;*!
        }*/

        .min-height {
            min-height: 400px;
        }
    </style>
    <style media="(max-width:768px)" rel="stylesheet">
/*        .timer-content {
            width: 56% !important;
        }*/

        .wizard-li {
            display: none;
        }
    </style>
@endsection
@section('content')
    <section class="our-course section-padding-courses">
        <div class="container">
            <div class="wizard-container">
                <div class="card wizard-card" data-color="orange" id="wizardProfile">
                    @include('backend.examination.exam-page.answer_paper')
                </div>
            </div> <!-- wizard container -->
        </div>
    </section>
    <!--
        V:1.0.0
        <section class="our-course section-padding-courses">
            <div class="container min-height">
                <div class="row">
                    <div class="col-lg-3 q-count-area"></div>
                    <div class="col-lg-6">
                        <form action="#" name="skill-test">

                            <div id="content"></div>

                            <input type="hidden" id="t" name="t" value="$examId">
                            <input type="hidden" id="i" name="i" value="$studentId}}">
                        </form>
                    </div>
                    <div class="col-lg-3 d-flex justify-content-center mt-1">
                        <div class="rounded-circle bg-danger timer-content">
                            <div class="d-flex justify-content-center text-center rounded-circle bg-light w-100 p-5 h-100">
                                <div>
                                    <span id="min" style="font-size: 30px;">00</span><span style="font-size: 30px;">:</span><span id="secnd" style="font-size: 30px;">00</span>
                                    <br>
                                    <span id="timerDiv" data-time="$duration}}" style="color: red;">Time is ticking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
@endsection
@section('footer-script')
    <script src="{{ asset('backend/assets/libs/notify.js') }}"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/paper-bootstrap-wizard.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/js/examPaperCommon.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/js/assessmentPage.js')}}" type="text/javascript"></script>
@endsection