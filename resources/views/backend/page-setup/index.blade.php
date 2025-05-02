<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১০:৫৩ AM
 */
?>
@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
    <style>
        .make-readonly-bg {
            pointer-events: none;
            touch-action: none;
            background-color: #F2F4F4;
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Page Content Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data"
                  @if(isset($insertedData))
                  action="{{ route('page-setup.update',['id'=>$insertedData->id]) }}">
                @method('PUT')
                @else
                    action="{{route('page-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="page_id_lbl" class="form-label">Setup For <span id="required_span" style="color: red;">(required)</span></label>
                        <select class="form-control @if(isset($insertedData)) make-readonly-bg @endif" name="page_id"
                                id="page_id" required>
                            <option value="">Select Page</option>
                            @foreach($setupPages as $values)
                                <option value="{{ $values->page_id }}" {{ (old('course_type',isset($insertedData) ? $insertedData->page_id : '') == $values->page_id) ? 'selected' : '' }}>{{ $values->page_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="category_for" class="form-label">Content <span id="required_span" style="color: red;">(required)</span></label>
                        <select class="form-control @if(isset($insertedData)) make-readonly-bg @endif" name="content_id"
                                id="content_id" required>
                            <option value="">Select Content</option>
                            @if(isset($insertedData))
                                @foreach($pageContent as $values)
                                    <option value="{{ $values->content_id }}" {{ (old('course_type',isset($insertedData) ? $insertedData->content_id : '') == $values->content_id) ? 'selected' : '' }}>{{ $values->content_name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="name" class="form-label">Content Title <span id="required_span" style="color: red;">(required)</span></label>
                        <input type="text" class="form-control" id="content_title" name="content_title"
                               autocomplete="off"
                               value="{{ old('name',isset($insertedData) ? $insertedData->content_title : '') }}"
                        >
                    </div>
                    <div class="col-md-3">
                        <label for="name" class="form-label">Content Serial <span id="required_span" style="color: red;">(required)</span></label>
                        <select name="content_serial" id="content_serial" class="form-control @if(isset($insertedData)) make-readonly-bg @endif">
                            @foreach (range(1, 15) as $number)
                                <option value="{{ $number }}" {{ (old('course_type',isset($insertedData) ? $insertedData->content_serial : '') == $number) ? 'selected' : '' }}>{{ $number }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="name" class="form-label">Content <span id="required_span_content" style="color: red;" hidden>(required)</span></label>
                        <textarea class="form-control h-auto content" rows="3" style="margin-top: 5px"
                                  id="content"
                                  name="content">{{ old('content',isset($insertedData) ? $insertedData->content : '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="name" class="form-label">Link <span id="required_span_link" style="color: red;" hidden>(required)</span></label>
                            <div class="input-group">
                            <input type="text" class="form-control" id="link" name="link"
                                   autocomplete="off"
                                   value="{{ old('icon',isset($insertedData) ? $insertedData->link : '') }}"
                            >
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="course_image" class="form-label">Image <span id="required_span_img" style="color: red;" hidden>(required)</span></label>
                                <div class="input-group" id="course_image">
                                    <input name="course_thumbnail" type="file" class="form-control"
                                           {{--{{ isset($insertedData) ? (isset($insertedData->course_file) ? "" : "required" ) : "required"  }}--}}
                                           accept="image/*">
                                    {{--<div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please upload an image.
                                    </div>--}}
                                </div>

                                <div class="error" id="show_dimen_div" style="color: red;">Please add an image of <span id="show_dimen_span"></span> dimension.</div>

                                <br>
                                @if(isset($insertedData))
                                    @if(isset($insertedData->doc_file_name))
                                        <p>File Name: {{$insertedData->doc_file_name}}
                                            (<a href="{{route('page-setup.file-download',['id'=>$insertedData->self_development_file_id, 'fileCode'=>\App\Enums\DocFileCode::C_THUMBNAIL])}}">
                                                <i class="bx bx-download"></i>
                                            </a>)
                                            (<a href="#"
                                                class="remove_file pe-auto"
                                                style="color:red"
                                                data-id="{{$insertedData->self_development_file_id}}"><i
                                                        class="bx bx-trash"></i></a>)
                                        </p>
                                    @endisset
                                @endisset
                            </div>
                        </div>
                        <div class="row">
                            <label for="" class="form-label">Active <span id="required_span" style="color: red;">(required)</span></label>
                            <div class="mb-3">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" value="{{\App\Enums\PageContentStatus::ACTIVE}}"
                                           name="active_yn" id="active_y"
                                           {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == \App\Enums\PostCategoryStatus::ACTIVE) ? 'Checked' : '' }}
                                           autocomplete="off"
                                           checked>
                                    <label class="btn btn-outline-success" for="active_y">Yes</label>

                                    <input type="radio" class="btn-check"
                                           value="{{\App\Enums\PageContentStatus::INACTIVE}}" name="active_yn"
                                           id="active_n"
                                           {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == \App\Enums\PostCategoryStatus::INACTIVE) ? 'Checked' : '' }}
                                           autocomplete="off">
                                    <label class="btn btn-outline-danger" for="active_n">No</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <label for="name" class="form-label">Icon <span id="required_span_icon" style="color: red;" hidden>(required)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="icon" name="icon"
                                       autocomplete="off"
                                       value="{{ old('icon',isset($insertedData) ? $insertedData->icon : '') }}"
                                >
                            </div>
                        </div>
                        <div class="row">
                            <label for="name" class="form-label">Extra Field - 2 <span id="required_span_extra2" style="color: red;" hidden>(required)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="extra_field_2" name="extra_field_2"
                                       autocomplete="off"
                                       value="{{ old('extra_field_1',isset($insertedData) ? $insertedData->extra_field_2 : '') }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label for="name" class="form-label">Extra Field - 1 <span id="required_span_extra1" style="color: red;" hidden>(required)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="extra_field_1" name="extra_field_1"
                                       autocomplete="off"
                                       value="{{ old('extra_field_1',isset($insertedData) ? $insertedData->extra_field_1 : '') }}"
                                >
                            </div>
                        </div>
                        <div class="row">
                            <label for="name" class="form-label">Extra Field - 3 <span id="required_span_extra3" style="color: red;" hidden>(required)</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="extra_field_3" name="extra_field_3"
                                       autocomplete="off"
                                       value="{{ old('extra_field_1',isset($insertedData) ? $insertedData->extra_field_3 : '') }}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <button id="form_submit_btn" class="btn btn-primary my-4 mx-2"
                                    type="submit">@if(isset($insertedData))  Update @else
                                    Save @endif</button>
                            @isset($insertedData)
                                <a href="{{route('page-setup.index')}}" class="btn btn-info my-4">Cancel</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Page Content List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="pageSetupTable">
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Page</th>
                        <th>Content</th>
                        <th>Content Title</th>
                        <th>Serial</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')
    <script>
        $('#course_image').on('change', function(e){
            var file = e.target.files[0];
            if(file){
                let reader = new FileReader();
                reader.onload = function(e){
                    var img = new Image();
                    img.onload = function(){
                        let width = this.width;
                        let height = this.height;

                        $.ajax({
                            type: 'get',
                            url: '/backend/image-dimension-chk',
                            data: {width: height, height:width, page_id: $("#page_id").val(), content_id: $("#content_id").val()},
                            success: function (msg) {
                                let sd = msg.split('+');
                                if(sd[0]==0){
                                    $("#form_submit_btn").prop('disabled', true);
                                    Swal.fire({text: sd[1], type: 'error',icon: 'error'});
                                    $("#show_dimen_div").prop('hidden', false);
                                }else{
                                    $("#form_submit_btn").prop('disabled', false);
                                    $("#show_dimen_div").prop('hidden', true);
                                }
                            }
                        });

                        //alert("Image width: " + width + ", height: " + height);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
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
                        url: APP_URL + "/backend/setup-file/" + fileId,
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

        $(document).ready(function () {
            $("#show_dimen_div").prop('hidden', true);
            document.getElementById("content").value = "";
            reloadDataTable();
            img_required();
            field_require();
        });

        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });

        /*function enableDisableSaveBtn() {
            if ($('#charge_table tr').length == 0) {
                $("#form_submit_btn").prop('disabled', true);
            } else {
                $("#form_submit_btn").prop('disabled', false);
            }
        }*/

        function reloadDataTable() {
            $('#pageSetupTable').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: APP_URL + '/backend/page-setup-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        var dt_params = {
                            page_id: $('#page_id :selected').val(),
                            content_id: $('#content_id :selected').val(),
                        };
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {"data": "page_name"},
                    {"data": "content_name"},
                    {"data": "content_title"},
                    {"data": "content_serial"},
                    {"data": "active_status"},
                    {"data": "action", "orderable": false}
                ]
            });
        }

        $('#page_id').change(function () {
            $.ajax({
                type: 'get',
                url: '/backend/get-page-content',
                data: {page_id: $(this).val()},
                success: function (msg) {
                    $("#content_id").html(msg);
                    //reloadDataTable();
                }
            });
        });

        $('#content_id').change(function () {
            img_required();
            field_require();
        });

        function field_require(){
            $.ajax({
                type: 'get',
                url: '/backend/field-require-chk',
                data: {page_id: $("#page_id").val(), content_id: $("#content_id").val()},
                success: function (msg) {
                    $("#required_span_content").prop('hidden', true);
                    $("#required_span_link").prop('hidden', true);
                    $("#required_span_img").prop('hidden', true);
                    $("#required_span_icon").prop('hidden', true);
                    $("#required_span_extra2").prop('hidden', true);
                    $("#required_span_extra1").prop('hidden', true);
                    $("#required_span_extra3").prop('hidden', true);

                    $.each(msg, function (i) {
                        if(msg[i].mandatory_field == "required_span_content"){
                            $("#required_span_content").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_link"){
                            $("#required_span_link").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_img"){
                            $("#required_span_img").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_icon"){
                            $("#required_span_icon").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_extra2"){
                            $("#required_span_extra2").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_extra1"){
                            $("#required_span_extra1").prop('hidden', false);
                        }else if(msg[i].mandatory_field == "required_span_extra3"){
                            $("#required_span_extra3").prop('hidden', false);
                        }
                    });
                }
            });
        }

        function img_required(){
            $.ajax({
                type: 'get',
                url: '/backend/image-dimension-chk-msg',
                data: {page_id: $("#page_id").val(), content_id: $("#content_id").val()},
                success: function (msg) {
                    let sd = msg.split('+');
                    /*if(sd[0]==0){
                        $("#form_submit_btn").prop('disabled', true);
                        Swal.fire({text: sd[1], type: 'error',icon: 'error'});
                    }else{
                        $("#form_submit_btn").prop('disabled', false);
                    }*/
                    if($('#content_id').val()!=''){
                        if(sd[0]==1){
                            $('#show_dimen_span').html('<b>' + sd[1] + ' px</b>');
                            $("#show_dimen_div").prop('hidden', false);
                        }else{
                            $("#show_dimen_div").prop('hidden', true);
                        }
                    }else{
                        $("#show_dimen_div").prop('hidden', true);
                    }
                }
            });
        }

        var addLineRow;
        var removeLineRow;
        var editAccount;

        /*function addLine(selector) {
            if ($(selector).attr('data-type') == 'A') {
                let count = $("#ar_account_table >tbody").children("tr").length;

                let html = '<tr>\n' +
                    '<input tabindex="-1" type="hidden" name="line[' + count + '][setup_dtl_id]" id="setup_dtl_id' + count + '" value=""/>' +
                    '<input tabindex="-1" type="hidden" name="line[' + count + '][content_id]" id="content_id' + count + '" value="' + $("#content_id").val() + '"/>' +
                    '<td style="padding: 4px;"><input tabindex="-1" type="text" class="form-control text-right-align" name="line[' + count + '][content_title]" id="content_title' + count + '" value="' + $('#content_title').val() + '" readonly></td>\n' +
                    '<td style="padding: 4px;"><input tabindex="-1" type="text" class="form-control text-right-align" name="line[' + count + '][content_serial]" id="content_serial' + count + '" value="' + $('#content_serial').val() + '" readonly></td>\n' +
                    '<td style="padding: 4px;"><input tabindex="-1" type="text" class="form-control text-right-align" name="line[' + count + '][content]" id="content' + count + '" value="' + $('#content').val() + '" readonly></td>\n' +
                    '      <td style="padding: 4px; text-align: center"><span style="text-decoration: underline" id="line' + count + '" class="btn btn-secondary editAccountBtn" onclick="editAccount(this,' + count + ')" >Edit</span> || <span class="btn btn-danger cursor-pointer" id="ar_remove_btn' + count + '" onclick="removeLineRow(this,' + count + ')">Delete</span></td>\n' +
                    '  </tr>';
                $("#ar_account_table >tbody").append(html);

            } else {
                var lineToUpdate = $(selector).attr('data-line');
                updateLineValue(lineToUpdate);
            }
        }

        function updateLineValue(line) {
            $("#setup_dtl_id" + line).val($("#setup_dtl_id").val());//---this
            $("#content_id" + line).val($("#content_id").val());//---this
            $("#content_title" + line).val($("#content_title").val());
            $("#content_serial" + line).val($("#content_serial").val());
            $("#content" + line).val($("#content").val());
            $(".editAccountBtn").removeClass('d-none');
            var select = "#addNewLineBtn";
            $(select).html("<i class='bx bx-plus-circle'></i>ADD");
            $(select).attr('data-type', 'A');
            $(select).attr('data-line', '');
            $("#form_submit_btn").prop('disabled', false);
            enableDisableSaveBtn();
            $("#ar_remove_btn" + line).show();
        }

        addLineRow = function (selector) {
            if ($("#content_title").val() != null || $("#content_serial").val() != null|| $("#content").val() != null) {

                    addLine(selector);
            } else {
                $(selector).notify("Missing input.", "error", {position: "left"});
            }
            resetField(['#content_title', '#content_serial', '#content']);
            enableDisableSaveBtn();
        }

        removeLineRow = function (select, lineRow) {
            $("#action_type" + lineRow).val('D');
            $(select).closest("tr").remove();
            enableDisableSaveBtn();
        }

        editAccount = function (selector, line) {
            $("#ar_remove_btn" + line).hide();

            $("#content_title").val($("#content_title" + line).val());
            $("#content_serial").val($("#content_serial" + line).val());
            $("#content").val($("#content" + line).val());
            $(".editAccountBtn").addClass('d-none');
            var select = "#addNewLineBtn";
            $(select).html("<i class='bx bx-edit'></i>UPDATE");
            $(select).attr('data-type', 'U');
            $(select).attr('data-line', line);
            $("#form_submit_btn").prop('disabled', true);
        }*/


    </script>

@endsection

