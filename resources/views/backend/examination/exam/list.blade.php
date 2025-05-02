@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-header bg-white">
            <i class="fa fa-table"></i> List of exams
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="examType">Filter Exam</label>
                        <select name="exam_ype" class="form-control"
                                id="examType">
                            @foreach($examTypes as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <table id="examTable" class="dataTable display table table-stripped table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
<!--                    <th>Type</th>-->
                    <th>Subject</th>
                    <th>Start Date</th>
                    <th>Duration</th>
                    <th>Total questions</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
<!--                    <th>Type</th>-->
                    <th>Subject</th>
                    <th>Start Date</th>
                    <th>Duration</th>
                    <th>Total questions</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("footer-script")
    <script type="text/javascript">
        let examTable;
        $(document).ready(function () {
            examTable = $("#examTable").DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: '{{route("exam.lists")}}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (d) {
                        d.examType= $("#examType :selected").val()
                    }
                },
                columns: [
                    {"data": "DT_RowIndex", "name": "DT_RowIndex"},
                    {"data": "exam_name"},
                    /*{"data": "type"},*/
                    {"data": "subject"},
                    {"data": "start_date"},
                    {"data": "duration"},
                    {"data": "total_question","class":"text-center"},
                    {"data": "price"},
                    {"data": "status"},
                    {"data": "action" ,"class":"text-center"}
                ]
            });

            $('#examType').on('change',function () {
                examTable.draw();
            })

            $(document).on('change','.updateStatus',function () {
                let obj = $(this);
                let examId = obj.data('e');
                let status = obj.find(':selected').val();

                swal.fire({
                    text: 'Change Status Confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            url: '{{route('exam.status-update')}}',
                            data:{examId,status}
                        });

                        request.done(function (res) {
                            if (res.response_code == '1') {
                                Swal.fire({
                                    icon: 'success',
                                    text: res.response_msg,
                                    showConfirmButton: false,
                                    timer: 2000,
                                    allowOutsideClick: false
                                });
                                examTable.draw();
                            } else {
                                Swal.fire({text: res.response_msg, icon: 'info'});
                                obj.val(obj.data('d'));
                            }
                        });

                        request.fail(function (jqXHR, textStatus) {
                            console.log(jqXHR);
                        });
                    }else{
                        obj.val(obj.data('d'));
                    }
                })
            })
        })

    </script>
@endsection