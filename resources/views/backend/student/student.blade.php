<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ১০:৩৫ AM
 */
?>
@extends('backend.layouts.default')

@section('title')

@endsection

@section('header-style')

@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Student List</h4><!---->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="profession">Profession Type</label>
                                <select name="profession" class="form-control profession"
                                        id="profession">
                                    @foreach($professionType as $type)
                                        <option value="{{$type->profession_type_id}}">{{$type->type_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-sm datatable table-bordered" id="studentTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL.</th>
                                <th>Student</th>
                                <th>Profession</th>
                                <th>Mobile</th>
                                <th>Interested Course</th>
                                <th>Address</th>
                                <th>Registered On</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <br> <br>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer-script')
    <script type="text/javascript" src="{{ asset("assets/js/scripts/notify.js") }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            studentList();
        });
        function studentList() {
            var studentTable = $('#studentTable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                pageLength: 5,
                bFilter: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/backend/student-datalist',
                    data: function (d) {
                        d.profession_type = $("#profession").val();
                    },
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'student', name: 'student'},
                    {data: 'profession', name: 'profession'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'interested_courses', name: 'interested_courses'},
                    {data: 'address', name: 'address'},
                    {data: 'date_time', name: 'date_time',render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }},
                    {data: 'action', name: 'action'},
                ],
                columnDefs: [
                    {targets: 6, type: 'date'},
                ]
            });

            $("#profession").on('change', function () {
                studentTable.draw();
            });
        }

        $("form[name='updateStatusForm']").on('submit', function (e) {
            e.preventDefault();

            let newStatus = $("#customer_status").val();
            let customerId = $("#customer_id").val();

            let status = (newStatus == 'H' ? "hold" : (newStatus == 'A' ? "active" : "inactive"));
            Swal.fire({
                title: "Are you sure want to " + status + " this customer?",
                text: "You won't be able to revert this!",
                type: "warning",
                html: "<textarea id='remark' required class='form-control required' placeholder='You must define the reason.'></textarea>",
                preConfirm: function () {
                    if ($("#remark").val() != "") {
                        return new Promise(function (response) {
                            response({remarks: $('#remark').val()});
                        });
                    } else {
                        Swal.showValidationMessage('Reason to ' + status + ' this customer is required.')
                    }
                },
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, " + status + " it!",
                confirmButtonClass: "btn btn-primary",
                cancelButtonClass: "btn btn-danger ml-1",
                buttonsStyling: !1
            }).then(function (e) {
                if (e.value || e.value.remarks) {
                    let remark = e.value.remarks;
                    $.ajax({
                        type: "POST",
                        url: "/electricity/ajax/change-customer-status",
                        data: {
                            remark: remark,
                            status_id: newStatus,
                            customer_id: customerId
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (data) {
                            if (data.success == true) {
                                if (newStatus == 'I') {

                                    $("form[name='updateStatusForm'] :input :button").prop("disabled", true);
                                    $("#updateStatusBtn").prop("disabled", true);
                                }

                                customerMeterList();
                                /*var table = $('.dataTable').DataTable();
                                table.ajax.reload(null, false);*/
                                Swal.fire(
                                    'Done!',
                                    data.message,
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Failed',
                                    data.message,
                                    'error'
                                )
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });

                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            });
        });

    </script>
@endsection

