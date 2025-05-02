<!--Start Service section -->
<section class="service section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="edu-title">
                    <h2>{{$services->content_title}}</h2>
                    {!! html_entity_decode($services->content) !!}
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($service_bottom as $key =>$value)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="service-area-2 @if($key == 1) service-active @endif text-center">
                        <div class="service-icon">
                            <i class="{{$value->icon}}"></i>
                        </div>
                        <a href="{{$value->link}}" class="text-white">
                            <h3>{{$value->content_title}}</h3>
                            {!! html_entity_decode($value->content) !!}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section><!--End Service section -->
