<?php
/**
 *Created by PhpStorm
 *Created at ২৮/১০/২১ ২:৩৩ PM
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
            <h4>Guest Message List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="new_message_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Message</th>
                        <th>Received On</th>
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
        //$(document).ready(function () {
            let messageTable = $('#new_message_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/new-message-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#new_message_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "message"},
                    {"data": "received_on"},
                    {"data": "action"}
                ]
            });
            function removeMessage(selector,messageId) {
                swal.fire({
                    html:"Confirm Remove?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let response = $.ajax({
                            url:'{{route("message.delete_message")}}',
                            type:'POST',
                            data:{id:messageId},
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            }
                        });
                        response.done(function (res) {
                            if (res.status_code=='1'){
                                //$("#new_message_table").dataTable().clear().draw();
                                messageTable.DataTable().draw();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Message is removed.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        });
                        response.fail(function () {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Something went wrong.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        });
                    }
                })
            }
        //});
    </script>

@endsection

