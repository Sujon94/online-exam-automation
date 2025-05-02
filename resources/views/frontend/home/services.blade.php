<section class="our-services section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h2>{{$os->content_title}}</h2>
                    <p>{{preg_replace('/<[^>]*>/', '', $os->content)}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($osg as $value)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="course-area">
                        <div class="course-img">
                            <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" class="img-fluid"
                                 alt="">
                            <div class="c-overlay"></div>
                        </div>
                        <div class="content-area">
                            <div class="course-content">
                                <h3><a href="#">{{$value->content_title}}</a></h3>
                                <p>{{preg_replace('/<[^>]*>/', '', $value->content)}}</p>
                                <a href="{{$value->link}}" class="eduspace-btn">All
                                    Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>