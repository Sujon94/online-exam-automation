@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-header bg-white">
            <i class="fa fa-table"></i> List of Participants

        </div>
        <div class="card-body">
            @if(count($students) > 0)
                @if($students[0]->exam_info->exam_type == \App\Enums\Exam\LExamType::EVENT_COMPETITION)
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end">
                            <div>
                                <button data-i="{{$examId}}" class="btn btn-sm btn-success"
                                        id="result_export">
                                    <i class="fa fa-print"></i>Export Result
                                </button>
                            </div>
                        </div>
                    </div>
                    <table id="studentTable" class="dataTable display table table-stripped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $key=>$student)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$student->participant->student->candidate_name}}</td>
                                <td>{{$student->participant->student->mobile}}</td>
                                <td>{{$student->participant->student->email}}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" target="_blank"
                                       href="{{route("exam.student-result", ['exam' => $student->exam_id, 'trans' => $student->student_trans_id])}}">Results</a>
                                    @if($student->exam_info->status == \App\Enums\Exam\LExamStatus::COMPLETED )
                                        <button class="btn btn-sm btn-info"
                                                onClick="reviewAnswer({{$student->exam_id}},{{$student->student_trans_id}})"
                                        >Judge Written Answers
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                @else
                    <table id="studentTable" class="dataTable display table table-stripped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $key=>$student)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{$student->participant->student->candidate_name}}</td>
                                <td>{{$student->participant->batch->course->course_name_en}}</td>
                                <td>{{$student->participant->batch->batch_name_en}}</td>
                                <td>
                                    <a class="btn btn-sm btn-success" target="_blank"
                                       href="{{route("exam.student-result", ['exam' => $student->exam_id, 'trans' => $student->student_trans_id])}}">Results</a>
                                    @if($student->exam_info->status == \App\Enums\Exam\LExamStatus::COMPLETED )
                                        <button class="btn btn-sm btn-info"
                                                onClick="reviewAnswer({{$student->exam_id}},{{$student->student_trans_id}})"
                                        >Judge Written Answers
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Course</th>
                            <th>Batch</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                @endif
            @else
                <table id="studentTable" class="dataTable display table table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="5" class="text-center">No participant found</td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Batch</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="resultModal" role="dialog" tabindex="-1" aria-labelledby="resultModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title text-center" id="resultModalTitle">Written Questions</h5>
                </div>
                <form id="judgeForm" method="post" action="{{route('exam.store-judgement')}}">
                    @csrf
                    <div class="modal-body">
                        <div id="rContent"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section("footer-script")
    {{--
        <script type="text/javascript" src="{{asset('backend/assets/js/pages/exam/studentList.js')}}"></script>
    --}}
    <script>
        function reviewAnswer(exam, tran) {
            let request = $.ajax({
                url: APP_URL + '/backend/judge-answer/' + exam + '/' + tran,
                method: 'GET',
                data: {exam, tran},
                dataType: 'JSON',
                headers: {
                    'x-csrf-token': tk
                }
            });
            request.done(function (res) {
                if (res.response_code == 1) {
                    $("#rContent").html(res.content);
                    $("#resultModal").modal("show");
                } else {
                    swal.fire({
                        text: res.response_msg,
                        icon: 'warning',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 9000
                    })
                }
            });
            request.fail(function (xhr) {
                swal.fire({
                    text: xhr,
                    icon: 'warning',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 9000
                })
            });
        }

        $("#judgeForm").on("submit", function (e) {
            e.preventDefault();

            swal.fire({
                text: 'Confirm?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value == true) {
                    let request = $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        processData: false,
                        contentType: false,

                        header: {'x-csrf-token': '{{csrf_token()}}'},
                        data: new FormData($(this)[0])
                    });

                    request.done(function (res) {
                        if (res.response_code != "99") {
                            Swal.fire({
                                icon: 'success',
                                text: res.response_msg,
                                showConfirmButton: false,
                                timer: 2000,
                                allowOutsideClick: false
                            }).then(function () {
                                location.reload();
                            });
                        } else {
                            Swal.fire({text: res.response_msg, icon: 'error'});
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        console.log(jqXHR);
                    });
                }
            })
        })

        function downloadResult() {
            $("#result_export").on("click", function () {
                let i = $(this).data('i');
                window.location.href = APP_URL+'/backend/exam-result-export/'+i;
            })
        }
        downloadResult();
    </script>
@endsection