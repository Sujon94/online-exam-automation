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

        .timer-container {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            position: relative;
            overflow: hidden;
        }

        .timer-display {
            font-size: 40px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .pulse-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 10px solid #00ff00; /* Initial border color */
            background-color: rgba(0, 0, 0, 0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.2;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.4;
            }
            100% {
                transform: scale(1);
                opacity: 0.2;
            }
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
                        <a href="{{$requested_url}}" class="btn btn-sm btn-info retry"><i class="bx bx-reset"></i>Retry</a>
                    </div>
                </div>
            @endif
            <br>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <div class="timer-container">
                        <div class="timer-display">
                            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span>
                        </div>
                        <div class="pulse-animation"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <p>Time Remains</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Get start and end times from user input or set default values
            var startTime = new Date({{$currentTime*1000}});
            var endTime = new Date({{$departureTime*1000}});

            // Calculate initial time remaining
            var timeRemaining = endTime - startTime;
            // Update time remaining every second
            setInterval(function() {
                timeRemaining -= 1000;

                // Convert time remaining to hours, minutes, and seconds
                var hours = Math.floor(timeRemaining / (1000 * 60 * 60));
                var minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                // Update HTML elements with time remaining
                $("#hours").text(hours.toString().padStart(2, "0"));
                $("#minutes").text(minutes.toString().padStart(2, "0"));
                $("#seconds").text(seconds.toString().padStart(2, "0"));

                // Check if timer has ended
                if (timeRemaining <= 0) {
                    window.location.href = "{{$requested_url}}";
                    clearInterval(this);
                }

                // Calculate the percentage of time remaining
                var percentageRemaining = (timeRemaining / (endTime - startTime)) * 100;

                // Set the border color based on the percentage remaining
                $(".pulse-animation").css("border-color", `hsl(${percentageRemaining * 2}, 100%, 50%)`);
            }, 1000);
        });

    </script>
@endsection
