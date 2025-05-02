@extends('frontend.layouts.default')
@section('header-style')
    <style rel="stylesheet">
        .overlay-img {
            width: 100%;
            height: 200px;
            background: url("{{public_path('backend/assets/images/free.jpeg')}}");
        }

    </style>
@endsection
@section('content')
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Skill Test List</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Skill Test</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End Eduspace banner Section-->
    <!--Start our-course section -->
    <section class="our-course section-padding-courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edu-title mb-0">
                        <h2>Online Tests</h2>
                        <p>Choose your desired test.</p>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                @if (count ($exams) > 0)
                    @foreach($exams as $key=>$value )
                        <a class="col-lg-3 col-md-6 col-sm-12"  href="{{route('skills.test-participate',['e'=>encrypt($value->exam_id)])}}">
                            <div class="course-area shadow-sm p-3 mb-5 bg-body rounded">
                                <div class="course-img">
                                    <img src="{{($value->image_file == null) ? asset("frontend/assets/exam/img_".++$key.".jpg") : __("data:".$value->image_file->doc_file_type."; base64,". $value->image_file->doc_file)}}"
                                         alt=""
                                         width="200px" height="200px"
                                         class="img-fluid"/>
                                </div>
                                <div class="content-area p-1">
                                    <div class="course-content">
                                        <div class="course-meta">
                                            <div class="text-break">
                                                <h6 class="">{{$value->exam_name}}</h6>
                                                <h6>
                                                    <b>
                                                        @if(isset($value->price))
                                                            <span class="btn btn-sm btn-outline-success badge rounded-pill font-weight-bolder">{{$value->price}} TK</span>
                                                        @else
                                                            <span class="btn btn-sm btn-outline-success badge rounded-pill font-weight-bolder">{{__('Free')}} </span>
                                                        @endif
                                                    </b>
                                                </h6>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="alert alert-success col-md-12 text-center" role="alert">
                        <h4 class="alert-heading">Currently Skill tests are not available!</h4>
                        <hr>
                        <p>The tests will be available after publish.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
@section('footer-script')
@endsection