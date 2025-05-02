@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Circular Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate
                  @if(isset($insertedData))
                  action="{{ route('circular-setup.update',['id'=>$insertedData->circular_id]) }}">
                @method('PUT')
                @else
                    action="{{route('circular-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label required">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title',isset($insertedData) ? $insertedData->title : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a title name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="no_of_post" class="form-label required">Post Quantity/Vacancy</label>
                            <input type="text" class="form-control" id="no_of_post" name="no_of_post" value="{{ old('no_of_post',isset($insertedData) ? $insertedData->no_of_post : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a post quantity/vacancy.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="circular_role" class="form-label required">Role/Position</label>
                            <input type="text" class="form-control" id="circular_role" name="circular_role" value="{{ old('circular_role',isset($insertedData) ? $insertedData->circular_role : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a role/position name.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="description" class="form-label required">Short Description</label>
                            <textarea class="form-control" rows="4" name="description" required
                                      id="description">{{ old('description',isset($insertedData) ? $insertedData->description : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a short description.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="circular_type_id" class="form-label required">Job Type</label>
                            <select class="form-control" name="circular_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($circularTypes as $value)
                                    <option value="{{ $value->circular_type_id }}" {{ (old('circular_type_id',isset($insertedData) ? $insertedData->circular_type_id  : '') == $value->circular_type_id ) ? 'selected' : '' }}>{{ $value->type_name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a type.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="circular_pay_type_id" class="form-label required">Payment Type</label>
                            <select class="form-control" name="circular_pay_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($circularPayTypes as $value)
                                    <option value="{{ $value->circular_pay_type_id  }}" {{ (old('circular_pay_type_id ',isset($insertedData) ? $insertedData->circular_pay_type_id  : '') == $value->circular_pay_type_id ) ? 'selected' : '' }}>{{ $value->pay_type_name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a type.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="location_id" class="form-label required">JOB Location</label>
                            <select class="form-control" name="location_id" required>
                                <option value="">Select Type</option>
                                @foreach($locations as $value)
                                    <option value="{{ $value->location_id }}" {{ (old('location_id',isset($insertedData) ? $insertedData->location_id : '') == $value->location_id) ? 'selected' : '' }}>{{ $value->name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a job location.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="text" class="form-control" id="salary" name="salary" value="{{ old('salary',isset($insertedData) ? $insertedData->salary : 'Negotiable') }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a salary.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="published_date" class="form-label">Published Date</label>
                            <div class="input-group" id="published_date">
                                <input name="published_date" type="text" class="form-control" autocomplete="off"
                                       placeholder="DD-MM-YYYY"
                                       value="{{ old('published_date',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->published_date) : '') }}"
                                       data-date-format="dd-mm-yyyy" data-date-container='#published_date'
                                       data-provide="datepicker"
                                       data-date-autoclose="true">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="application_deadline" class="form-label">Application Deadline</label>
                            <div class="input-group" id="application_deadline">
                                <input name="application_deadline" type="text" class="form-control" autocomplete="off"
                                       placeholder="DD-MM-YYYY"
                                       value="{{ old('application_deadline',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->application_deadline) : '') }}"
                                       data-date-format="dd-mm-yyyy" data-date-container='#application_deadline'
                                       data-provide="datepicker"
                                       data-date-autoclose="true">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="responsibilities" class="form-label required">Responsibilities</label>
                            <textarea class="form-control" rows="6" name="responsibilities" required
                                      id="responsibilities">{{ old('responsibilities',isset($insertedData) ? $insertedData->responsibilities : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a responsibilities.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qualifications" class="form-label required">Qualifications</label>
                            <textarea class="form-control" rows="6" name="qualifications" required
                                      id="qualifications">{{ old('qualifications',isset($insertedData) ? $insertedData->qualifications : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a qualifications.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label">Active</label>
                        <div class="mb-3">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" value="Y" name="active_yn" id="active_y" {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'Y') ? 'Checked' : '' }}
                                autocomplete="off"
                                       checked>
                                <label class="btn btn-outline-success" for="active_y">Yes</label>

                                <input type="radio" class="btn-check" value="N" name="active_yn" id="active_n" {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'N') ? 'Checked' : '' }}
                                autocomplete="off">
                                <label class="btn btn-outline-danger" for="active_n">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-start">
                            <button class="btn btn-primary my-4 mx-2" type="submit">@isset($insertedData)  Update @else Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('circular-setup.index')}}" class="btn btn-info my-4">Cancel</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Circular List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="circular_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                        <tr>
                            <th width="11%">SL</th>
                            <th width="25%">Title</th>
                            <th width="11%">No of Post</th>
                            <th width="11%">Deadline</th>
                            <th width="20%">Action</th>
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
            ClassicEditor
                .create(document.querySelector('#responsibilities'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#qualifications'))
                .catch(error => {
                    console.error(error);
                });

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

            let circularTable = $('#circular_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/circular-setup-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#circular_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "title"},
                    {"data": "no_of_post"},
                    {"data": "application_deadline"},
                    {"data": "action"}
                ]
            });
        });
    </script>
@endsection
