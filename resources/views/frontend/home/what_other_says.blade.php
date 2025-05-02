<section class="testimonial section-padding">
    <div class="conatiner">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title text-center">
                    <h2>What Other says</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="responsive">
                    @foreach($wos as $value)
                        <div class="client-single slider-animation">
                            <div class="client-id">
                                <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}" alt="">
                                <h3>{{$value->content_title}}</h3>
                                <h4>{{$value->link}}</h4>
                            </div>
                            <div class="client-review">
                                <p>{{preg_replace('/<[^>]*>/', '', $value->content)}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!--End testimonials section -->