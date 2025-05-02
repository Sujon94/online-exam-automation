@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                Master Page UI setup
            </div>
            <h4>Selected Courses</h4>
            <hr>
            <div class="row" id="courseCard">
                @foreach($courses as $course)
                    @if($course->master_yn == 'Y')
                    <div class="card bg-success bg-opacity-75 p-2 m-1" id="course{{$course->course_id}}"
                         style="width: 15rem">
                        <div class="card-body shadow-lg rounded">
                            <span style="text-align: justify; color: white"><i class="bx bx-check-circle"></i> {{$course->course_code.' - '.$course->course_name_en}} </span>
                            <div type="button" data-id="{{$course->course_id}}"
                                 class="card-footer mt-1 d-flex justify-content-center bg-warning removeCourse">
                                <i class="bx bx-trash"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <br>
            <h4>Course List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="course_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Course Type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var courseTable = $('#course_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/course-list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#course_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course_name_en"},
                    {"data": "course_code"},
                    {"data": "course_type"},
                    {"data": "action"}
                ]
            });
            $(document).on('click', '.courseCheck', function () {
                if ($(this).is(':checked')) {
                    checkUncheckCourse($(this).data('id'), true);
                } else {
                    checkUncheckCourse($(this).data('id'), false);
                }
            })
            $(document).on('click', '.removeCourse', function () {
                checkUncheckCourse($(this).data('id'), false);
            })

            function checkUncheckCourse(courseId, status) {
                let request = $.ajax({
                    url: '{{route('course-ui.course-check-uncheck')}}',
                    type: 'POST',
                    data: {courseId, status},
                    headers: {
                        'x-csrf-token': '{{csrf_token()}}'
                    }
                });

                request.done(function (d) {
                    if (d.code == '1') {
                        if (status == true) {
                            let item = $('<div class="card bg-success bg-opacity-75 p-2 m-1" id="course' + courseId + '" style="width: 15rem">' +
                                '<div class="card-body shadow-lg rounded">' +
                                '<span style="text-align: justify; color: white"><i class="bx bx-check-circle"></i> ' + d.data.course_name + ' </span>' +
                                '<div type="button" data-id="' + courseId + '" class="card-footer mt-1 d-flex justify-content-center bg-warning removeCourse">' +
                                '<i class="bx bx-trash"></i>' +
                                '</div>' +
                                '</div>' +
                                '</div>').hide();
                            $('#courseCard').append(item);
                            item.fadeIn(2000);
                            $.notify('Course added', 'success');
                        } else {
                            $("#course" + courseId).fadeOut(2000,function (){
                                $("#course" + courseId).remove();
                            });
                            $.notify('Course removed', 'success');
                            $('#course_table').DataTable().ajax.reload();

                        }
                    }
                });
            }
        });
    </script>
@endsection