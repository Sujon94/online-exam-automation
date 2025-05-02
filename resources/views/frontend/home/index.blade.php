@extends('frontend.layouts.default')
@section('header-style')

@endsection

@section('content')
    @include('frontend.home.slider')<!--DONE-->
    @include('frontend.home.service')<!--DONE-->
    @include('frontend.home.who_we_are')<!--DONE-->
    @include('frontend.home.what_we_do')<!--DONE-->
    @include('frontend.home.counter_section')<!--DONE-->
    @include('frontend.home.course')<!--DONE-->
    @include('frontend.home.video_section')<!--DONE-->
    @include('frontend.home.gallery')<!--DONE-->
    @include('frontend.home.teacher')<!--DONE-->
    @include('frontend.home.services')<!--DONE-->
    @include('frontend.home.what_other_says')<!--DONE-->
    @include('frontend.home.why_choose_sd')<!--DONE-->
@endsection

@section('footer-script')

@endsection