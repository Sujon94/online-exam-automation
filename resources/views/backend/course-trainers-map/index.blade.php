@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Course Wise Trainer Map</h3>
            <hr>
            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate
                  @if(isset($course_id))
                  action="{{ route('course-trainers-map.update',['id'=>$course_id]) }}">
                @method('PUT')
                @else
                    action="{{route('course-trainers-map.store')}}">
                @endif
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label for="course_id" class="form-label required">Course Name</label>
                        <select class="form-control" name="course_id" required>
                            <option value="">Select Course</option>
                            @foreach($courseList as $value)
                                <option value="{{ $value->course_id  }}" {{ (old('course_id ',isset($course_id) ? $course_id  : '') == $value->course_id ) ? 'selected' : '' }}>{{ $value->course_name_en.' ('.$value->course_code.')' }}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select a course.
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="form-label required" for="trainer_id ">Trainer Name</label>
                        <select class="form-control" id="trainer_id" name="trainer_id[]" multiple required>
                            @foreach($trainerList as $value)
                                <option value="{{$value->trainer_id}}" {{isset($value->selected_val) && $value->selected_val=='selected' ?'selected' : ''}}>{{$value->name.' ('.$value->contact_no.')'}}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please select a trainer.
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="in_active" value="N"
                                {{ old('in_active',isset($insertedData) ? ($insertedData->active_yn == 'N' ? 'checked' : '') : '') }}>
                            <label class="form-check-label" for="in_active">In-Active</label>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 d-flex justify-content-end pt-1">
                        <button type="submit"
                                class="btn btn-success m-1">{{isset($course_id) ? 'Update' : 'Save'}}</button>
                        @if(isset($course_id))
                            <a href="{{route("course-trainers-map.index")}}" class="btn btn-info p-2 m-1">Cancel</a>
                        @endif

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4>Course Wise Trainer List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="course_wise_trainer_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th width="2%">SL</th>
                        <th width="40%">Title</th>
                        <th width="50%">No of Post</th>
                        <th width="8%">Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script type="text/javascript">
        $(document).ready(function () {


            $(document).on('submit','.removeCircular', function (e) {
                e.preventDefault();
                let selector = this;

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
                        selector.submit();
                    }
                })
            });

            let courseWiseTrainerTable = $('#course_wise_trainer_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/course-trainers-map-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#course_wise_trainer_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course_name"},
                    {"data": "trainers"},
                    {"data": "action"}
                ]
            });


            $("#trainer_id").select2({
                placeholder: "Select Trainer"
            });
        });
    </script>
@endsection
