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
            <h3>Batch Setup</h3>
            <hr>
            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate
                  @if(isset($insertedData))
                  action="{{ route('batch-setup.update',['id'=>$insertedData->batch_id]) }}">
                @method('PUT')
                @else
                    action="{{route('batch-setup.store')}}">
                @endif
                @csrf
                <fieldset class=" p-2">
                    <legend class="w-50">Batch Information</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="course" class="form-label required">Course</label>
                                <select class="form-control" name="course" required>
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
                            <div class="mb-3">
                                <label for="batch_code" class="form-label">Batch Code</label>
                                <input type="text" class="form-control" id="batch_code" name="batch_code"
                                       value="{{ old('batch_code',isset($insertedData) ? $insertedData->batch_code : '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_name_en" class="form-label required">Batch Name (En)</label>
                                <input type="text" class="form-control" id="batch_name_en" name="batch_name_en"
                                       value="{{ old('batch_name_en',isset($insertedData) ? $insertedData->batch_name_en : '') }}"
                                       required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give a batch english name.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_name_bn" class="form-label">Batch Name (Bn)</label>
                                <input type="text" class="form-control" id="batch_name_bn" name="batch_name_bn"
                                       value="{{ old('batch_name_bn',isset($insertedData) ? $insertedData->batch_name_bn : '') }}">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give a batch bangla name.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="max_participant" class="form-label required">Max Allowed Participant</label>
                                <input type="number" class="form-control" id="max_participant" name="max_participant"
                                       required
                                       value="{{ old('max_participant',isset($insertedData) ? $insertedData->max_participant : '') }}">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give max participant.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="upcoming_yn" class="form-label">Upcoming Batch</label>
                                <div class="mb-3">
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check upcoming_yn" value="1" name="upcoming_yn" id="upcoming_y"
                                               {{ (old('upcoming_yn',isset($insertedData) ? $insertedData->batch_status : '') == '1') ? 'Checked' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-info" for="upcoming_y">Yes</label>

                                        <input type="radio" class="btn-check upcoming_yn" value="0" name="upcoming_yn" id="upcoming_n"
                                               {{ (old('upcoming_yn',isset($insertedData) ? $insertedData->batch_status : '') == '0') ? 'Checked' : '' }}
                                               autocomplete="off">
                                        <label class="btn btn-outline-dark" for="upcoming_n">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_duration" class="form-label required">Batch Duration</label>
                                <div class="input-daterange input-group" id="batch_duration"
                                     data-date-format="dd-mm-yyyy"
                                     data-date-autoclose="true"
                                     data-provide="datepicker"
                                     data-date-container='#batch_duration'>
                                    <input type="text" class="form-control" name="batch_start_date" autocomplete="off"
                                           id="batch_start_date"
                                           value="{{old('batch_start_date',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->batch_start_date) : '')}}"
                                           placeholder="Start Date" required/>

                                    <input type="text" class="form-control" name="batch_end_date" id="batch_end_date"
                                           autocomplete="off"
                                           value="{{old('batch_end_date',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->batch_end_date) : '')}}"
                                           placeholder="End Date" required/>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please give batch duration.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                            <div class="form-label" for="batch_type">Batch Type</div>
                                <select class="form-control" name="batch_type" id="batch_type">
                                @foreach(\App\Entities\backend\lookup\LBatchType::all() as $type)
                                    <option {{ (old('batch_type',isset($insertedData) ? $insertedData->batch_type : '') == $type->id) ? 'selected' : '' }} value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="col-md {{isset($insertedData) ? ($insertedData->batch_type == \App\Enums\LBatchType::LONG_TERM) ? '' : 'd-none' : 'd-none'}} total_schedules">
                            <div class="mb-3">
                                <div class="form-label total_schedules_label" for="total_schedules">Total Month</div>
                                <input class="form-control" name="total_schedules" min="0" id="total_schedules" type="number" value="{{old('total_schedules',isset($insertedData) ? $insertedData->total_batch_schedules : 0)}}"/>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="mb-3">
                                <label class="form-label">Course Completed</label>
                                <input class="form-control" type="number" min="0" name="total_participants" value="{{old('total_participants',isset($insertedData) ? $insertedData->total_participants : 0)}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <div class="mb-3">
                                <label class="form-label">Class Duration(Static)</label>
                                <input class="form-control" type="text"  name="class_duration" value="{{old('class_duration',isset($insertedData) ? $insertedData->class_duration : '')}}">
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="mb-3">
                                <label class="form-label">Class Schedule(Static)</label>
                                <input class="form-control" type="text"  name="class_schedule" value="{{old('class_schedule',isset($insertedData) ? $insertedData->class_schedule : '')}}">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="border p-2 mt-2">
                    <legend class="w-50">Batch Fee</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fee_amount" class="form-label required">Course Fee</label>
                                <input type="number" class="form-control" id="fee_amount" name="fee_amount" required
                                       value="{{ old('fee_amount',isset($insertedData) ? $insertedData->fee_amount : '') }}">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give valid amount.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_process_type_id" class="form-label">Payment Process</label>
                                <select class="form-control" name="payment_process_type_id">
                                    <option value="">Select Payment Type</option>
                                    @foreach($paymentType as $t)
                                        <option value="{{ $t->payment_type_id }}" {{ (old('payment_process_type_id',isset($insertedData) ? $insertedData->payment_process_type_id : '') == $t->payment_type_id) ? 'selected' : '' }}>{{ $t->process_name }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please select a payment type.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_process_en" class="form-label">Payment Process Describe (En)</label>
                                <textarea class="form-control" rows="6" name="payment_process_en"
                                          id="payment_process_en">{{ old('payment_process_desc_en',isset($insertedData) ? $insertedData->payment_process_desc_en : '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_process_bn" class="form-label">Payment Process Describe (Bn)</label>
                                <textarea class="form-control" rows="6" name="payment_process_bn"
                                          id="payment_process_bn">{{ old('payment_process_bn',isset($insertedData) ? $insertedData->payment_process_desc_bn : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="payment_deadline" class="form-label">Payment Last Date</label>
                                <div class="input-group" id="payment_deadline">
                                    <input name="payment_deadline" type="text" class="form-control" autocomplete="off"
                                           placeholder="DD-MM-YYYY"
                                           value="{{ old('payment_deadline',isset($insertedData) ? \App\Helpers\HelperClass::dateConvert($insertedData->payment_deadline) : '') }}"
                                           data-date-format="dd-mm-yyyy" data-date-container='#payment_deadline'
                                           data-provide="datepicker"
                                           data-date-autoclose="true">
                                    <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_image" class="form-label required">Social Image (Allowed dimension: 1200x630)</label>
                                <div class="input-group" id="social_image">
                                    <input name="social_image" type="file" {{ isset($insertedData) ? (isset($insertedData->batch_file) ? "" : "required" ) : "required"  }} class="form-control" accept="image/*">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please upload a social image.
                                    </div>
                                </div>
                                @error('social_image')
                                <div class="error">{{ $message }}</div>
                                @enderror

                                <br>
                                @if(isset($insertedData))
                                    @if (isset($insertedData->batch_file))
                                        <p>File Name: {{$insertedData->batch_file->social_file_name}} (<a
                                                    href="{{route('batch-setup.file-download',['id'=>$insertedData->batch_file->self_development_file_id, 'type'=>\App\Enums\ImageType::PATH])}}"><i
                                                        class="bx bx-download"></i></a>)
                                        <!--                                                (<a href="#"
                                                                                                class="remove_file pe-auto"
                                                                                                style="color:red"
                                                                                                data-id="{{$insertedData->batch_file->self_development_file_id}}"><i
                                                            class="bx bx-trash"></i></a>)-->
                                        </p>
                                    @endif
                                @endisset
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="batch_image" class="form-label required">Batch Image (Allowed dimension: 1200x400)</label>
                                <div class="input-group" id="batch_image">
                                    <input {{ isset($insertedData) ? (isset($insertedData->batch_file) ? "" : "required" ) : "required"  }} name="batch_image" type="file" class="form-control" accept="image/*">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please upload a batch image.
                                    </div>
                                </div>
                                @error('batch_image')
                                <div class="error">{{ $message }}</div>
                                @enderror

                                <br>
                                @if(isset($insertedData))
                                    @if (isset($insertedData->batch_file))
                                        <p>File Name: {{$insertedData->batch_file->doc_file_name}} (<a
                                                    href="{{route('batch-setup.file-download',['id'=>$insertedData->batch_file->self_development_file_id])}}"><i
                                                        class="bx bx-download"></i></a>)
                                        <!--                                            (<a href="#"
                                                                                            class="remove_file pe-auto"
                                                                                            style="color:red"
                                                                                            data-id="{{$insertedData->batch_file->self_development_file_id}}"><i
                                                        class="bx bx-trash"></i></a>)-->
                                        </p>
                                    @endif
                                @endisset
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="doc_img_alt_tag" class="form-label ">Batch Image Alt Tag</label>
                                <input type="text" class="form-control" id="doc_img_alt_tag" name="doc_img_alt_tag"
                                       value="{{ old('doc_img_alt_tag',isset($insertedData->batch_file) ? $insertedData->batch_file->doc_img_alt_tag : '') }}">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give batch image alt tag.
                                </div>
                            </div>
                        </div>
                    </div>

                </fieldset>
                <div class="row">
                    {{--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="upcoming_batch" class="form-label">Upcoming Batch</label>
                            <input type="text" class="form-control" id="upcoming_batch" name="upcoming_batch"
                                   value="{{ old('upcoming_batch',isset($insertedData) ? $insertedData->upcoming_batch : '') }}">
                        </div>
                    </div>--}}
                    <div class="col-md-2">
                        <label for="" class="form-label">Active</label>
                        <div class="mb-3">
                            <div class="btn-group active_area" role="group">
                                <input type="radio" class="btn-check" value="Y" name="active_yn" id="active_y"
                                       {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'Y') ? 'Checked' : '' }}
                                       autocomplete="off"
                                       checked>
                                <label class="btn btn-outline-success" for="active_y">Yes</label>

                                <input type="radio" class="btn-check" value="N" name="active_yn" id="active_n"
                                       {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'N') ? 'Checked' : '' }}
                                       autocomplete="off">
                                <label class="btn btn-outline-danger" for="active_n">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="">
                            <button class="btn btn-primary my-4 mx-2" type="submit">@isset($insertedData)  Update @else
                                    Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('batch-setup.index')}}" class="btn btn-info my-4">Cancel</a>
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
                <table class="table table-bordered table-sm dataTable"
                       id="batch_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Course Name</th>
                        <th>Batch Code</th>
                        <th>Batch Name</th>
                        <th>Batch Start</th>
                        <th>Batch End</th>
                        <th>Max Participant</th>
                        <th>Status</th>
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

            ClassicEditor
                .create(document.querySelector('#payment_process_en'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#payment_process_bn'))
                .catch(error => {
                    console.error(error);
                });
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

            let batchTable = $('#batch_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/batch-setup-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#invoiceBillSearch').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course"},
                    {"data": "batch_code"},
                    {"data": "batch_name_en"},
                    {"data": "batch_start_date"},
                    {"data": "batch_end_date"},
                    {"data": "max_participant"},
                    {"data": "status"},
                    {"data": "action"}
                ]
            });


            enableDisableDateRange();
            $('.upcoming_yn').on('change', function () {
                enableDisableDateRange();
            });

            function enableDisableDateRange() {
                if ($('.upcoming_yn').prop('checked')) {  //If it is an upcoming batch
                    $("#batch_duration").removeClass("input-daterange");
                    $("#batch_duration").addClass("make-readonly");
                    $("#batch_duration").removeAttr("data-provide", "datepicker");
                    $("#batch_duration").children('input[type=text]').val('').attr('readonly', 'readonly');

                    //Upcoming batch can't active
                    /*$("#active_y").prop('checked',false);
                    $("#active_n").prop('checked',true);
                    $(".active_area").addClass('make-readonly');*/

                } else {
                    $("#batch_duration").addClass("input-daterange");
                    $("#batch_duration").removeClass("make-readonly");
                    $("#batch_duration").attr("data-provide", "datepicker");
                    $("#batch_duration").children('input[type=text]').removeAttr('readonly');


                    //$(".active_area").removeClass('make-readonly');
                }
            }

            $(document).on('submit', '.removeBatch', function (e) {
                e.preventDefault();
                let selector = this;
                let transactions = $(this).find('.Batchtrans').val();
                let warnMessage = "";

                if (transactions > 0) {
                    warnMessage = "<span class='text-danger'>This batch has " + transactions + " transactions. By removing the batch all the transactions will be lost permanently.</span><br><a style='text-decoration: underline;' href='{{route("student-transaction.index")}}'>Click here</a> to go to the transaction page.<br>";
                }
                swal.fire({
                    html: warnMessage + "Confirm Remove?",
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
            $("#batch_type").on('change', function () {
                if ($(this).val() == '{{\App\Enums\LBatchType::LONG_TERM}}') {
                    $(".total_schedules").removeClass('d-none');
                    $("#total_schedules").attr('required', 'required');
                    $(".total_schedules_label").addClass('required');
                } else {
                    $(".total_schedules").addClass('d-none');
                    $("#total_schedules").removeAttr('required');
                    $(".total_schedules_label").removeClass('required');
                }
            });
        });

    </script>

@endsection

