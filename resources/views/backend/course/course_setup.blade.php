@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Course Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data"
                  @if(isset($insertedData))
                  action="{{ route('course-setup.update',['id'=>$insertedData->course_id]) }}">
                @method('PUT')
                @else
                    action="{{route('course-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_type" class="form-label required">Course Type</label>
                            <select class="form-control" name="course_type" required>
                                <option value="">Select Type</option>
                                @foreach($courseTypes as $type)
                                    <option value="{{ $type->id }}" {{ (old('course_type',isset($insertedData) ? $insertedData->course_type_id : '') == $type->id) ? 'selected' : '' }}>{{ $type->type_name_en }}</option>
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
                            <label for="course_code" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code"
                                   value="{{ old('course_code',isset($insertedData) ? $insertedData->course_code : '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_name_en" class="form-label required">Course Name (En)</label>
                            <input type="text" class="form-control" id="course_name_en" name="course_name_en"
                                   value="{{ old('course_name_en',isset($insertedData) ? $insertedData->course_name_en : '') }}"
                                   required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a bangla type name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_name_bn" class="form-label">Course Name (Bn)</label>
                            <input type="text" class="form-control" id="course_name_bn" name="course_name_bn"
                                   value="{{ old('course_name_bn',isset($insertedData) ? $insertedData->course_name_bn : '') }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a bangla course name.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <span>Slug:</span><span id="slug_view"><span
                                    style="text-decoration: underline">
                                <a href="">
                                {{ old("slug",isset($insertedData) ? isset($insertedData->slug) ? url('/course/course-detail').'/'.$insertedData->slug : "" : "") }}
                                </a>
                            </span></span>
                        <input type="hidden" id="slug" name="slug"
                               value="{{ old('course_summary_en',isset($insertedData) ? $insertedData->slug : '') }}"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="course_summary_en" class="form-label required">Course Summary / Short Description After Title (En)</label>
                            <textarea class="form-control" rows="6" name="course_summary_en" required
                                      id="course_summary_en">{{ old('course_summary_en',isset($insertedData) ? $insertedData->course_summary_en : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a english course name.
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_summary_bn" class="form-label">Course Summary (Bn)</label>
                            <textarea class="form-control" rows="6" name="course_summary_bn"
                                      id="course_summary_bn">{{ old('course_summary_bn',isset($insertedData) ? $insertedData->course_summary_bn : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a bangla course name.
                            </div>
                        </div>
                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_desc_en" class="form-label">Course Description (About Course After Course Outline)</label>
                            <textarea class="form-control" rows="6" name="course_desc_en" id="course_desc_en">{{ old('course_desc_en',isset($insertedData) ? $insertedData->course_desc_en : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a english course name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_faq" class="form-label">Course FAQ</label>
                            <textarea class="form-control" rows="6" name="course_faq" id="course_faq">{{ old('course_faq',isset($insertedData) ? $insertedData->course_faq : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a course FAQ.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="course_topics" class="form-label required">Course Topics (What You'll Learn)</label>
                            <textarea class="form-control" rows="6" name="course_topics" required
                                      placeholder="Use # after each topic."
                                      id="course_topics">{{ old('course_topics',isset($insertedData) ? $insertedData->course_topic : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give course topics.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="course_outline_en" class="form-label required">Course Outline (En)</label>
                            <textarea class="form-control" rows="6" name="course_outline_en" required
                                      id="course_outline_en">{{ old('course_outline_en',isset($insertedData) ? $insertedData->course_outline_en : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give course outline.
                            </div>
                        </div>
                    </div>
                    {{--<div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_outline_bn" class="form-label">Course Outline (Bn)</label>
                            <textarea class="form-control" rows="6" name="course_outline_bn"
                                      id="course_outline_bn">{{ old('course_outline_bn',isset($insertedData) ? $insertedData->course_outline_bn : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give course outline.
                            </div>
                        </div>
                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="course_outline_en" class="form-label required">Course Material</label>
                            <textarea class="form-control" rows="6" name="course_material_en" required
                                      placeholder="Use # after each material."
                                      id="course_material_en">{{ old('course_material_en',isset($insertedData) ? $insertedData->course_material_en : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give course material.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_tag" class="form-label">Course Tag</label>
                            <input type="text" class="form-control" id="course_tag" name="course_tag"
                                   value="{{ old('course_tag',isset($insertedData) ? $insertedData->course_tag : '') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_medium" class="form-label">Course Medium</label>
                            <input type="text" class="form-control" id="course_medium" name="course_medium"
                                   value="{{ old('course_medium',isset($insertedData) ? $insertedData->course_medium : '') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qualification_en" class="form-label">Participant Qualification
                                (En)</label>
                            <textarea class="form-control" rows="6" name="qualification_en"
                                      id="qualification_en">{{ old('qualification_en',isset($insertedData) ? $insertedData->participant_qualification_en : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give qualification outline.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="qualification_bn" class="form-label">Participant Qualification
                                (Bn)</label>
                            <textarea class="form-control" rows="6" name="qualification_bn"
                                      id="qualification_bn">{{ old('qualification_bn',isset($insertedData) ? $insertedData->participant_qualification_bn : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give qualification outline.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_image" class="form-label required">Course Thumbnail (Allowed dimension:
                                600x400)</label>
                            <div class="input-group" id="course_image">
                                <input name="course_thumbnail" type="file" class="form-control"
                                       {{ isset($insertedData) ? (isset($insertedData->course_file) ? "" : "required" ) : "required"  }}
                                       accept="image/*">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please upload an image.
                                </div>
                            </div>
                            @error('course_thumbnail')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <br>
                            @if(isset($insertedData))
                                @if(isset($insertedData->course_file))
                                    <p>File Name: {{$insertedData->course_file->doc_file_name}}
                                        (<a href="{{route('course-setup.file-download',['id'=>$insertedData->course_file->self_development_file_id, 'fileCode'=>\App\Enums\DocFileCode::C_THUMBNAIL])}}">
                                            <i class="bx bx-download"></i>
                                        </a>)
                                    <!-- (<a href="#"
                                        class="remove_file pe-auto"
                                        style="color:red"
                                        data-id="{{$insertedData->course_file->self_development_file_id}}"><i
                                        class="bx bx-trash"></i></a>)-->
                                    </p>
                                @endisset
                            @endisset
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="course_certificate" class="form-label ">Course Certificate (Allowed dimension: 600x400)</label>
                            <div class="input-group" id="course_certificate">
                                <input name="course_certificate" type="file" class="form-control"
                                       accept="image/*">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please upload an image.
                                </div>
                            </div>
                            @error('course_certificate')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <br>
                            @if(isset($insertedData))
                                @if(isset($insertedData->course_file))
                                    @if($insertedData->course_file->certificate_file)
                                        <p>File Name: {{$insertedData->course_file->certificate_name}} (<a
                                                    href="{{route('course-setup.file-download',['id'=>$insertedData->course_file->self_development_file_id, 'fileCode'=>\App\Enums\DocFileCode::C_CERTIFICATE ])}}"><i
                                                        class="bx bx-download"></i></a>)
                                        (<a href="#"
                                            class="remove_file pe-auto cursor-pointer"
                                            style="color:red"
                                            data-code="{{\App\Enums\DocFileCode::C_CERTIFICATE}}"
                                            data-id="{{$insertedData->course_file->self_development_file_id}}"><i
                                            class="bx bx-trash"></i></a>)
                                            <input type="hidden" name="pre_cert_image" value="{{$insertedData->course_file->self_development_file_id}}"/>
                                        </p>
                                    @endif
                                @endisset
                            @endisset
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="doc_img_alt_tag" class="form-label ">Thumbnail Image Alt Tag</label>
                            <input type="text" class="form-control" id="doc_img_alt_tag" name="doc_img_alt_tag"
                                   value="{{ old('doc_img_alt_tag',isset($insertedData) ? $insertedData->course_file->doc_img_alt_tag : '') }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give thumbnail image alt tag.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cert_img_alt_tag" class="form-label">Certificate Image Alt Tag</label>
                            <input type="text" class="form-control" id="cert_img_alt_tag" name="cert_img_alt_tag"
                                   value="{{ old('cert_img_alt_tag',isset($insertedData) ? $insertedData->course_file->cert_img_alt_tag : '') }}">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a certificate Image Alt Tag.
                            </div>
                            @error('cert_img_alt_tag')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label ">Meta Title</label>
                            <textarea class="form-control" rows="2" name="meta_title"
                                      id="meta_title">{{ old('meta_title',isset($insertedData) ? $insertedData->meta_title : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a meta title.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label ">Meta Description</label>
                            <textarea class="form-control" rows="2" name="meta_description"
                                      id="meta_description">{{ old('meta_description',isset($insertedData) ? $insertedData->meta_description : '') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a meta description.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        <label for="" class="form-label">Active</label>
                        <div class="mb-3">
                            <div class="btn-group" role="group">
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
                    <div class="col-md-1">
                         <label >&nbsp;</label>
                        <div class="mb-3">
                            <button class="btn btn-primary mx-2" type="submit">@isset($insertedData)
                                    Update
                                @else
                                    Save
                                @endisset</button>
                            @isset($insertedData)
                                <!--<a href="{{route('course-setup.index')}}" class="btn btn-info my-4">Cancel</a>-->
                            @endisset
                        </div>
                    </div>
                    @isset($insertedData)
                    <div class="col-md-1">
                        <div class="mb-3 mt-1">
                            <a href="{{route('course-setup.index')}}" class="btn btn-info my-4">Cancel</a>
                        </div>
                    </div>
                    @endisset
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Course List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="course_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Course Type</th>
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
            /*
            ClassicEditor
                .create(document.querySelector('#course_summary_en'))
                .catch(error => {
                    console.error(error);
                });
            ClassicEditor
                .create(document.querySelector('#course_summary_bn'))
                .catch(error => {
                    console.error(error);
                });
            ClassicEditor
                .create(document.querySelector('#course_summary_bn'))
                .catch(error => {
                    console.error(error);
                });*/
            ClassicEditor
                .create(document.querySelector('#course_desc_en'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#course_faq'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#course_outline_en'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#course_outline_bn'))
                .catch(error => {
                    console.error(error);
                });

            /*ClassicEditor
                .create(document.querySelector('#course_material_en'))
                .catch(error => {
                    console.error(error);
                });*/

            ClassicEditor
                .create(document.querySelector('#qualification_en'))
                .catch(error => {
                    console.error(error);
                });

            ClassicEditor
                .create(document.querySelector('#qualification_bn'))
                .catch(error => {
                    console.error(error);
                });


            let courseTable = $('#course_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/backend/course-setup-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function (params) {
                        // Retrieve dynamic parameters
                        var dt_params = $('#course_table').data('dt_params');
                        // Add dynamic parameters to the data object sent to the server
                        if (dt_params) {
                            $.extend(params, dt_params);
                        }
                    }
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course_name_en"},
                    {"data": "course_code"},
                    {"data": "course_type"},
                    {"data": "action"}
                ]
            });

            $(document).on('submit','.removeCourse', function (e) {
                e.preventDefault();
                let selector = this;
                let batches = $(this).find('.Batch').val();
                let warnMessage = "";

                if (batches > 0)
                {
                    warnMessage = "<span class='text-danger'>This course has "+ batches +" active batch. By removing the course the corrosponding batches will be lost permanently.You can also DE-ACTIVE the course.</span><br><a style='text-decoration: underline;' href='{{route("batch-setup.index")}}'>Click here</a> to go to the batch page.<br>";
                }
                swal.fire({
                    html:warnMessage+"Confirm Remove?",
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

            $(".remove_file").on('click', function () {
                let fileId = $(this).data('id');
                let file_code = $(this).data('code');

                swal.fire({
                    title: 'Remove Confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            url: APP_URL + "/backend/course-setup-file/" + fileId+"/"+file_code,
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
            $("#course_material_en").on('keyup', function (e) {
                let typedString = $(this).val();
                let lastCharacter = typedString[typedString.length - 1];
                if (e.keyCode != 8) {
                    if (lastCharacter == '#') {
                        typedString += "\n";
                    }
                }

                $(this).val(typedString);
            });

            //getSlag('{{ old("slug",isset($insertedData) ? $insertedData->course_name_en : "") }}');
            $("#course_name_en").on('keyup', function () {
                if (!nullEmptyUndefinedChecked($(this).val())) {
                    getSlag($(this).val(), 'course', setSlug);
                } else {
                    $("#slug_view").html("");
                    $("#slug").val("");
                }
            });

            function setSlug(response) {
                if (response.response_code == '1') {
                    $("#slug_view").html(' <span style="text-decoration: underline"><a href="#">' + '{{url("/course/course-detail")}}/' + response.slug + '</a></span>');
                    $("#slug").val(response.slug);
                } else {
                    $("#slug_view").html("");
                    $("#slug").val("");
                }
            }
        });
    </script>
@endsection
