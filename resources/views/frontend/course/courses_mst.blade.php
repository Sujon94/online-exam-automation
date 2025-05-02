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
                        <h2>All Course List</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Courses</li>
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
                        <h2>All Courses</h2>
                        {{--<p>Type Wise Courses List.</p>--}}
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                @if (count ($courseInfo) > 0)
                    @foreach($courseInfo as $value )
                        @if (!empty ($value->course_by_batch->batch_id) && !empty ($value->course_file) )
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="course-area">
                                    <div class="course-img">
                                        <img src="data:{{$value->course_file->doc_file_type}}; base64, {{$value->course_file->doc_file}}" alt="{{$value->course_file->doc_file_name}}" class="img-fluid"/>
                                        <div class="c-overlay">
                                            <div class="link">
                                                <a href="{{route('course.detail',['slug'=>$value->slug])}}"><i class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-area">
                                        <div class="course-content mb-0">
                                            {{--<h3><a href="#">Mobile Apps</a></h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                            <a href="#" class="course-btn">join now</a>--}}
                                            <h5><a class="text-success font-weight-bold" href="{{route('course.detail',['slug'=>$value->slug])}}">{{ $value->course_name_en.' ('.$value->course_code.' )' }}</a></h5>
                                            {{--<p>{!! html_entity_decode($value->course_summary_en) !!}</p>--}}
                                            <span><a href="{{route('course.list',['id'=>$value->course_type_id])}}" class="badge badge-pill badge-secondary"><i class="fa fa-link"></i>  {{$value->course_type->type_name_en }}</a></span>
                                            <div class="course-meta border-top-0 mb-2">
                                                <div class="course-left">
                                                    <span><i class="fa fa-users"></i>{{$value->course_by_batch->max_participant }} seats</span>
                                                    @if ($value->course_by_batch->batch_type == \App\Enums\LBatchType::LONG_TERM)
                                                        <span><i class="fa fa-clock-o"></i> {{$value->course_by_batch->total_batch_schedules }} Month</span>
                                                    @else
                                                        <span><i class="fa fa-clock-o"></i> {{isset($value->course_by_batch->batch_schedule) ? count($value->course_by_batch->batch_schedule) : '' }} Days</span>
                                                    @endif
                                                </div>
                                                <span class="price">{{$value->course_by_batch->fee_amount }} Tk</span>
                                            </div>
                                            <div class="course-meta">
                                                <div class="d-flex justify-content-center">
                                                    <span class="pr-2"><a href="{{route('user-home')}}" class="course-btn">join now</a></span>
                                                    <span><a href="{{route('course.detail',['slug'=>$value->slug])}}" class="course-btn">Detail</a></span>
                                                </div>
                                            </div>
                                        </div>
                                        {{--<div class="course-meta">
                                            <div class="course-left">
                                                <span><a href="{{route('user-home')}}" class="course-btn">join now</a></span>
                                                <span><a href="{{route('course.detail',['slug'=>$value->slug])}}" class="course-btn">Detail</a></span>
                                            </div>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            {{--<div class="col-md-3 col-sm-12">
                                <div class="course-area">
                                    <div class="course-img">
                                        --}}{{--<img src="{{asset('/frontend/assets/img/course2.jpg')}}" class="img-fluid" alt="">--}}{{--
                                        <img src="data:{{$value->course_file->doc_file_type}}; base64, {{$value->course_file->doc_file}}"
                                             alt="{{$value->course_file->doc_file_name}}" class="img-fluid"/>
                                        <div class="c-overlay">
                                            <div class="link">
                                                <a href="{{route('course.detail',['id'=>$value->course_id])}}"><i class="fa fa-link"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-area pb-0">
                                        <div class="course-content">
                                            <h6><b>
                                                    <a style="color:#20B876;" href="{{route('course.detail',['id'=>$value->course_id])}}">{{ $value->course_name_en.' ('.$value->course_code.' )' }}</a>
                                                </b>
                                            </h6>
                                            --}}{{--<p>{!! html_entity_decode($value->course_summary_en) !!}</p>--}}{{--
                                            <div class="course-meta">
                                                <div class="d-flex justify-content-between">
                                                    <span><a href="{{route('user-home')}}" class="course-btn">join now</a></span>
                                                    <span><a href="{{route('course.detail',['id'=>$value->course_id])}}" class="course-btn">Detail</a></span>
                                                </div>
                                            </div>
                                            <div class="course-meta d-flex justify-content-between">
                                            <span style="font-size: 1rem;font-weight:bold;color:#20B876;">
                                                <i class="fa fa-users"></i>&nbsp;{{$value->course_by_batch->max_participant }} seats
                                            </span>
                                                --}}{{--<span><i class="fa fa-clock-o"></i>{{ round(abs(strtotime($value->course_by_batch->batch_start_date) - strtotime($value->course_by_batch->batch_end_date))/86400) }} Days</span>--}}{{--
                                                {!! isset($value->course_by_batch->batch_schedule) ? '<span style="font-size:1rem;font-weight:bold;color:#20B876;"><i class="fa fa-clock-o">&nbsp;'.count($value->course_by_batch->batch_schedule).' Days</i></span>' : ''   !!}
                                            </div>
                                            <div class="course-meta d-flex justify-content-center" style="font-size: 1rem;font-weight: bold; color:#20B876;">
                                                <span class="price"><i class="fa fa-money"></i>&nbsp;{{$value->course_by_batch->fee_amount }} Tk. </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        @endif
                    @endforeach
                @else
                    <div class="alert alert-success col-md-12 text-center" role="alert">
                        <h4 class="alert-heading">Such courses have not yet been set!</h4><hr>
                        <p>The course outline will be published shortly once set.</p>
                    </div>
                @endif

            {{--<div class="col-md-12 text-center font-weight-lighter">
                <h4>Our Course</h4>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course1.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">Mobile Apps</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course2.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">Mobile Apps</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course3.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">Digital Marketting</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course4.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">Sooftware Testing</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course5.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">game Design</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{asset('/frontend/assets/img/course6.jpg')}}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">User Experience</a></h3>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium at adipisci animi? Quos consequuntur fuga</p>
                                <a href="#" class="course-btn">join now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>50 seats</span>
                                    <span><i class="fa fa-clock-o"></i>6 month</span>
                                </div>
                                <span class="price">$50</span>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </div>
            {{--<div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-pagination text-center">
                        <ul>
                            <li><a href="#" class="active">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>--}}
        </div>
    </section>
@endsection
@section('footer-script')
@endsection