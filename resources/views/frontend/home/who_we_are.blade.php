<section class="who-we-are section-padding pb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="who-we-are-details">
                    <div class="edu-title text-left mb-4">
                        <h5 class="font-weight-bold text-success">Who We Are</h5>
                        <h2>{{$wweare->content_title}}</h2>
                    </div>
                    <div class="who-we-are-main-content">
                        {!! html_entity_decode($wweare->content) !!}
                        {{--<p><img src="{{ asset('frontend/assets/image/' . $wweare2->doc_file) }}" class="rounded float-left" alt="BTEB"><span class="badge badge-success">{{$wweare2_title}}</span></p>--}}
                    </div>
                    <div class="who-we-are-buttn pt-4">
                        <a href="{{$wweare2->link}}" class="eduspace-btn">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="who-we-are-img">
                    <img src="{{ asset('frontend/assets/image/' . $wweare->doc_file) }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>