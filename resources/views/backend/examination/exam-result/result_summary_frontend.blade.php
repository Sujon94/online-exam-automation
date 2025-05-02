<div class="row">
    <div class="col-md-12">
        <h5></h5>
        <table class="table table-sm">
            <thead class="cus-bg-color" style="color: white;">
            <tr>
                <th colspan="2">{{$data["exam_name"]}}</th>
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
            <tr>
                <td>Mark Achieved</td>
                <td class="">
                    <div class="d-flex justify-content-between">
                        <p>
                            {{$data['totalMarkAchieved']}}
                        </p>
                        <a class="btn btn-sm btn-success" data-toggle="collapse" href="#collapse" role="button"
                           aria-expanded="false" aria-controls="multiCollapseExample1">Result Detail</a>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="collapse multi-collapse" id="collapse">
                                <div class="card card-body">
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
                                                <td class="text-right">{{$d->achived_mark}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
            <tfoot class="cus-bg-color" style="color: white;">
            <tr>
                <td>Percent Secured</td>
                <td class="">{{$data['passPercentage']}}%{!! $data['status'] !!}</td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
    @if($data['allow_cert'])
        <div class="col-md-12 d-flex justify-content-center">
            <a target="_blank"
               href="{{route('assessment-cert',['e'=>encrypt($data['exam']),'t'=>encrypt($data['tran'])])}}"
               id="download" class="btn btn-sm btn-info"><i class="fa fa-download"></i>Certificate Download</a>|
            <button class="btn btn-sm btn-info" data-cert="{{route('view-certificate',['cert'=>$data['cert']])}}"
                    id="shareCert">share<i class="fa fa-share"></i></button>
        </div>
        <div class="col-md-12 text-center">
                <span>***Please print color Certificate on A4 size 100 gsm paper</span>
        </div>

    @endif
</div>

