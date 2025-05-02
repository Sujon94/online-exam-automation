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
        .timer-content {
            width: 72% !important;
            /*height: 50%!important;*/
        }

        .min-height {
            min-height: 400px;
        }
    </style>
    <style media="(max-width:768px)" rel="stylesheet">
        .timer-content {
            width: 56% !important;
        }

        .wizard-li {
            display: none;
        }
    </style>
@endsection
@section('content')
    <section class="our-course section-padding-courses">
        <div class="container" id="content">
            <div class="wizard-container">

                <div class="card wizard-card" data-color="orange" id="wizardProfile"  style="background-color: rgba(234,239,238,0.66);">
                    @include('backend.examination.exam-page.answer_paper')
                </div>
            </div> <!-- wizard container -->
        </div>
    </section>
@endsection
@section('footer-script')
    <script src="{{ asset('backend/assets/libs/notify.js') }}"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/jquery.bootstrap.wizard.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/paper-bootstrap-wizard.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/bootstrap/js/jquery.validate.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/js/examPaperCommon.js')}}" type="text/javascript"></script>
    <script src="{{asset('frontend/assets/js/skillPage.js')}}" type="text/javascript"></script>
@endsection