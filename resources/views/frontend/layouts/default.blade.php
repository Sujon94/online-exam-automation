<?php
/**
 *Created by PhpStorm
 *Created at ৭/৯/২১ ৩:২৭ PM
 */
?>
<!doctype html>
<html lang="en">
<head>
    <!--All Meta -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="{{ isset($metaInfo->meta_description) ? $metaInfo->meta_description : ( empty(\App\Helpers\HelperClass::get_setting('meta_description')) ? 'abadhut-it  is the national Training, Research, Consultancy and Education institute in the field of Law, Business, Income Tax, VAT and soft skill' : \App\Helpers\HelperClass::get_setting('meta_description')  ) }}">
    <meta name="keywords" content="{{empty(\App\Helpers\HelperClass::get_setting('meta_key')) ? 'Training, Courses, Training Academy, Technical, Technical Training Academy, abadhut-it' : \App\Helpers\HelperClass::get_setting('meta_key')}}">
    <meta name="author" content="abadhut-it">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- page title -->
    <title>{{ isset($metaInfo->meta_title) ? $metaInfo->meta_title :  ( empty(\App\Helpers\HelperClass::get_setting('meta_title')) ? 'abadhut-it' : \App\Helpers\HelperClass::get_setting('meta_title')  ) }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.png')}}">

    <!--  Essential META Tags -->
    <meta property="og:title" content="{{isset($social) ? $social->title : 'abadhut-it'}}">
    <meta property="og:type" content="article" />
    <meta property="og:image" content="{{isset($social) ? asset('backend/assets/'.$social->image) : 'https://abadhutit.com/frontend/assets/img/logo.png'}}">
    <meta property="og:url" content="{{isset($social) ? $social->url : ''}}">

    <!--  Non-Essential, But Recommended -->
    <meta property="og:description" content="{!! isset($social) ? $social->description : 'abadhut-it  is the national Training, Research, Consultancy and Education institute in the field of Law, Business, Income Tax, VAT and soft skill' !!}">
    <meta property="og:site_name" content="abadhut-it ">

    <!--  Non-Essential, But Required for Analytics -->
    <meta property="fb:app_id" content="{{isset($social) ? $social->fb_app_id : ''}}" />
    <meta name="twitter:site" content="abadhut-it ">

    {{--<meta name="twitter:site" content="THIS IS CONTENT">
    <meta name="twitter:card" content="{{isset($social) ? $social->image_alt : ''}}">
    <meta name="twitter:title" content="TWITTER CONTENT">
    <meta name="twitter:description" content="TWITTER DESCRIPTION">
    <meta name="twitter:image:src" content="{{isset($social) ? asset('backend/assets/'.$social->image) : 'https://abadhutit.com/frontend/assets/img/logo.png'}}">
    <meta name="twitter:image" content="{{isset($social) ? asset('backend/assets/'.$social->image) : 'https://abadhutit.com/frontend/assets/img/logo.png'}}" />
    <meta name="twitter:image:alt" content="abadhut-it  New Course">--}}

    {{-- Add Pavel 28-03-22 --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="{!! isset($social) ? $social->description : 'abadhut-it  is the national Training, Research, Consultancy and Education institute in the field of Law, Business, Income Tax, VAT and soft skill' !!}" />
    <meta name="twitter:title" content="{{isset($social) ? $social->title : 'abadhut-it'}}" />
    <meta name="twitter:image" content="{{isset($social) ? asset('backend/assets/'.$social->image) : 'https://abadhutit.com/frontend/assets/img/logo.png'}}" />

    <link rel="canonical" href="{{ url()->current() }}" />

    <!--Bootstrap css-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Fontawesome css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome.min.css') }}">
    <!-- Slick slider css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick-theme.css') }}">
    <!-- magnific popup CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.css') }}">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.css') }}">
    <!--main style css-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}">
    <!--Responsive css-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">

    <!--Custom css-->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/common.css') }}">

    <!-- DataTables -->
    <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('backend/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- GOOGLE INDEXING CODE -->
    <meta name="google-site-verification" content="Qpp58LE1EDbR1Ak4gcWKpSaCJkVcCtC-heJv2_GUwOs" />

    @yield('header-style')
    <script>
        var APP_URL = "{{ url('/') }}";
        var tk = "<?php echo e(csrf_token()); ?>";
    </script>
    <!--modernizr js-->
    <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>

    <!-- Custom Header Script-->
    @if ( (strstr( \App\Helpers\HelperClass::get_setting('header_script'), '<script>')) && (strstr( \App\Helpers\HelperClass::get_setting('header_script'), '</script>')) )
        @php echo \App\Helpers\HelperClass::get_setting('header_script'); @endphp
    @endif

</head>
<body>
<!-- Load Facebook SDK for JavaScript -->
<!-- Block This sec start PAVEL-20-05-22 -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Block This sec end PAVEL-20-05-22 -->
{{--<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience.</p>
<![endif]-->--}}
<!--Start Preloader area-->
<div class="preloader-area">
    <div class="sk-cube-grid">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
        <div class="sk-cube sk-cube3"></div>
        <div class="sk-cube sk-cube4"></div>
        <div class="sk-cube sk-cube5"></div>
        <div class="sk-cube sk-cube6"></div>
        <div class="sk-cube sk-cube7"></div>
        <div class="sk-cube sk-cube8"></div>
        <div class="sk-cube sk-cube9"></div>
    </div>
</div>
<!-- End Preloader area -->
<!-- Block This sec start PAVEL-31-12-22// Open-13-05-23 -->
<!---------FB CHAT CODE----------->
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat"></div>
<!---------FB CHAT CODE----------->
<!-- Block This sec end PAVEL-31-12-22 //Open-13-05-23-->
<!--Start Header top area-->
@include('frontend.layouts.partial.header_top_bar')
<!--End Header top area-->
<!--Start Header area-->
@include('frontend.layouts.partial.header_area')
<!--End header area -->
<!-- Start slider section -->
@yield('content')
<!-- End teachers section -->
<!--start widget-area section -->
@include('frontend.layouts.partial.widget_area')
<!--End widget-area section -->
<!--start Footer area-->
@include('frontend.layouts.partial.footer')
<!--End Footer area-->
<!--Scroll-up-->
<a id="scroll-up"><i class="fa fa-angle-up"></i></a>
<!-- jequery  -->
<script src="{{asset('frontend/assets/js/vendor/jquery-1.12.0.min.js')}}"></script>
<!-- Bootstrap min.js  -->
<script src="{{ asset('frontend/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/bootstrap/js/popper.min.js') }}"></script>
<!-- slick slider js  -->
<script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
<!-- isotope min.js  -->
<script src="{{ asset('frontend/assets/js/isotope.min.js') }}"></script>
<!-- imageloaded js-->
<script src="{{ asset('frontend/assets/js/imagesloaded.pkgd.min.js') }}"></script>
<!-- magnific-popup js  -->
<script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- counterup js-->
<script src="{{ asset('frontend/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/waypoints.min.js') }}"></script>
<!--meanmenu js -->
<script src="{{ asset('frontend/assets/js/jquery.meanmenu.js') }}"></script>
<!--active js-->
<script src="{{ asset('frontend/assets/js/active.js') }}"></script>
<!--main js-->
<script src="{{ asset('frontend/assets/js/main.js') }}"></script>

<!-- Required datatable js -->
<script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<!-- Sweet Alerts js -->
<script src="{{asset('backend/assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
<script src="{{asset('js/timer.js')}}"></script>
<!-- Block This sec start PAVEL-31-12-22 //Open-13-05-23-->
<!------FB CHAT SCRIPT------->
<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "108529465427436");
    chatbox.setAttribute("attribution", "biz_inbox");

    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v16.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!------FB CHAT SCRIPT------->
<!-- Block This sec end PAVEL-31-12-22 //Open-13-05-23-->
@yield('footer-script')

<!-- Custom Footer Script-->
@if ( (strstr( \App\Helpers\HelperClass::get_setting('footer_script'), '<script>')) && (strstr( \App\Helpers\HelperClass::get_setting('footer_script'), '</script>')) )
    @php echo \App\Helpers\HelperClass::get_setting('footer_script'); @endphp
@endif

</body>
</html>