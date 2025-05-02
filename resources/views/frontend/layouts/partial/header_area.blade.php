<header id="header-area">
    <div class="main-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12">
                    {{-- <div class="logo">--}}
                    {{--<a href="{{isset($header->link)? $header->link : ''}}"><img src="{{ asset('frontend/assets/image/' . isset($header->doc_file)? $header->doc_file : '') }}"
                                                      --}}{{--src="https://via.placeholder.com/240x34"--}}{{-- alt=""/></a>--}}
                    <a href="{{route('/home')}}"><img src="{{asset('/frontend/assets/img/logo.png')}}"
                                                      {{--src="https://via.placeholder.com/240x34"--}} alt=""/></a>
                    {{--</div>--}}
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <li class="active"><a href="{{route('/home')}}">Home</a>
                                    {{--<ul class="sub-menu">
                                        <li><a href="index-1.html">home-1</a></li>
                                        <li><a href="index-2.html">home-2</a></li>
                                    </ul>--}}
                                </li>
                                <li><a href="#">About<span class="caret"><i class="fa fa-angle-down"></i></span></a>
                                    <ul class="sub-menu">
                                        <li><a href="{{route('about-us.index')}}">Who We Are</a></li>
                                        <li><a href="{{route('trainers.index')}}">Experienced Trainer</a></li>
                                        <li><a href="{{route('student-feedback.index')}}">Students Feedback</a></li>
                                        <li><a href="{{route('privacy-policy.index')}}">Privacy Policy</a></li>
                                        <li><a href="{{route('circular.index')}}">Circular</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{route('course.index')}}">Courses<span class="caret"><i class="fa fa-angle-down"></i></span></a>
                                    <ul class="sub-menu">
                                        @foreach((\App\Entities\backend\lookup\LCourseType::where('active_yn','=','Y')->get()) as $course )
                                            <li>
                                                <a href="{{route('course.list',['id'=>$course->id])}}">{{ $course->type_name_en }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{--<ul class="sub-menu">
                                        <li><a href="course-grid.html">course-grid</a></li>
                                        <li><a href="course-list.html">course-list</a></li>
                                        <li><a href="course-details.html">course-details</a></li>
                                        <li><a href="event-grid.html">Event-grid</a></li>
                                        <li><a href="event-list.html">Event-list</a></li>
                                        <li><a href="event-details.html">event-details</a></li>
                                    </ul>--}}
                                </li>
                                {{--<li><a href="#">Pages<span class="caret"><i class="fa fa-angle-down"></i></span></a>
                                    <ul class="sub-menu text-left" >
                                        <li><a href="teacher.html">teacher</a></li>
                                        <li><a href="gallery-1.html">gallery-1</a></li>
                                        <li><a href="gallery-2.html">gallery-2</a></li>
                                        <li><a href="login.html">login</a></li>
                                        <li><a href="registration.html">registration</a></li>
                                        <li><a href="faq.html">faq</a></li>
                                        <li><a href="404.html">404</a></li>
                                    </ul>
                                </li>--}}
                                <li><a href="{{route('web-post.index')}}">Blog<span class="caret"><i class="fa fa-angle-down"></i></span></a>
                                    <ul class="sub-menu text-left">
                                        @foreach((\App\Entities\backend\lookup\LPostCategory::where('status','=',\App\Enums\PostCategoryStatus::ACTIVE)->where('category_for','=',\App\Enums\PostCategoryFor::BLOG)->get()) as $blog )
                                            <li>
                                                <a href="{{route('web-post.category-wise-posts',['id'=>$blog->post_category_id])}}">{{ $blog->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{route('service.index')}}">Services<span class="caret"><i class="fa fa-angle-down"></i></span></a>
                                    <ul class="sub-menu">
                                        @foreach((\App\Entities\backend\lookup\LPostCategory::where('status','=',\App\Enums\PostCategoryStatus::ACTIVE)->where('category_for','=',\App\Enums\PostCategoryFor::SERVICE)->get()) as $service )
                                            <li>
                                                <a href="{{route('service.list',['id'=>$service->post_category_id])}}">{{ $service->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{route('contact-us.index')}}">Contact</a></li>
                                <li><a href="https://abadhutit.com/course/course-list/8">Time Education Center</a></li>
                                {{--<li class="search-icon">
                                    <a href="javascript:void(0)"><i class="fa fa-search" aria-hidden="true"></i></a>
                                    <div class="search-form">
                                        <form action="#">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Serach here" name="serch">
                                                <a href="#" class="serach-btn"><i class="fa fa-search"></i></a>
                                            </div>
                                        </form>
                                    </div>
                                </li>--}}
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div>
</header>
