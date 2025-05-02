@extends('frontend.layouts.default')
@section('header-style')
    <style>
        .p, p {
            font-size: 1.25rem;
        }
    </style>
@endsection
@section('content')
    <!--Start Eduspace banner Section-->
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Contact Us</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Contact</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->

    <!--Start contact-address Section-->
    <section class="contact-address section-padding">
        <div class="container">
            @if(Session::has('message'))
                <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show mt-2 text-center h6"
                     role="alert">
                    <strong>{{ Session::get('message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{--<div class="row">
                <div class="col-md-12">--}}
            <div class="row">
                @foreach($address as $value)
                    <div class="col-md-6 mb-3">
                        <div class="contact-details-area">
                            <div class="contact-details-icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="contact-details">
                                <h4>{{ $value->content_title }}</h4>
                                <h5><?php echo html_entity_decode($value->content);?></h5>
                                <h5><a href="#"><i class="fa fa-envelope"></i> {{ $value->extra_field_3 }}</a></h5>
                                <h5><i class="fa fa-phone"></i> {{ $value->extra_field_1 }}</h5>
                                <h5><i class="fa fa-whatsapp"></i> {{ $value->extra_field_2 }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--End contact-address Section-->
    <!--Start contact-main-area Section-->
    <section class="contact-main-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12 contact-form-area">
                    <div class="edu-title mb-4 mt-0"><h2><span class="">Submit Your Message</span></h2></div>
                    <div class="contact-form">
                        <form class="cmxform" id="contact-form" method="post" action="{{route('contact-us.store')}}">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input required type="text" class="form-control" placeholder="Enter Your Name"
                                           id="contact_name" name="name">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input required type="email" class="form-control" placeholder="Enter Your Email"
                                           id="contact_email" name="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="number" class="form-control" placeholder="Enter Your phone Number"
                                           id="contact_number" name="pnumber">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Write your Message here..."
                                              id="contact_message" name="message" required></textarea>
                                </div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LfM670lAAAAABn9XCbLKjAbryBoOc7e2ldwEDGU"></div>
                            <br/>
                            <div class="col-md-6">
                                <div class="confirm">
                                    <button type="submit" class="eduspace-btn">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End contact-main-area Section-->
    <!--Start map-area Section-->
    <section class="map-area">
        <div class="container-full">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-location">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End map-area Section-->


@endsection
@section('footer-script')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!--gmap js -->
    <script src="https://maps.google.com/maps/api/js?key="></script>
    <script type="text/javascript">
        function onSubmit(token) {
            document.getElementById("contact-form").submit();
        }

        $(window).on('load', function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 23.810332,
                    lng: 90.412518
                },
                zoom: 13
            });
            // Let's also add a marker while we're at it
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(23.810332, 90.412518),
                map: map,
                icon: {
                    url: 'assets/img/marker.png',
                },
                animation: google.maps.Animation.BOUNCE
            });
        });
    </script>
@endsection