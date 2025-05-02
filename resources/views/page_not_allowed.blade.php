<?php
/**
 *Created by PhpStorm
 *Created at ১৩/৯/২১ ৪:৫৮ PM
 */
?>
@extends("frontend.layouts.default")

@section('title')
@endsection

@section('header-style')
    <style type="text/css">
        .height {
            min-height: 200px;
        }
    </style>
@endsection

@section('content')
    <div class="card height">
        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <h3 class="text-danger"><span class="bx bx-info-circle"></span>{{$message}}</h3>
                </div>
            </div>
            @if(isset($requested_url))
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="{{$requested_url}}" class="btn btn-sm btn-info"><i class="bx bx-reset"></i>Retry</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('footer-script')
@endsection
