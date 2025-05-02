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
    {{--<section class="cus-bg-color">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <ol class="breadcrumb" style="margin-top: 1rem!important; font-size: 1vw">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Course</a></li>
                            <li class="breadcrumb-item text-white">{{$courseDetails->course_name_en}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}  
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Course Details</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('course.index')}}">Course</a></li>
                            <li class="breadcrumb-item"><a href="{{route('course.list',['id'=>$courseDetails->course_type_id ])}}">{{$courseDetails->course_type->type_name_en}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$courseDetails->course_name_en}}</li>
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
                                <h1>{{ $courseDetails->course_name_en.' ('.$courseDetails->course_code.' )' }}</h1>
                                <div class="d-flex justify-content-start">
                                    <!-- Your share FB button code -->
                                    <div class="fb-share-button" data-href="{{isset($social) ? $social->url : ''}}" data-layout="button_count"></div> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->

                                    <!-- Your share LinkedIn button code -->
                                    <div class="ml-2">
                                        <script type="IN/Share" data-url="{{isset($social) ? $social->url : 'http://abadhutit.com/frontend/assets/img/logo.png'}}"></script> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                                    </div>
                                    
                                    <!-- Your share Twitter button code -->
                                    <div class="ml-2 mt-1">
                                        <!--<a href={{"https://twitter.com/share?ref_src=twsrc%5Etfw"}} class="twitter-share-button" data-show-count="false">Tweet</a>-->
                                        <!--<a href={{"https://twitter.com/intent/tweet?text=$social->title"}} class="twitter-share-button" >Tweet</a>-->
                                        <!--<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>-->
                                        
                                        <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{ $courseDetails->course_name_en.' ('.$courseDetails->course_code.' )' }}">Tweet</a> <!-- Block this section Pavel-31-12-22 / Open-13-05-23 -->
                                    </div>
                                </div>
                            </div>
                            <div class="course-subject-details mb-4">
                                <p style="line-height: 25px;">{!! html_entity_decode($courseDetails->course_summary_en) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card" style="border: 2px solid #20c997; border-radius: 8px">
                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h2 class=" pl-2">Course Details</h2>
                                            <ul>
                                                <li>Batch No : {{$courseDetails->course_by_batch->batch_code}}</li>
                                                <li>
                                                    @if ($courseDetails->course_by_batch->batch_type == \App\Enums\LBatchType::LONG_TERM)
                                                        No Of Month :  {{$courseDetails->course_by_batch->total_batch_schedules }}
                                                    @else
                                                        No Of Sessions : {{count($courseDetails->course_by_batch->batch_schedule)}}
                                                    @endif
                                                </li>
                                                <li>Start Date :
                                                    @if ($courseDetails->course_by_batch->batch_status == \App\Enums\BatchStatus::DATE_PUBLISHED)
                                                        {{date('d-m-Y', strtotime($courseDetails->course_by_batch->batch_start_date))}}
                                                    @else
                                                        <small class="badge badge-pill badge-info font-size-unset">Upcoming </small>
                                                    @endif
                                                </li>
                                                <li>Course Medium : {{$courseDetails->course_medium}}</li>
                                                <li>Class Duration : {{ isset($courseDetails->course_by_batch->class_duration) ? $courseDetails->course_by_batch->class_duration : '' }}</li>
                                                <li>Class Schedule : {{ isset($courseDetails->course_by_batch->class_schedule) ? $courseDetails->course_by_batch->class_schedule : '' }}</li>
                                                <li>Class Size : {{$courseDetails->course_by_batch->max_participant}} Seats</li>
                                                <li>Payment Deadline : {{ isset ($courseDetails->course_by_batch->payment_deadline) ? date('d-m-Y', strtotime($courseDetails->course_by_batch->payment_deadline)) : 'N/A'}}</li>
                                                <li class="mb-2">Completed Courses :
                                                    <small class="badge badge-pill badge-info font-size-unset">{{isset ($totalCourseWiseStudent->student_transaction_id) ? count($totalCourseWiseStudent->student_transaction_id) : $courseDetails->course_by_batch->total_participants }}
                                                        Persons
                                                    </small>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-5 text-center">
                                            <div class="cus-bg-color rounded-right h-100">
                                                <ul class="text-white pt-5 pl-0">
                                                    <li class="h4">
                                                        Price : <span class="font-weight-bold">TK {{$courseDetails->course_by_batch->fee_amount}}</span>
                                                    </li>
                                                    <li class="mt-1 mb-1">(Including VAT & TAX)</li>
                                                    <li><a href="{{route('login-user.login-user-course-pay', [$courseDetails->course_id])}}" id="apply_btn_a" class="btn btn-primary apply_now_btn rounded-bottom"
                                                           data-student-status="{{isset($userInfo->student_details->student_status_id) ? $userInfo->student_details->student_status_id : ''}}"
                                                           data-student-trans="{{isset($stuTransInfo->transaction_status_id) ? $stuTransInfo->transaction_status_id : ''}}">
                                                            Apply Now
                                                        </a>
                                                    </li>
                                                    <li class="mt-4 mb-4">Call Now : <span class="font-weight-bold"> +880 1727-546514</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12 rounded">
                                    {{--<img src="{{asset('/frontend/assets/img/eduspace-starts-bg.jpg')}}" class="img-fluid" alt="">--}}
                                    <img src="data:{{isset($courseDetails->course_by_batch->batch_file->doc_file_type)}}; base64, {{isset($courseDetails->course_by_batch->batch_file->doc_file)? $courseDetails->course_by_batch->batch_file->doc_file : ''}}" alt="{{isset($courseDetails->course_by_batch->batch_file->doc_img_alt_tag) ? $courseDetails->course_by_batch->batch_file->doc_img_alt_tag : $courseDetails->course_by_batch->batch_file->doc_file_name }}" class="img-fluid"/>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h2 class="">Course Outline</h2>
                                    <div class="course-discription mt-0 mb-0">
                                        <div id="courseOutline" class="collapse course-outline-load" aria-labelledby="outline" data-parent="#courseOutline">
                                            <p>{!! html_entity_decode($courseDetails->course_outline_en) !!}</p>
                                        </div>
                                        {{--<div class="d-flex justify-content-start">--}}
                                        {{--<p class="course-outline-read">{{ strip_tags(  implode(' ', array_slice(explode(' ', $courseDetails->course_outline_en), 0, 20))   ) }}....</p>--}} <!----Block this tag pavel:18-03-23 --->
                                        <div class="course-outline-read">{!! html_entity_decode(substr($courseDetails->course_outline_en, 0, 320)) !!}....</div>
                                        <a href="#" class="collapsed text-success font-weight-bold course-outline"
                                           data-toggle="collapse" data-target="#courseOutline" aria-expanded="false" aria-controls="courseOutline" >
                                            Read More
                                        </a>
                                        {{--</div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h2 class="">About {{$courseDetails->course_name_en}}</h2>
                                    {!! html_entity_decode($courseDetails->course_desc_en) !!}
                                </div>
                            </div>
                            @if(isset($courseDetails->course_file->certificate_name))
                                <div class="row mt-3">
                                    <div class="col-md-12 rounded">
                                        <h2>Certificate</h2>
                                        <img src="data:{{isset($courseDetails->course_file->certificate_type)}}; base64, {{isset($courseDetails->course_file->certificate_file)? $courseDetails->course_file->certificate_file : ''}}"
                                             alt="{{ isset($courseDetails->course_file->cert_img_alt_tag) ? $courseDetails->course_file->cert_img_alt_tag : $courseDetails->course_file->certificate_name  }}"
                                             class="img-fluid"/>
                                    </div>
                                </div>
                            @endif
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <h2 class="">FAQ</h2>
                                    <div class="accordion" style="border-radius: 9px" id="courseFaq">
                                        <div class="card">
                                            <div class="card-header" id="faq">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed text-white" type="button"
                                                            data-toggle="collapse" data-target="#collapseFaq"
                                                            aria-expanded="false" aria-controls="collapseFaq">
                                                        <i class="fa fa-plus mr-1"></i>Click to see frequently asked
                                                        questions
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseFaq" class="collapse" aria-labelledby="faq"
                                                 data-parent="#courseFaq">
                                                <div class="card-body">
                                                    <p>{!! html_entity_decode($courseDetails->course_faq) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-2" style="border: 3px solid #20c997; border-radius: 8px">
                                        <h2>Meet The Instructor</h2>
                                        <div class="text-center">
                                            <img src="{{asset('frontend/assets/img/footer-blog-img-2.jpg')}}" class="rounded" alt="...">
                                            <h6 class="font-weight-bold">abadhut-it</h6>
                                            <h6>Consultant</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="p-2" style="border: 3px solid #20c997; border-radius: 8px">
                                        <h2>What you'll learn</h2>
                                        @if(!empty($courseTopic))
                                            <ul>
                                                @foreach($courseTopic as $topic)
                                                    @if($topic != "")
                                                        <li>{{$topic}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="p-2" style="border: 3px solid #20c997; border-radius: 8px">
                                        <h2>Course Materials</h2>
                                        @if(!empty($courseMaterial))
                                            <ul>
                                                @foreach($courseMaterial as $material)
                                                    @if($material != "")
                                                        <li>{{$material}}</li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <div class="p-2" style="border: 3px solid #20c997; border-radius: 8px">
                                        <h2 class="mb-2 mt-0">Participant Qualification</h2>
                                        <p>{!! html_entity_decode($courseDetails->participant_qualification_en) !!}</p>
                                        <a href="{{route('login-user.login-user-course-pay', [$courseDetails->course_id])}}" id="apply_btn_a" class="mt-2 btn btn-primary apply_now_btn rounded-bottom "
                                           data-student-status="{{isset($userInfo->student_details->student_status_id) ? $userInfo->student_details->student_status_id : ''}}"
                                           data-student-trans="{{isset($stuTransInfo->transaction_status_id) ? $stuTransInfo->transaction_status_id : ''}}">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="p-2" style="border: 3px solid #20c997; border-radius: 8px">
                                        <h4 class="mb-3">Stay Connected</h4>
                                        <div class="d-flex justify-content-start">
                                            <!-- Your share FB button code -->
                                            <div class="fb-share-button" data-href="{{isset($social) ? $social->url : ''}}" data-layout="button_count"></div>
                                            <!-- Your share Twitter button code -->
                                            <div class="ml-2 mt-1">
                                                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{ $courseDetails->course_name_en.' ('.$courseDetails->course_code.' )' }}">Tweet</a>
                                            </div>
                                            <!-- Your share LinkedIn button code -->
                                            <div class="ml-2">
                                                <script type="IN/Share" data-url="{{isset($social) ? $social->url : 'http://abadhutit.com/frontend/assets/img/logo.png'}}"></script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        {{--<div class="col-md-12 mt-3 mb-1">
                            <h2 class="">Stay Connected</h2>
                            <div class="d-flex justify-content-start">
                                <!-- Your share FB button code -->
                                <div class="fb-share-button" data-href="{{isset($social) ? $social->url : ''}}" data-layout="button_count"></div>
                                <!-- Your share Twitter button code -->
                                <div class="ml-2 mt-1">
                                    <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text={{ $courseDetails->course_name_en.' ('.$courseDetails->course_code.' )' }}">Tweet</a>
                                </div>
                                <!-- Your share LinkedIn button code -->
                                <div class="ml-2">
                                    <script type="IN/Share" data-url="{{isset($social) ? $social->url : 'http://abadhutit.com/frontend/assets/img/logo.png'}}"></script>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="course-apply">
                                <a href="{{route('login-user.login-user-course-pay', [$courseDetails->course_id])}}"
                                   id="apply_btn_b" class="eduspace-btn apply_now_btn"
                                   data-student-status="{{isset($userInfo->student_details->student_status_id) ? $userInfo->student_details->student_status_id : ''}}"
                                   data-student-trans="{{isset($stuTransInfo->transaction_status_id) ? $stuTransInfo->transaction_status_id : ''}}">
                                    Apply Now
                                </a>
                            </div>
                        </div>
                    </div>
                    @if (count ($relatedCourses) > 0)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h3>Related Courses</h3>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($relatedCourses as $value )
                                @if (!empty ($value->course_by_batch->batch_id) && !empty ($value->course_file) )
                                    <div class="col-lg-4 col-md-3 col-sm-6">
                                        <div class="course-area ">
                                            <div class="course-img">
                                                <img src="data:{{$value->course_file->doc_file_type}}; base64, {{$value->course_file->doc_file}}" alt="{{$value->course_file->doc_img_alt_tag ? $value->course_file->doc_img_alt_tag : $value->course_file->doc_file_name }}" class="img-fluid"/>
                                                <div class="c-overlay">
                                                    <div class="link">
                                                        <a href="{{route('course.detail',['slug'=>$value->slug])}}"><i  class="fa fa-link"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content-area">
                                                <div class="course-content">
                                                    <h3>
                                                        <a style="font-size: 20px;" href="{{route('course.detail',['slug'=>$value->slug])}}">{{ $value->course_name_en.' ('.$value->course_code.' )' }}</a>
                                                    </h3>
                                                    {{--<p>{!! html_entity_decode($value->course_summary_en) !!}</p>--}}
                                                    <div class="course-meta">
                                                        <div class="d-flex justify-content-between">
                                                            <span style="font-size: 20px;">TK: {{$value->course_by_batch->fee_amount}}</span>
                                                            <span><a href="{{route('course.detail',['slug'=>$value->slug])}}"
                                                                     class="course-btn">Detail</a></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--Start course-details Section-->
@endsection
@section('footer-script')

    <script async src={{"https://platform.twitter.com/widgets.js"}} charset="utf-8"></script> {{-- Block this section Pavel-31-12-22 / Open-13-05-23 --}}
    <script src={{"https://platform.linkedin.com/in.js"}} type="text/javascript"></script>


    <script type="text/javascript">

        function courseOutlineReadMore () {
            $(".course-outline").on("click", function() {
                let courseOutlineVal = $(this).text().trim();
                if (courseOutlineVal == "Read More" ) {
                    $('.course-outline-read').addClass('d-none');
                    $(".course-outline").text("Read Less");
                } else {
                    $('.course-outline-read').removeClass('d-none');
                    $(".course-outline").text("Read More");
                }
            });
        }

        function checkApply() {
            $(".apply_now_btn").on("click", function (e) {
                e.preventDefault();

                let action_url = this;
                let student_status_id = $(this).data('student-status');
                let student_trans = ($(this).data('student-trans'));

                if (student_status_id == '0') {
                    swal.fire({
                        title: 'Sorry...',
                        text: 'Your profile is not updated please update your profile.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Update it!'
                    }).then(function (isConfirm) {
                        //console.log(isConfirm);
                        if (isConfirm.value == true) {
                            //form.submit();
                            let url = '{{ route('login-user.login-user-profile') }}';
                            window.location.href = url;
                        } else if (isConfirm.dismiss == "cancel") {
                            //return false;
                            e.preventDefault();
                        }
                    })
                } else if ((student_trans == '{{\App\Enums\LTransactionStatus::PENDING}}') || (student_trans == '{{\App\Enums\LTransactionStatus::APPROVED}}')) {
                    swal.fire({
                        title: 'Sorry...',
                        text: 'Your are already payment this course.',
                        icon: 'warning',
                    });
                } else {
                    window.location.href = action_url;
                }
            });
        }


        $(document).ready(function () {
            checkApply();
            courseOutlineReadMore();
        });
    </script>
@endsection