<section class="why-choose-sd section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h2>{{$wcsd->content_title}}</h2>
                    <p>{{preg_replace('/<[^>]*>/', '', $wcsd->content)}}</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="faq-accoridian">
                    <div id="accordion">
                        @foreach($wcsdr as $value)
                            <div class="card f-bottom">
                                <div class="card-header" id="headingOne_{{$value->content_serial}}">
                                    <h5 class="mb-0"><a class="btn collapsed" data-toggle="collapse" data-target="#collapseOne_{{$value->content_serial}}" aria-expanded="false" aria-controls="collapseOne">
                                            {{$value->content_title}}
                                            <i class="fa fa-angle-down"></i>
                                            <i class="fa fa-angle-up"></i>
                                        </a></h5>
                                </div>
                                <div id="collapseOne_{{$value->content_serial}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        {{preg_replace('/<[^>]*>/', '', $value->content)}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="who-we-are-img">
                    <img style="width: 100%; height: 96.4%" src="{{ asset('frontend/assets/image/' . $wcsd->doc_file) }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!--End why-choose-sd-content Section-->

