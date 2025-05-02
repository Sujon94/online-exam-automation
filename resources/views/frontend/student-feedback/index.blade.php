@extends('frontend.layouts.default')
@section('header-style')
    <style>
        .single-comment:nth-child(2n+1) {
            padding-left: 100px;
        }
        .single-comment {
            border-bottom: 2px solid #1259e8;
            overflow: hidden;
            padding: 20px 0px;
        }
    </style>
@endsection
@section('content')
    <!--Start Eduspace banner Section-->
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>FeedBack Details</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Students Feedback</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->


    <!--Start single-blog-page Section-->
    <section class="single-blog-page section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edu-title text-center">
                        <h2>{{$title1}}</h2>
                    </div>
                    <div class="comment-area">
                        <h4>{{$title2}}</h4>
                        @foreach($comments as $value)
                            <div class="single-comment">
                                <div class="comment-img">
                                    @php
                                        $base64Image = $value->doc_file; // Replace with your actual column name
                                    @endphp
                                    <img src="data:image/png;base64,{{ $base64Image }}" alt="">
                                </div>
                                <div class="comment-details">
                                    {!! html_entity_decode($value->content) !!}
                                    <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                    class="fa fa-arrow-circle-down"></i></span></p>
                                    <iframe src="{{ $value->link }}"
                                            width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                            frameborder="0" allowfullscreen="true"
                                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                                </div>
                            </div>
                        @endforeach
                        {{--<div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-1.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Mosharraf Hossain Tutul</strong></h4></li>
                                    --}}{{--<li>(30 minute Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Position: </span>Sr. Officer - Costing & Inventory
                                </p>
                                <p><span class="font-weight-bold">Organization: </span>Paolo Footwear (BD) Ltd. KEPZ,
                                    Chittagong.</p>
                                <p><span class="font-weight-bold">Comment: </span>They are very keen to teach and try to
                                    deliver their best. I wish them success.</p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Ftutul.mosharraf%2Fposts%2F4107231075965530&show_text=true&width=500"
                                        width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-2.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Sarowar Alam</strong></h4></li>
                                    --}}{{--<li>(5 Hours Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Position: </span>Executive </p>
                                <p><span class="font-weight-bold">Organization: </span>IBCS-PRiMAX Software (Bangladesh)
                                    Ltd.</p>
                                <p><span class="font-weight-bold">Comment: </span>Each and every course is exceptional
                                    like something different from others. It is very practical and result oriented that
                                    certainly being helpful for an income tax advisor or practitioner. Thanks to Razon
                                    Sir & N.K Paul Sir for arranging such kind of courses. I have strong recommendation
                                    you for continuing this activities. Thanks</p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2FSarowar25%2Fposts%2F1939291906228327&show_text=true&width=500"
                                        width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-3.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Mohammed Liakat</strong></h4></li>
                                    --}}{{--<li>(5 Hours Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Position: </span>Account's officer </p>
                                <p><span class="font-weight-bold">Organization: </span>Accounts Officer, Municipality.
                                </p>
                                <p><span class="font-weight-bold">Comment: </span>রাজন স্যার আয়কর অধ্যাদেশের বিভিন্ন
                                    ধারার জটিল/দূবোধ্য ভাষাগুলো সহজ ও সাবলীল ভাবে বুঝিয়ে দেন। সর্বোপরি তিনি একজন অতি
                                    আন্তরিক ব্যক্তিত্ব।</p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmohammed.liakat.94%2Fposts%2F1204692966700305&show_text=true&width=500"
                                        width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-4.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Alton Acharjee</strong></h4></li>
                                    --}}{{--<li>(5 Hours Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Position: </span>SkillAid Ambassador </p>
                                <p><span class="font-weight-bold">Organization: </span>SkillAid Bangladesh</p>
                                <p><span class="font-weight-bold">Comment: </span>আমি এখানে accounting session করেছিলাম।
                                    অনেক ভালো ছিল। খুঁটিনাটি কিছু দ্বিধা ছিলো, যা সহজেই সমাধান করতে পেরেছিলাম। ধন্যবাদ
                                    রাজন স্যার এবং পাল স্যার।</p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Falton.acharjee%2Fposts%2F4509445315749927&show_text=true&width=500"
                                        width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-5.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Mazbah Uddin</strong></h4></li>
                                    --}}{{--<li>(5 Hours Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Position: </span>Managet Air Freight </p>
                                <p><span class="font-weight-bold">Organization: </span>DSV Air & Sea Ltd.</p>
                                <p><span class="font-weight-bold">Comment: </span>Thanks for the training session. Hope
                                    this 04 days session will help all of us to our practical life. I think, if the
                                    class session set:- 1st day theoritical, 2nd & 3rd day practical class & last day
                                    open discussion session, then this schedule could be more effective & helpful to us.
                                </p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmazbah.uddin.18%2Fposts%2F3460234060679546&show_text=true&width=500"
                                        width="100%" height="230" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>
                        <div class="single-comment">
                            <div class="comment-img">
                                <img src="{{asset('/frontend/assets/img/feedback-student-6.jpg')}}" alt="">
                            </div>
                            <div class="comment-details">
                                <ul>
                                    <li><h4><strong>Fouzia Bindu</strong></h4></li>
                                    --}}{{--<li>(5 Hours Ago)</li>--}}{{--
                                </ul>
                                <p><span class="font-weight-bold">Comment: </span>কর্পোরেট ট্যাক্স বিষয়ক প্রোগ্রামটিতে
                                    অংশগ্রহণ করলাম। খুবই সুন্দর একটি ট্রেনিং প্রোগ্রাম। আর খুবই ফলপ্রসূ। বাস্তব ভিত্তিক
                                    আর সাবলীল উপস্থাপনা প্রোগ্রামটি কে অনেক বেশি গ্রহণযোগ্য করে তুলেছে। রাজন স্যার এবং
                                    পাল স্যার এর আন্তরিকতায় মুগ্ধ।প্রতিটি প্রশ্ন এবং সমস্যার উত্তর আন্তরিকভাবে দেয়ার
                                    প্রচেষ্টা ছিল তাদের মধ্যে।আর ভবিষ্যতেও যেকোন সমস্যায় যেকোনো ধরনের সাহায্য করার
                                    আশ্বাস দিয়েছেন।</p>
                                <p class="mb-2"><span class="font-weight-bold">FB Comment Link: <i
                                                class="fa fa-arrow-circle-down"></i></span></p>
                                <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Ffouzia.bhuiyan.92%2Fposts%2F246706007156338&show_text=true&width=500"
                                        width="100%" height="200" style="border:none;overflow:hidden" scrolling="no"
                                        frameborder="0" allowfullscreen="true"
                                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                            </div>
                            --}}{{--<div class="reply-button">
                                <a href="#">replay</a>
                            </div>--}}{{--
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End single-blog-page Section-->

    <!-- Start teachers section -->
    {{--<section class="teachers section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edu-title text-center">
                        <h2>Feedback From Students</h2>
                        --}}{{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, placeat saepe quasi magnam totam exercitationem.</p>--}}{{--
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
        </div>
    </section>--}}
    <!-- End teachers section -->

@endsection
@section('footer-script')
    <script type="text/javascript">

        $(document).ready(function () {
            //Code here
        });
    </script>
@endsection