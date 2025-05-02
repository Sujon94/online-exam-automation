<section class="widget-area">

    <div class="container">
        <div class="row mt-5">
            <div class="col-md-1">
                <a href="#"><img class="justify-content-start pl-0"
                                 src="{{--{{ asset('frontend/assets/image/' . $contact_top_left_img->doc_file) }}--}}{{asset('/frontend/assets/image/1715680848.png')}}"
                                 style="width: 50px; height: 50px" alt=""></a>
            </div>
            <div class="col-md-4">
                <a href="#"><img
                            src="{{ asset('frontend/assets/image/' . \App\Helpers\HelperClass::contactTopR8Img()->doc_file) }}"
                            style="width: 50px; height: 50px" alt=""></a>
            </div>
        </div>
        <div class="row widgt-main-area mt-0">
            <div class="col-lg-3 f-wiget-bottom">

                <div class="f-widget-area">
                    <div class="f-widget-title mb-0">
                        <h4>{{isset(\App\Helpers\HelperClass::newsletter()->content_title)?\App\Helpers\HelperClass::newsletter()->content_title:""}}</h4>
                    </div>
                    <div class="news-text">
                        <p>{{preg_replace('/<[^>]*>/', '', isset(\App\Helpers\HelperClass::newsletter()->content)?\App\Helpers\HelperClass::newsletter()->content:"")}}</p>
                    </div>
                    <div class="course-content mt-3">
                        <a href="{{isset(\App\Helpers\HelperClass::newsletter()->link)?\App\Helpers\HelperClass::newsletter()->link:""}}"
                           class="course-btn">join now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 f-wiget-bottom">
                <div class="f-widget-title mb-0">
                    <h4>useful links</h4>
                </div>
                <div class="categories">
                    <ul>
                        {{--@if(isset($usefullink))
                            @foreach($usefullink as $value)
                                <li><a href="{{$value->link}}"><i
                                                class="fa fa-caret-right"></i>{{$value->content_title}}</a></li>
                            @endforeach
                        @endif--}}
                        @foreach(\App\Helpers\HelperClass::usefullink() as $value)
                            <li><a href="{{$value->link}}"><i
                                            class="fa fa-caret-right"></i>{{$value->content_title}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 f-wiget-bottom">
                <div class="f-widget-title mb-0">
                    <h4>latest News</h4>
                </div>
                <div class="latest-news">
                    {{--@if(isset($latestnews))
                        @foreach($latestnews as $value)
                            <div class="widget-blog">
                                <div class="w-r-left">
                                    <img src="{{ asset('frontend/assets/image/' . $value->doc_file) }}"
                                         alt="" class="img-fluid w-auto"
                                         style="height: 66px;"/>
                                </div>
                                <div class="w-r-right" style="padding-left: 40%;">
                                    <a href="{{$value->link}}">{{$value->content_title}}</a>
                                    <p>{{$value->extra_field_1}}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif--}}
                    @foreach((\App\Entities\backend\Post::with(['post_photo'])->where('post_for', \App\Enums\PostCategoryFor::BLOG)->orderBy('post_id','DESC')->skip(0)->take(2)->get()) as $value )
                        <div class="widget-blog">
                            <div class="w-r-left">
                                <img src="data:{{isset($value->post_photo->doc_file_type)}}; base64, {{isset($value->post_photo->doc_file)? $value->post_photo->doc_file : ''}}"
                                     alt="{{isset($value->post_photo->doc_file_name)}}" class="img-fluid w-auto"
                                     style="height: 66px;"/>
                            </div>
                            <div class="w-r-right" style="padding-left: 40%;">
                                <a href="{{route('web-post.detail',['slug'=>$value->slug])}}">{{$value->title}}</a>
                                <p>{{date('jS F, Y', strtotime($value->created_at))}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3 f-wiget-bottom">
                <div class="f-widget-title mb-0">
                    <h4>Contact Us</h4>
                </div>
                {{--<div class="about-eduspace row">
                    <div class="col-sm-12 pl-0">
                        <div class="contact-info pt-0 pb-0" style="margin: 0; padding: 5px 0;">
                            --}}{{--<p class="pt-0 pb-0" style="font-size: 30px; font-style: oblique; color: white"> Contact
                                Us</p>--}}{{--
                            <p class="pt-0 pb-0"><i
                                        class='{{\App\Helpers\HelperClass::contactEmail()->icon}}'></i> {{\App\Helpers\HelperClass::contactEmail()->extra_field_1}}
                            </p>
                            @foreach(\App\Helpers\HelperClass::contactPhone() as $value)
                                <p class="pt-0 pb-0"><i class='{{$value->icon}}'></i> {{$value->extra_field_1}}</p>
                            @endforeach
                        </div>
                    </div>
                </div>--}}
                <div class="categories">
                    <ul>
                        <li style="color: white">
                            <i style="color: white" class='{{\App\Helpers\HelperClass::contactEmail()->icon}}'></i> {{\App\Helpers\HelperClass::contactEmail()->extra_field_1}}
                        </li>
                        @foreach(\App\Helpers\HelperClass::contactPhone() as $value)
                            <li style="color: white">
                                <i style="color: white" class='{{$value->icon}}'></i> {{$value->extra_field_1}}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="widget-social">
                    <ul>
                        {{--@if(isset($contact_social))--}}
                        @foreach(\App\Helpers\HelperClass::contactSocial() as $value)
                            <li><a href="{{$value->link}}" target="_blank"><i class="{{$value->icon}}"></i></a></li>
                        @endforeach
                        {{--@endif--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>