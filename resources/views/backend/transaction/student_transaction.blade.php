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
                    <h4 class="card-title">Transaction List</h4><!---->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="transactionStatus">Filter transactions</label>
                                <select name="transactionStatus" class="form-control transactionStatus"
                                        id="transactionStatus">
                                    @foreach($transactionStatus as $status)
                                        <option value="{{$status->id}}">{{$status->status_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-sm datatable table-bordered" id="transactionTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>SL.</th>
                                <th>Student</th>
                                <th>Payment For</th>
                                <th>Event/Competition/Skill/Course</th>
                                <th>Batch Name</th>
                                <th>Amount</th>
                                <th>Payment Type</th>
                                <th>Transaction code</th>
                                <th>Transaction Date</th>
                                <th>Status</th>
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
{{--
    <script type="text/javascript" src="{{ asset("assets/js/scripts/notify.js") }}"></script>
--}}

    <script type="text/javascript">
        $(document).ready(function () {
            transactionList();
            sendEmail();
        });
        let transactionTable;

        function transactionList() {
            transactionTable = $('#transactionTable').DataTable({
                processing: true,
                serverSide: true,
                bDestroy: true,
                pageLength: 5,
                ordering: false,
                ajax: {
                    url: APP_URL + '/backend/student-transaction-datalist',
                    data: function (d) {
                        d.transaction_status = $("#transactionStatus").val();
                    },
                    'type': 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'student', name: 'student'},
                    {data: 'payment_for', name: 'payment_for'},
                    {data: 'course', name: 'course'},
                    {data: 'batch', name: 'batch'},
                    {data: 'amount', name: 'amount'},
                    {data: 'payment_type', name: 'payment_type'},
                    {data: 'transaction_code', name: 'transaction_code'},
                    {data: 'transaction_date', name: 'transaction_date',render: function(data) {
                            return moment(data).format('DD-MM-YYYY');
                        }},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ],
                columnDefs: [
                    {targets: 9, type: 'date'},
                ]
            });

            $(".transactionStatus").on('change', function () {
                transactionTable.draw();
            });
        }

        $(document).on('click', '.transAppRej', function () {
            let newStatus = $(this).data('status');
            let transactionId = $(this).data('transaction');

            let status = (newStatus == '1' ? "approve" : "reject");
            Swal.fire({
                title: "Are you sure want to " + status + " this transaction?",
                icon: "info",
                html: "<textarea id='remark' required class='form-control required' placeholder='You can provide a note.'></textarea>",
                preConfirm: function () {
                    /*if ($("#remark").val() != "") {*/
                    return new Promise(function (response) {
                        response({remarks: $('#remark').val()});
                    });
                    /*} else {
                        Swal.showValidationMessage('Reason to ' + status + ' this customer is required.')
                    }*/
                },
                showCancelButton: !0,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, " + status + " it!",
                confirmButtonClass: "btn btn-primary",
                cancelButtonClass: "btn btn-danger ml-1",
                buttonsStyling: !1
            }).then(function (e) {
                if (e.value) {
                    let remark = (nullEmptyUndefinedChecked(e.value.remarks) ? '' : e.value.remarks);

                    let request = $.ajax({
                        url: APP_URL + "/backend/ajax/change-transaction-status",
                        method: "POST",
                        data: {remark: remark, status: newStatus, transaction_id: transactionId},
                        dataType: "JSON",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    });

                    request.done(function (data) {
                        if (data.code == '1') {
                            Swal.fire(
                                'Done!',
                                data.message,
                                'success'
                            )
                            transactionTable.draw();
                        } else {
                            Swal.fire(
                                'Failed',
                                data.message,
                                'error'
                            )
                        }
                    });

                    request.fail(function (jqXHR, textStatus) {
                        console.log(jqXHR)
                    })

                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            });
        });
        function sendEmail() {
            $(document).on('click','.sendMail', function () {
                let transId = $(this).data('id');

                swal.fire({
                    text: 'Send email?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            'url':APP_URL+'/backend/send-confirmation-email/'+transId
                        });
                        request.done(function (res) {
                            if (res.response_code != "99") {
                                Swal.fire({
                                    icon: 'success',
                                    text: res.response_msg,
                                    showConfirmButton: false,
                                    timer: 2000,
                                    allowOutsideClick: false
                                });
                            } else {
                                Swal.fire({text: res.response_msg, icon: 'error'});
                            }
                        });

                        request.fail(function (xhr, status,error) {
                            let message = '';
                            if (status === 404) {
                                message = "Resource not found.";
                            } else if (status === 500) {
                                message = "Server error. Please contact the administrator.";
                            } else {
                                message = "An unexpected error occurred.";
                            }
                            Swal.fire({text: message, icon: 'error'});
                        });
                    }
                })

            })
        }
    </script>
@endsection

