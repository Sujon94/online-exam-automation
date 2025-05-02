<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:২১ PM
 */
?>
@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Batch Schedule Setup</h3>
            <hr>
            <form method="post" class="needs-validation repeater" enctype="multipart/form-data" novalidate
                  @if(isset($insertedData))
                  action="{{ route('batch-schedule.update',['id'=>$insertedData->batch_id]) }}">
                @method('PUT')
                @else
                    action="{{route('batch-schedule.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course" class="form-label required">Course</label>
                            <select class="form-control" name="course" id="course" required>
                                <option value="">Select Course</option>
                                @foreach($course as $c)
                                    <option value="{{ $c->course_id }}" {{ (old('course',isset($insertedData) ? $insertedData->course_id : '') == $c->course_id) ? 'selected' : '' }}>{{ $c->course_name_en }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a course.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 make-readonly">
                            <label for="batch" class="form-label required">Batch</label>
                            <select readonly="" class="form-control" name="batch" id="batch" required>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please set a batch.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="mb-3">
                            <label for="schedule" class="form-label required">Schedule</label>
                            <div class="col-md-12">
                                <table class="table table-sm table-hover table-bordered " id="schedule_table">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Start Time</th>
                                        <th class="text-center">End Time</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-group" id="date0">
                                                <input name="date[]" type="text" class="form-control"
                                                       placeholder="DD-MM-YYYY" autocomplete="off"
                                                       value="{{ old('payment_deadline',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->payment_deadline) : '') }}"
                                                       data-date-format="dd-mm-yyyy"
                                                       data-date-container='#date0'
                                                       data-provide="datepicker"
                                                       data-date-autoclose="true">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" id="timepicker-input-group3">
                                                <input id="start_time" name="start_time[]" type="time" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group" id="timepicker-input-group3">
                                                <input id="end_time" name="end_time[]" type="time" class="form-control">
                                            </div>
                                            <input type="hidden" name="schedule_action[]" class="schedule_action" value="A">
                                        </td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-success mt-3 mt-lg-0"
                                        onclick="addRow(this)"><i class="bx bx-xs bx-plus-circle"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary my-4 mx-2 submitBtn" type="submit">@isset($insertedData)  Update @else
                                    Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('batch-schedule.index')}}" class="btn btn-info my-4">Cancel</a>
                            @endisset
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Batch List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable" style="width: 100%"
                       id="batch_schedule_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Course Name</th>
                        <th>Batch Name</th>
                        <th>Date</th>
                        <th>Start time</th>
                        <th>End time</th>
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

        let addRow;
        let removeRow;
        $(document).ready(function () {
            $("#course").on('change', function () {
                let course = $("#course :selected").val();
                $("#batch").html('');
                if (course != "") {
                    let request = $.ajax({
                        url: APP_URL + "/backend/ajax/batch-of-a-course/" + course,
                        type: "get",
                    });

                    request.done(function (res) {
                        if (!$.isEmptyObject(res)) {
                            $('#batch').html("<option value='" + res.batch_id + "'>" + res.batch_name_en + "</option>");
                            if (res.batch_type == '{{\App\Enums\LBatchType::LONG_TERM}}')
                            {
                                $("#batch").notify('This is long term batch. Can\'t set schedule','warn');
                                $(".submitBtn").attr('disabled','disabled');
                            }else{
                                $(".submitBtn").removeAttr('disabled');
                            }
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        console.log(jqXHR);
                    });
                }

            });


            addRow = function (selector) {
                // let count = $("#c_account_table >tbody").children("tr").length;

                let html = '<tr>\n' +
                    '<td>\n' +
                    '                                            <div class="input-group" id="date0">\n' +
                    '                                                <input name="date[]" type="text" class="form-control"\n' +
                    '                                                       placeholder="DD-MM-YYYY" autocomplete="off"\n' +
                    '                                                       data-date-format="dd-mm-yyyy"\n' +
                    '                                                       data-date-container=\'#date0\'\n' +
                    '                                                       data-provide="datepicker"\n' +
                    '                                                       data-date-autoclose="true">\n' +
                    '                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>\n' +
                    '                                            </div>\n' +
                    '                                        </td>' +
                    '<td>\n' +
                    '                                            <div class="input-group" id="timepicker-input-group3">\n' +
                    '                                                <input name="start_time[]" type="time" class="form-control">\n' +
                    '                                            </div>\n' +
                    '                                        </td>' +
                    '<td>\n' +
                    '                                            <div class="input-group" id="timepicker-input-group3">\n' +
                    '                                                <input name="end_time[]" type="time" class="form-control">\n' +
                    '                                            </div>\n' +
                    '<input type="hidden" name="schedule_action[]" class="schedule_action" value="A">' +
                    '                                        </td>' +
                    '     <td><a href="#" onclick="removeRow(this)"><i class="bx bx-trash pe-auto"></i></a></td>\n' +
                    '  </tr>';
                $("#schedule_table >tbody").append(html);

            }

            removeRow = function (select) {
                $(select).parent().parent('tr').find('.schedule_action').val('D');
                $(select).closest("tr").hide();
            }


            $(".remove_file").on('click', function () {
                let fileId = $(this).data('id');

                swal.fire({
                    text: 'Remove Confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            url: APP_URL + "/backend/batch-setup-file/" + fileId,
                            type: "DELETE",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token()}}'
                            }
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
                                Swal.fire({text: res.response_msg, type: 'error'});
                            }
                        });

                        request.fail(function (jqXHR, textStatus) {
                            console.log(jqXHR);
                        });
                    }
                })
            });

            let batchTable = $('#batch_schedule_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/batch-schedule-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course"},
                    {"data": "batch"},
                    {"data": "date"},
                    {"data": "start_time"},
                    {"data": "end_time"},
                    {"data": "action"}
                ]
            });
        });
    </script>

@endsection

