<section class="eduspace-starts section-padding pb-0">
    <div class="edu-overlay"></div>
    <div class="container">
        <div class="row">
            @foreach($csec as $value)
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="eduspace-area text-center">
                        <div class="countdown">
                            <div class="counticon">
                                <i class="{{$value->icon}}"></i>
                                <h1 class="counter aboutcounter">{{$value->content_title}}</h1>
                                <h3>{{preg_replace('/<[^>]*>/', '', $value->content)}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>