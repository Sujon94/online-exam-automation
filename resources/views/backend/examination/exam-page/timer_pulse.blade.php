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

        .clock {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background-color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            color: #fff;
        }

        .time {
            font-family: sans-serif;
        }

        .clock {
            /* ... other styles ... */
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        .clock {
            /* ... other styles ... */
            border: 10px solid #f00; /* Initial border color and width */
        }

        .time {
            /* ... other styles ... */
            position: relative;
        }

        .time::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 10px solid transparent; /* Match the outer border width */
            border-top-color: #0f0; /* Inner border color */
            border-radius: inherit; /* Inherit border radius from .clock */
            transform: rotate(0deg); /* Initial rotation */
            animation: rotate-border 60s linear infinite; /* Adjust animation duration */
        }


    </style>
@endsection

@section('content')
    <div class="card height">
        <div class="card-body">
            <div class="clock">
                <div class="time">
                    <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                </div>
            </div>

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
    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function() {
                var hours = new Date().getHours().toString().padStart(2, '0');
                var minutes = new Date().getMinutes().toString().padStart(2, '0');
                var seconds = new Date().getSeconds().toString().padStart(2, '0');

                $('#hours').text(hours);
                $('#minutes').text(minutes);
                $('#seconds').text(seconds);

                var elapsedSeconds = new Date().getTime() - new Date().getTime(); // Calculate elapsed time in milliseconds
                var totalSeconds = 60 * 60; // Assuming 1 hour for the timer
                var rotation = (elapsedSeconds / (totalSeconds * 1000)) * 360; // Calculate rotation based on total duration

                $('.time::before').css('transform', 'rotate(' + rotation + 'deg)');

            }, 1000);


        });

    </script>
@endsection
