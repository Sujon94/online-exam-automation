@extends('frontend.layouts.default')
@section('header-style')
@endsection
@section('content')
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Skill Test</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('skills.test-exams')}}">Skill Lists</a></li>
                            <li class="breadcrumb-item active">Take Test</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="our-course section-padding-courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h4 style="font-weight: bold; color: black">{{$exam->exam_name}}</h4>
                    <div class="d-flex justify-content-start">
                        <!-- Your share FB button code -->
                        <div class="fb-share-button" data-href="{{isset($social) ? $social->url : ''}}" data-layout="button_count"></div> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->

                        <!-- Your share Twitter button code -->
                        <div class="ml-2 mt-1">
                            <!--<a href={{"https://twitter.com/share?ref_src=twsrc%5Etfw"}} class="twitter-share-button" data-show-count="false">Tweet</a>-->
                            <!--<a href={{"https://twitter.com/intent/tweet?text=$social->title"}} class="twitter-share-button" >Tweet</a>-->
                            <!--<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>-->
                            
                             <!--<a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{ $exam->exam_name }}">Tweet</a>--> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                        </div>

                        <!-- Your share LinkedIn button code -->
                        <div class="ml-2">
                            <script type="IN/Share" data-url="{{isset($social) ? $social->url : 'http://abadhutit.com/frontend/assets/img/logo.png'}}"></script> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                        </div>
                    </div>
                    <hr>
                   {!! $exam->instruction !!}
<!--                    <span style="font-size: 16px;">Take our free online test today. With this short test we will help you evaluate your skills, from multiple choice to answering short questions.
                        This test should take around {{$exam->requiredTime ?? "20 minutes"}} to complete , and once it’s done, you’ll receive an instant score that will give you a good idea of your skill level.</span>
                -->
                </div>
                <div class="col-lg-6 text-center d-flex justify-content-center ">
                    <div>
                        @if($exam->type->payment_required_yn == \App\Enums\YesNoFlag::YES)
                            @if($exam->transaction_status == \App\Enums\LTransactionStatus::PENDING)
                                <a   href="#" class="eduspace-btn apply_now_btn mt-5">
                                    Payment Pending
                                </a>
                            @elseif(($exam->transaction_status == \App\Enums\LTransactionStatus::APPROVED) && ($exam->exam_participation_status == 0))
                                <a href="{{route('assessment.assessment-start',['exam'=>encrypt($exam->exam_id),'trans'=>encrypt($exam->transaction_id)])}}" class="btn btn-lg btn-success mt-5 text-white">Start the assessment</a>
                            @else
                                <a   href="{{ (\Illuminate\Support\Facades\Auth::id() !== null) ? route('login-user.pay-for-event', ['skill'=>encrypt($exam->exam_id)]) : url('/register') }}"
                                     id="apply_btn_b" class="eduspace-btn apply_now_btn mt-5"
                                     data-student-status="{{isset($userInfo->student_details->student_status_id) ? $userInfo->student_details->student_status_id : ''}}"
                                     data-student-trans="{{isset($paymentInfo->transaction_status_id) ? $paymentInfo->transaction_status_id : ''}}">
                                    Make Payment
                                </a>
                            @endif
                        @else
                            <a href="{{route('skills.test-start',['examId'=>encrypt($exam->exam_id)])}}" class="btn btn-lg btn-success mt-5 text-white">Start the test</a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer-script')

    {{--<script async src={{"https://platform.twitter.com/widgets.js"}} charset="utf-8"></script> Block this section Pavel-31-12-22 --}}
    <script src={{"https://platform.linkedin.com/in.js"}} type="text/javascript"></script>

@endsection
