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
            <h4>Selected Services</h4>
            <hr>
            <div class="row" id="serviceCard">
                @foreach($services as $service)
                    @if($service->master_yn == 'Y')
                    <div class="card bg-info bg-opacity-75 p-2 m-1" id="service{{$service->post_id}}"
                         style="width: 15rem">
                        <div class="card-body shadow-lg rounded">
                            <span style="text-align: justify; color: white"><i class="bx bx-check-circle"></i> {{$service->title}} </span>
                            <div type="button" data-id="{{$service->post_id}}"
                                 class="card-footer mt-1 d-flex justify-content-center bg-success bg-opacity-75 removeService">
                                <i class="bx bx-trash"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <br>
            <h4>Service List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="service_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Service</th>
                        <th>Category</th>
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
            var serviceTable = $('#service_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/service-list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#service_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "title"},
                    {"data": "category"},
                    {"data": "action"}
                ]
            });
            $(document).on('click', '.serviceCheck', function () {
                if ($(this).is(':checked')) {
                    checkUncheckService($(this).data('id'), true);
                } else {
                    checkUncheckService($(this).data('id'), false);
                }
            })
            $(document).on('click', '.removeService', function () {
                checkUncheckService($(this).data('id'), false);
            })

            function checkUncheckService(serviceId, status) {
                let request = $.ajax({
                    url: '{{route('service-ui.service-check-uncheck')}}',
                    type: 'POST',
                    data: {serviceId, status},
                    headers: {
                        'x-csrf-token': '{{csrf_token()}}'
                    }
                });

                request.done(function (d) {
                    if (d.code == '1') {
                        if (status == true) {
                            let item = $('<div class="card bg-info bg-opacity-75 p-2 m-1" id="service' + serviceId + '" style="width: 15rem">' +
                                '<div class="card-body shadow-lg rounded">' +
                                '<span style="text-align: justify; color: white"><i class="bx bx-check-circle"></i> ' + d.data.service_name + ' </span>' +
                                '<div type="button" data-id="' + serviceId + '" class="card-footer mt-1 d-flex justify-content-center bg-success removeService">' +
                                '<i class="bx bx-trash"></i>' +
                                '</div>' +
                                '</div>' +
                                '</div>').hide();
                            $('#serviceCard').append(item);
                            item.fadeIn(2000);
                            $.notify('Service added', 'success');
                        } else {
                            $("#service" + serviceId).fadeOut(2000,function (){
                                $("#service" + serviceId).remove();
                            });
                            $.notify('Service removed', 'success');
                            $('#service_table').DataTable().ajax.reload();

                        }
                    }
                });
            }
        });
    </script>
@endsection