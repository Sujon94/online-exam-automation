<section class="our-course section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h2>{{$our_course->content_title}}</h2>
                    <p>{!! html_entity_decode($our_course->content) !!}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($our_course_2 as $value)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="img-fluid" alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">{{$value->content_title}}</a></h3>
                                <p>{!! html_entity_decode($value->content) !!}</p>
                                <a href="{{$value->link}}" class="course-btn" style="width: 50%">Enroll now</a>
                            </div>
                            <div class="course-meta">
                                <div class="course-left">
                                    <span><i class="fa fa-users"></i>{{$value->extra_field_1}}</span>
                                    <span><i class="fa fa-clock-o"></i>{{$value->extra_field_2}}</span>
                                </div>
                                <span class="price">{{$value->extra_field_3}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
