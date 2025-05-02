@extends('frontend.layouts.default')
@section('header-style')
    <style>
        .course-timeing ul li {
            padding-bottom: 0px;
        }

        .course-discription ul {
            margin-left: 0;
            padding-left: 3em;
        }

        .course-discription ul li {
            list-style: outside;
        }

        .course-details ul {
            padding-left: 43px;

        }

        .course-details ul li {
            list-style-type: disc;
        }

        .accordion > .card {
            border-color: white;
        }

        .accordion > .card:first-of-type {
            border: 1px solid #20c997;
        }

        /*.course-discription ul li:before {
            !*content: "\f00c"; !* FontAwesome Unicode *!
            font-family: FontAwesome;
            display: inline-block;
            padding-left: 1.3em;
            padding-right: 1.3em;
            margin-left: -1.3em; !* same as padding-left set on li *!
            width: 1.3em; !* same as padding-left set on li *!*!

            !*list-style-type: disc;
            list-style-position: inside;
            text-indent: -1.3em;
            padding-left: 1em;*!
        }*/
    </style>
@endsection
@section('content')
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Event</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Event</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->

    <!--Start course-details Section-->
    <section class="course-details mb-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="course-subject-header mb-1 mt-4">
                                <h1>{{ $eventInfo->exam_name }}</h1>
                                <div class="d-flex justify-content-start">
                                    <!-- Your share FB button code -->
                                    <div class="fb-share-button" data-href="{{isset($social) ? $social->url : ''}}"
                                         data-layout="button_count"></div>
                                    <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->

                                    <!-- Your share Twitter button code -->
                                    <div class="ml-2 mt-1">
                                    <!--<a href={{"https://twitter.com/share?ref_src=twsrc%5Etfw"}} class="twitter-share-button" data-show-count="false">Tweet</a>-->
                                        <!--<a href="https://twitter.com/intent/tweet?text=$social->title"}} class="twitter-share-button" >Tweet</a>-->
                                        <!--<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>-->

                                        <a class="twitter-share-button"
                                           href="https://twitter.com/intent/tweet?text={{ $eventInfo->exam_name }}">Tweet</a>
                                        <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                                    </div>

                                    <!-- Your share LinkedIn button code -->
                                    <div class="ml-2">
                                        <script type="IN/Share"
                                                data-url="{{isset($social) ? $social->url : 'http://abadhutit.com/frontend/assets/img/logo.png'}}"></script>
                                        <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card" style="border: 2px solid #20c997; border-radius: 8px">
                                <div class="card-body p-0">
                                    {{--                                            <h2 class=" pl-2">Event Details</h2>--}}
                                    <img width="100%" height="100%"
                                         src="data:{{isset($eventInfo->image_file)? $eventInfo->image_file->doc_file_type : ''}}; base64, {{isset($eventInfo->image_file)? $eventInfo->image_file->doc_file : ''}}"
                                         alt="{{isset($eventInfo->image_file->doc_img_alt_tag) ? $eventInfo->image_file->doc_img_alt_tag : $eventInfo->image_file->doc_file_name }}"/>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="course-apply">
                                @if($eventInfo->status == \App\Enums\Exam\LExamStatus::PUBLISHED)
                                    @if(isset($paymentInfo) && ($paymentInfo->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED ))
                                        <a class="eduspace-btn apply_now_btn" target="_blank"
                                           href="{{route('assessment.assessment-participate',['exam'=>encrypt($eventInfo->exam_id),'trans'=>encrypt($paymentInfo->student_transaction_id)])}}">Participate</a>
                                    @elseif(isset($paymentInfo) && ($paymentInfo->transaction_status_id == \App\Enums\LTransactionStatus::PENDING ))
                                        <a class="btn btn-lg btn-info" target="_blank"
                                           href="#">Payment not authorized yet</a>
                                    @elseif($eventInfo->price == null && (\Illuminate\Support\Facades\Auth::id() != null))
                                        <a class="eduspace-btn apply_now_btn" target="_blank"
                                           href="{{route('assessment.assessment-participate',['exam'=>encrypt($eventInfo->exam_id),'trans'=>encrypt($paymentInfo->student_transaction_id)])}}">Participate</a>
                                    @else
                                        <a href="{{ (\Illuminate\Support\Facades\Auth::id() !== null) ? route('login-user.pay-for-event', ['event'=>encrypt($eventInfo->exam_id)]) : url('/register') }}"
                                           id="apply_btn_b" class="eduspace-btn apply_now_btn"
                                           data-student-status="{{isset($userInfo->student_details->student_status_id) ? $userInfo->student_details->student_status_id : ''}}"
                                           data-student-trans="{{isset($paymentInfo) && isset($paymentInfo->transaction_status_id) ? $paymentInfo->transaction_status_id : ''}}">
                                            Make Payment
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--Start course-details Section-->
@endsection
@section('footer-script')

    {{--<script async src={{"https://platform.twitter.com/widgets.js"}} charset="utf-8"></script> Block this section Pavel-31-12-22 --}}
    <script src={{"https://platform.linkedin.com/in.js"}} type="text/javascript"></script>

@endsection