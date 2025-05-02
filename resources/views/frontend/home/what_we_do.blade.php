<section class="what-we-do section-padding bg-light pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h5 class="font-weight-bold text-success">{{$wwedo->content_title}}</h5>
                    <h2>{{preg_replace('/<[^>]*>/', '', $wwedo->content)}}</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($wwedo2 as $value)
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="img-fluid"
                                 alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">{{$value->content_title}}</a></h3>
                                <p>{!! html_entity_decode($value->content) !!}</p>
                                <a href="{{$value->link}}" class="eduspace-btn">All Courses</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>