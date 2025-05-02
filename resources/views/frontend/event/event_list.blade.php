@extends('frontend.layouts.default')
@section('header-style')
    <style type="text/css" rel="stylesheet">
        /* Styles for small screens (e.g., smartphones) */
        @media (max-width: 768px) {
            .star{
                width: 10%;
                height: 10%;
            }
        }

        /* Styles for medium screens (e.g., tablets) */
        @media (min-width: 769px) and (max-width: 992px) {
            .star{
                width: 6%;
                height: 6%;
            }
        }

        /* Styles for large screens (e.g., desktops) */
        @media (min-width: 993px) {
            .star{
                width: 5%;
                height: 5%;
            }
        }
    </style>
@endsection
@section('content')
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>Events</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="#">Event List</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->

    <section class="course-details mb-4">
        <div class="container" style="min-height: 200px !important;">
            <div class="row">
                <div class="col-md-12 pt-4 table-responsive">
                    <table class="table table-sm table-hover table-bordered border">
                        <thead class="">
                            <tr>
                                <th width="65%">Event Name</th>
                                <th width="10%">Event Date</th>
                                <th width="10%">Event Start At</th>
                                <th width="10%">Event End At</th>
                                <th width="5%">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $event)
                            <tr>
                                <td>{{$event->exam_name}} {!!  (\Illuminate\Support\Carbon::parse($event->exam_date)->format('Y-m-d') >= date('Y-m-d')) ? __('<img class="star" src="'.asset('frontend/assets/image/start1.gif').'" />'): ''!!}</td>
                                <td>{{$event->exam_date}}</td>
                                <td>{{\Illuminate\Support\Carbon::parse($event->exam_start_at)->format('h:i A')}}</td>
                                <td>{{\Illuminate\Support\Carbon::parse($event->exam_end_at)->format('h:i A')}}</td>
                                <td><a target="_blank" href="{{route('event.event-detail',['event'=>encrypt($event->exam_id)])}}">Details</a></td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">{{__('No events are published yet.')}}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer-script')
@endsection