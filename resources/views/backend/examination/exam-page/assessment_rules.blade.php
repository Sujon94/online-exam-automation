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
                        <h2>Assessment Instructions</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">User Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('skills.test-exams')}}"></a></li>
                            <li class="breadcrumb-item active">Instructions</li>
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
                    {!! $exam->instruction !!}
<!--                    <span style="font-size: 16px;">With this assessment we will help you evaluate your skills, from multiple choice to answering short questions.
                        This assessment should take {{$exam->requiredTime ?? "20 minutes"}} to complete , and once it’s done, you’ll be redirected to the result page where will get an idea of your skill level.</span>-->
                </div>
                <div class="col-lg-6 text-center ">
                    <div>
                        <a href="{{route('assessment.assessment-start',['exam'=>encrypt($exam->exam_id),'trans'=>$trans])}}" class="btn btn-lg btn-success mt-5 text-white">Start the assessment</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
