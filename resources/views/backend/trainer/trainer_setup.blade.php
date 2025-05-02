@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Trainer Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate
                @if(isset($insertedData))
                  action="{{ route('trainer-setup.update',['id'=>$insertedData->trainer_id]) }}">
                @method('PUT')
                @else
                    action="{{route('trainer-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name',isset($insertedData) ? $insertedData->name : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date Of Birth</label>
                            <div class="input-group" id="dob">
                                <input name="dob" type="text" class="form-control" autocomplete="off"
                                       placeholder="DD-MM-YYYY"
                                       value="{{ old('dob',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->dob) : '') }}"
                                       data-date-format="dd-mm-yyyy" data-date-container='#dob'
                                       data-provide="datepicker"
                                       data-date-autoclose="true">
                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a Date Of Birth.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nid" class="form-label required">NID</label>
                            <input type="text" class="form-control" id="nid" name="nid" value="{{ old('nid',isset($insertedData) ? $insertedData->nid : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a NID.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label required">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email',isset($insertedData) ? $insertedData->email : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a email.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_no" class="form-label required">Contact No</label>
                            <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ old('contact_no',isset($insertedData) ? $insertedData->contact_no : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a Contact No.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="alt_contact_no" class="form-label required">Alternative Contact No</label>
                            <input type="text" class="form-control" id="alt_contact_no" name="alt_contact_no" value="{{ old('alt_contact_no',isset($insertedData) ? $insertedData->alt_contact_no : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a alternative contact no.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="religion_id" class="form-label required">Religion</label>
                            <select class="form-control" name="religion_id" id="religion_id" required>
                                <option value="">Select Religion</option>
                                @foreach($lReligion as $value)
                                    <option value="{{ $value->religion_id }}" {{ (old('religion_id',isset($insertedData) ? $insertedData->religion_id  : '') == $value->religion_id ) ? 'selected' : '' }}>{{ $value->religion_name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a religion.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gender_id" class="form-label required">Gender</label>
                            <select class="form-control" name="gender_id" id="gender_id" required>
                                <option value="">Select Gender</option>
                                @foreach($lGender as $value)
                                    <option value="{{ $value->gender_id  }}" {{ (old('gender_id',isset($insertedData) ? $insertedData->gender_id  : '') == $value->gender_id ) ? 'selected' : '' }}>{{ $value->gender_name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please select a gender.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="about_trainer" class="form-label required">About Trainer</label>
                            <textarea class="form-control" rows="6" name="about_trainer" required
                                      id="about_trainer">{{ old('about_trainer',isset($insertedData) ? $insertedData->about_trainer : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give about trainer.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="academic_background" class="form-label required">Academic Background</label>
                            <textarea class="form-control" rows="6" name="academic_background" required
                                      id="academic_background">{{ old('academic_background',isset($insertedData) ? $insertedData->academic_background : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give academic background.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="present_address" class="form-label required">Present Address</label>
                            <textarea class="form-control" rows="6" name="present_address" required
                                      id="present_address">{{ old('present_address',isset($insertedData) ? $insertedData->present_address : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give present address.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="permanent_address" class="form-label required">Permanent Address</label>
                            <textarea class="form-control" rows="6" name="permanent_address" required
                                      id="permanent_address">{{ old('permanent_address',isset($insertedData) ? $insertedData->permanent_address : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give permanent address.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="experiences" class="form-label required">Experiences</label>
                            <textarea class="form-control" rows="6" name="experiences" required
                                      id="experiences">{{ old('experiences',isset($insertedData) ? $insertedData->experiences : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give experiences.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="current_position" class="form-label required">Current Position</label>
                            <input type="text" class="form-control" id="current_position" name="current_position" value="{{ old('current_position',isset($insertedData) ? $insertedData->current_position : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a current position.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nationality" class="form-label required">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" value="{{ old('nationality',isset($insertedData) ? $insertedData->nationality : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a nationality.
                            </div>
                        </div>
                    </div>
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
                    <div class="col-md-2">
                        <div class="d-flex justify-content-start">
                            <button class="btn btn-primary my-4 mx-2" type="submit">@isset($insertedData)  Update @else Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('trainer-setup.index')}}" class="btn btn-info my-4">Cancel</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Trainer List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="circular_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                        <tr>
                            <th width="10%">SL</th>
                            <th width="25%">Name</th>
                            <th width="15%">DOB</th>
                            <th width="15%">Email</th>
                            <th width="15%">Contact No</th>
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
                .create(document.querySelector('#about_trainer'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#academic_background'))
                .catch(error => {
                    console.error(error);
                });
            ClassicEditor
                .create(document.querySelector('#experiences'))
                .catch(error => {
                    console.error(error);
                });

            $(document).on('submit','.removeTrainer', function (e) {
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
                    url: APP_URL + '/backend/trainer-setup-datalist',
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
                    {"data": "name"},
                    {"data": "dob"},
                    {"data": "email"},
                    {"data": "contact_no"},
                    {"data": "action"}
                ]
            });
        });
    </script>
@endsection
