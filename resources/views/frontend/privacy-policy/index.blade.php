@extends('frontend.layouts.default')
@section('header-style')
@endsection
@section('content')
    <!--Start Eduspace banner Section-->
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Privacy Policy</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Privacy Policy</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->



    <!-- Start service section -->
    <section class="service section-padding">
        <div class="container">
            {{--<div class="row">
                <div class="col-lg-12">
                    <div class="edu-title">
                        <h2>Privacy Policy</h2>
                        <p>abadhut-it</p>
                    </div>
                </div>
            </div>--}}
            <div class="row">
                <!-- Section 1: Introduction -->
                <div>
                    <h2>Privacy Policy</h2>
                    <p>This privacy policy ("Policy") will help you understand how Self Development Technical Training
                        Academy ("us", "we", "our") uses and protects the data you provide to us when you visit and use
                        <a href="https://www.abadhutit.com/">abadhutit.com</a> ("blog", "service").</p>
                    <p>We reserve the right to change this policy at any given time, of which you will be promptly
                        updated. If you want to make sure that you are up to date with the latest changes, we advise you
                        to frequently visit this page.</p>
                </div>
            </div>
            <div class="row">
                <!-- Section 2: User Data Collection -->
                <div class="col-md-12">
                    <h2>User Data We Collect</h2>
                    <p>When you visit the blog, we may collect the following data:</p>
                    <ul>
                        <li><i class="fa fa-check-square-o"></i>Your IP address.</li>
                        <li><i class="fa fa-check-square-o"></i>Your contact information and email address.</li>
                        <li><i class="fa fa-check-square-o"></i>Other information such as interests and preferences.
                        </li>
                        <li><i class="fa fa-check-square-o"></i>Data profile regarding your online behavior on our blog.
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <!-- Section 3: Why We Collect Data -->
                <div class="col-md-12">
                    <h2>Why We Collect Your Data</h2>
                    <p>We are collecting your data for several reasons:</p>
                    <ul>
                        <li><i class="fa fa-check-square-o"></i>To better understand your needs.</li>
                        <li><i class="fa fa-check-square-o"></i>To improve our services and products.</li>
                        <li><i class="fa fa-check-square-o"></i>To send you promotional emails containing the information we think you will find
                            interesting.
                        </li>
                        <li><i class="fa fa-check-square-o"></i>To contact you to fill out surveys and participate in other types of market research.</li>
                        <li><i class="fa fa-check-square-o"></i>To customize our blog according to your online behavior and personal preferences.</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <!-- Section 4: Safeguarding and Securing the Data -->
                <div>
                    <h2>Safeguarding and Securing the Data</h2>
                    <p>abadhut-it is committed to securing your data and keeping it
                        confidential. abadhut-it has done all in its power to prevent
                        data theft, unauthorized access, and disclosure by implementing the latest technologies and
                        software, which help us safeguard all the information we collect online.</p>
                </div>
            </div>
            <div class="row">
                <!-- Section 5: Cookie Policy -->
                <div>
                    <h2>Our Cookie Policy</h2>
                    <p>Once you agree to allow our blog to use cookies, you also agree to use the data it collects
                        regarding your online behavior (analyze web traffic, web pages you visit and spend the most time
                        on).</p>
                    <p>The data we collect by using cookies is used to customize our blog to your needs. After we use
                        the data for statistical analysis, the data is completely removed from our systems.</p>
                    <p>Please note that cookies don't allow us to gain control of your computer in any way. They are
                        strictly used to monitor which pages you find useful and which you do not so that we can provide
                        a better experience for you.</p>
                    <p>If you want to disable cookies, you can do it by accessing the settings of your internet browser.
                        You can visit <a href="https://www.internetcookies.com">InternetCookies.com</a>, which contains
                        comprehensive information on how to do this on a wide variety of browsers and devices.</p>
                </div>
            </div>
            <div class="row">
                <!-- Section 6: Links to Other Websites -->
                <div>
                    <h2>Links to Other Websites</h2>
                    <p>Our blog contains links that lead to other websites. If you click on these links, Self
                        Development Technical Training Academy is not held responsible for your data and privacy
                        protection. Visiting those websites is not governed by this privacy policy agreement. Make sure
                        to read the privacy policy documentation of the website you go to from our website.</p>
                </div>
            </div>
            <div class="row">
                <!-- Section 7: Restricting the Collection of Personal Data -->
                <div>
                    <h2>Restricting the Collection of your Personal Data</h2>
                    <p>At some point, you might wish to restrict the use and collection of your personal data. You can
                        achieve this by doing the following:</p>
                    <ul>
                        <li>When you are filling the forms on the blog, make sure to check if there is a box which you
                            can leave unchecked, if you don't want to disclose your personal information.
                        </li>
                        <li>If you have already agreed to share your information with us, feel free to contact us via
                            email and we will be more than happy to change this for you.
                        </li>
                    </ul>
                    <p>abadhut-it will not lease, sell or distribute your personal
                        information to any third parties unless we have your permission. We might do so if the law
                        forces us. Your personal information will be used when we need to send you promotional materials
                        if you agree to this privacy policy.</p>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('footer-script')
    <script type="text/javascript">

        $(document).ready(function () {
            //Code here
        });
    </script>
@endsection