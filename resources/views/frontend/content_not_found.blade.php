@extends('frontend.layouts.default')
@section('header-style')
    <style type="text/css" rel="stylesheet">
        .f-5 {
            font-size: 5em;
        }
        .f-8 {
            font-weight: bold;
            font-size: 8em;
            color: #28a745;
        }
        .f-10 {
            font-size: 10em;
        }
    </style>
@endsection
@section('content')
        <div  class="wrapper text-center mt-5 mb-5">
                <span class="f-8">4</span><span class="f-10">0</span><span class="f-8">4</span>
            <br>
            <br>
            <br>
            <span class="f-5">Content</span> <span class="f-8 pl-4 pr-4 pt-2 pb-2">not</span> <span class="f-5">found</span>
        </div>

@endsection
@section('footer-script')

@endsection