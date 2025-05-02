<section class="slider-area">
    <div class="container-full">
        <div class="row">
            <div class="col-lg-12 regular">
                @foreach($slider as $value)
                    <div class="slider" style="background : url({{ asset('frontend/assets/image/' . $value->doc_file) }}) center no-repeat;
                    background-size: cover;
                    position: relative;">
                        <div class="edu-overlay"></div>
                        <div class="container">
                            <div class="row justify-content-start">
                                <div class="col-lg-10">
                                    <div class="welcome-text">
                                        <h1>{{$value->content_title}}</h1>
                                        <h3>{{$value->extra_field_1}}</h3>
                                        <p>{{$value->extra_field_2}}</p>
                                        <a href="{{$value->link}}" class="welcome-btn">{{$value->extra_field_3}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{--<div class="slider-1">
                    <div class="edu-overlay"></div>
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-10">
                                <div class="welcome-text">
                                    <h1>Welcome To <span>SD Academy</span></h1>
                                    <h3>Education is the process of facilitating learning</h3>
                                    <p>Education is the most powerful weapon which you can use to change the world.</p>
                                    <a href="{{route('about-us.index')}}" class="welcome-btn">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-2">
                    <div class="edu-overlay"></div>
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-10">
                                <div class="welcome-text">
                                    <h1>Welcome To</h1>
                                    <h3 style="color: #20B876;" class="font-weight-bold"><span>abadhut-it</span></h3>
                                    <p>Education is the most powerful weapon which you can use to change the world.</p>
                                    <a href="{{route('about-us.index')}}" class="welcome-btn">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-3">
                    <div class="edu-overlay"></div>
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-lg-10">
                                <div class="welcome-text">
                                    <h1>Welcome To <span>SD Academy</span></h1>
                                    <h3>Education is the process of facilitating learning</h3>
                                    <p>Education is the most powerful weapon which you can use to change the world.</p>
                                    <a href="{{route('about-us.index')}}" class="welcome-btn">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
</section>
