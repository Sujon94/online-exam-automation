@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-header bg-white">
            <i class="fa fa-table"></i> Result Summary
            <a class="btn btn-sm btn-info ml-2" href="{{route('exam.student-list',['exam'=>\Illuminate\Support\Facades\Crypt::encrypt($examId)])}}">Back</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th>Participant Name</th>
                            <th>{{$data["participant"]}}</th>
                        </tr>
                        <tr>
                            <th>Exam Name</th>
                            <th>{{$data["exam"]}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>Total Question</td>
                            <td class="">{{$data['totalQuestion']}}</td>
                        </tr>
                        <tr>
                            <td>Total Mark</td>
                            <td class="">{{$data['totalMark']}}</td>
                        </tr>
                        <tr>
                            <td>Question Answered</td>
                            <td class="">{{$data['totalAnswered']}}</td>
                        </tr>
                        <tr>
                            <td>Correct Answered</td>
                            <td class="">{{$data['correctAnswered']}}</td>
                        </tr>
                        <tr>
                            <td>Wrong Answered</td>
                            <td class="">{{$data['wrongAnswered']}}</td>
                        </tr>
                        <!--                        <tr>
                            <td>Need to Manual Check</td>
                            <td class="">{{$data['needToManualCheck']}}</td>
                        </tr>-->
                        <tr>
                            <td>Mark Achieved</td>
                            <td class="">
                                <div class="d-flex justify-content-between">
                                    <p>
                                        {{$data['totalMarkAchieved']}}
                                    </p>
                                    <button class="collapsed btn btn-sm btn-success" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#headingCollapse"
                                            aria-expanded="false"
                                            aria-controls="heading">
                                        Detail Result
                                    </button>
                                </div>
                                <div class="accordion" id="resultDtl">
                                    <div class="accordion-item">
                                        <div id="headingCollapse"
                                             class="accordion-collapse collapse"
                                             aria-labelledby="heading"
                                             data-bs-parent="#resultDtl">
                                            <div class="accordion-body">
                                                <table class="table border table-bordered">
                                                    <thead class="bg-success text-white">
                                                    <tr>
                                                        <th>Subject</th>
                                                        <th>Topic</th>
                                                        <th>Achieved Mark</th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($resultDetail as $d)
                                                        <tr>
                                                            <td>{{$d->subject}}</td>
                                                            <td>{{$d->topic}}</td>
                                                            <td>{{$d->achived_mark}}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Pass Percentage</td>
                            <td class="">{{$data['passPercentage']}}%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-2"></div>
            </div>
            <!--            <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <a class="btn btn-info" href="#">Detail</a>
                            </div>
                        </div>-->
        </div>
    </div>
@endsection

@section("footer-script")
    {{--
        <script type="text/javascript" src="{{asset('backend/assets/js/pages/exam/studentList.js')}}"></script>
    --}}

@endsection