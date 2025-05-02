@extends("backend.layouts.default")

@section("title") @endsection

@section("header-style")
<style>
    .ck-editor__editable_inline{
        min-height: 350px;
    }
</style>
@endsection

@section("content")

    <div class="card">
        <div class="card-body">
            <h4>Creat new exam</h4>
            <hr>
            <div class="row">
                <div class="col-md-8 offset-3">
                    <form class="needs-validation" id="popup-validation" name="examForm"
                          method="post"
                          @if(isset($exam))
                          action="{{route('exam.update',['id'=>$exam->exam_id])}}"
                          @else
                          action="{{route('exam.create')}}"
                            @endif
                    >
                        @isset($exam) @method("put")  @endisset
                        @csrf
                        <div class="form-row">
                            <div class="col-md-2 text-md-right">
                                <label for="exam" class="col-form-label required">Exam Type</label>
                            </div>
                            <div class="col-md-8">
                                <select name="exam_type" id="examType"
                                        class="form-control {{isset($exam) ? 'make-readonly-bg' : ''}}" required>
                                    <option value="">Select a type</option>
                                    @foreach($examTypes as $et)
                                        <option data-presetdate="{{$et->predefined_date_yn}}"
                                                data-payment="{{$et->payment_required_yn}}"
                                                data-course="{{$et->course_dependent_yn}}"
                                                data-event="{{$et->event_image_yn}}"
                                                data-thumbnail="{{$et->thumbnail_image_yn}}"
                                                value="{{$et->id}}" {{isset($exam) ? ($exam->exam_type == $et->id ? 'selected' : '') : ''}} >{{ $et->name }}</option>
                                    @endforeach
                                </select>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide exam type.
                                </div>
                            </div>
                        </div>
                        <div class="form-row courseArea" {{isset($exam) ? (($exam->course_id != null) ? '' : 'style="display: none;"') : 'style="display: none;"'}}>
                            <div class="col-md-2">
                                <label for="course"
                                       class="form-label {{isset($exam) ? (($exam->course_id != null) ? 'required' : '') : ''}}">Course</label>
                            </div>
                            <div class="col-md-8 {{isset($exam) ? 'make-select2-readonly-bg' : ''}}">
                                <select class="form-control select2" name="course" id="course"
                                        style="width: 100% !important; height: 100% !important;">
                                    <option value="">Select Course</option>
                                    @foreach($course as $c)
                                        <option value="{{ $c->course_id }}" {{ (old('course',isset($exam) ? $exam->course_id : '') == $c->course_id) ? 'selected' : '' }}>{{ $c->course_name_en }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please select a course.
                                </div>
                            </div>
                            <!--                            <div class="col-md-6">
                                                            <div class="make-readonly">
                                                                <label for="batch" class="form-label required">Batch</label>
                                                                <select readonly="" class="form-control form-control-sm" name="batch" id="batch"
                                                                        required>
                                                                </select>
                                                                <div class="valid-feedback">
                                                                    Looks good!
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    Please set a batch.
                                                                </div>
                                                            </div>
                                                        </div>-->
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 text-md-right">
                                <label for="exam" class="col-form-label required">Exam Name</label>
                            </div>
                            <div class="col-md-8">
                                <textarea id="exam" name="exam_name" class="form-control " cols="50"
                                          rows="3" required>{{isset($exam) ? $exam->exam_name : ''}}</textarea>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide exam name.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 examDateArea">
                                <div class="col-md-12">
                                    <label for="examDate" class="col-form-label">Exam date</label>
                                </div>
                                <div class="col-md-12 {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-readonly-bg' : ''  ) : ''}}">
                                    <input type="text" class="form-control input-date"
                                           name="exam_date"
                                           data-date-format="dd-mm-yyyy"
                                           data-date-autoclose="true"
                                           data-provide="datepicker"
                                           autocomplete="off"
                                           {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'readonly tabindex="-1"' : ''  ) : ''}}
                                           id="examDate"
                                           value="{{old('exam_date',isset($exam) ? \App\Helpers\HelperClass::dateConvert($exam->exam_date) : '')}}"
                                           placeholder="Start Date"/>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please give exam date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="col-md-8 required">
                                    <label for="examDuration" class="col-form-label">Exam duration</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-readonly' : ''  ) : ''}}">
                                        <input type="time" name="exam_start_time" required
                                               {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'readonly' : ''  ) : ''}}
                                               id="exam_start_time"
                                               class="form-control" data-placement="left"
                                               onchange="calculateTime()"
                                               value="{{isset($exam) ? $exam->exam_start_at : ''}}"
                                               data-align="top" data-autoclose="true">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please give exam start time.
                                        </div>
                                    </div>
                                    <div class="col-md-6 {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-readonly' : ''  ) : ''}}">
                                        <input type="time" name="exam_end_time" required
                                               {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'readonly' : ''  ) : ''}}
                                               id="exam_end_time"
                                               onchange="calculateTime()"
                                               class="form-control" data-placement="left"
                                               value="{{isset($exam) ? $exam->exam_end_at : ''}}"
                                               data-align="top" data-autoclose="true">
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please give exam end time.
                                        </div>
                                    </div>
                                    <span id="duration"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 priceArea">
                                <div class="col-md-2">
                                    <label for="price" class="col-form-label">Price</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="number" id="price" name="price" placeholder="Taka.."
                                           value="{{isset($exam) ? $exam->price : ''}}"
                                           class="form-control  ">
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" value="Y" id="certAllowChecked"
                                           name="cert_allow" {{isset($exam) ? (($exam->allow_certificate == 'Y') ? 'checked' : '') : ''}} >
                                    <label class="form-check-label" for="certAllowChecked">
                                        Allow Certificate
                                    </label>
                                </div>
                            </div>
                        </div>
                            <div class="form-row certificate m-1">
                                <div class="col-md-4">
                                    <label for="cert_image" class="col-form-label">Upload Certificate</label>
                                </div>
                                <div class="col-md-6">
                                    <input id="cert_image" name="cert_image" type="file"
                                           data-preset="{{ isset($exam) ? (isset($exam->image_file) ? "Y" : "N" ) : "N"  }}"
                                           class="form-control"
                                           accept="image/*">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide note.
                                    </div>
                                    @if(isset($exam))
                                        @if (isset($exam->image_file))
                                            <p>Pre uploaded: (<a
                                                        href="{{route('exam.file-download',['id'=>$exam->image_file->self_development_file_id,'ce_image'=>'c'])}}">{{$exam->image_file->certificate_name}}&nbsp;<i
                                                            class="bx bx-download"></i></a>)
                                            </p>
                                        @endif
                                    @endisset
                                </div>
                                <button class="btn btn-sm btn-info mt-1" id="certProcess"  type="button">Process</button>
                                <a target="_blank" class="btn btn-sm btn-warning d-none mt-1" id="certPreview" href="{{ isset($exam->image_file)? (isset($exam->image_file->certificate_name) ? route('exam.file-download',['id'=>$exam->image_file->self_development_file_id,'ce_image'=>'c']) : '' ) : '' }}">Preview</a>
                            </div>

                            <div class="form-row">
                            <div class="col-md-2 required">
                                <label for="" class="col-form-label">Subject</label>
                            </div>
                            <div class="col-md-8 {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-select2-readonly-bg' : ''  ) : ''}}">
                                <select name="subject_id[]" id="subject" class="form-control select2" required
                                        {{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'readonly' : ''  ) : ''}} multiple>
                                    <option value="">Select subject
                                    </option>
                                    @foreach ($subjects as $s)
                                        <option value="{{$s->id}}" {{isset($exam) ? (in_array($s->id, array_column($exam->subjects->toArray(),'subject_id')) == true ? 'selected' : '') : ''}}>{{$s->name}}</option>
                                    @endforeach
                                </select>

                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide subject.
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4" style="padding-right: 0px">
                                <div class="row">
                                    <div class="required">
                                        <label for="t_question" class="col-form-label t_question">Total Questions</label>
                                    </div>
                                    <div class="{{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-select2-readonly-bg' : ''  ) : ''}}">
                                        <input type="number" id="t_question" name="t_question" placeholder="" required
                                               value="{{isset($exam) ? $exam->total_question : ''}}"
                                               class="form-control">

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide total question.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-right: 0px">
                                <div class="row ">
                                    <div class="required">
                                        <label for="pass_per" class="col-form-label pass_per">Minimum Pass %</label>
                                    </div>
                                    <div class="{{isset($exam) ? (in_array($exam->status, [\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED, \App\Enums\Exam\LExamStatus::UN_PUBLISHED, \App\Enums\Exam\LExamStatus::EXPIRED]) ? 'make-select2-readonly-bg' : ''  ) : ''}} ">
                                        <input type="number" id="pass_per" name="pass_per" placeholder="" required
                                               value="{{isset($exam) ? $exam->min_pass_percentage : ''}}"
                                               class="form-control">

                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="invalid-feedback">
                                            Please provide pass percentage.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 text-md-right">
                                <label for="note" class="col-form-label required">Instructions</label>
                            </div>
                            <div class="col-md-10">
                                <textarea class="form-control"
                                           name="instruction"
                                          id="instruction">{{ old('instruction',isset($exam) ? $exam->instruction : '') }}</textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please give a course FAQ.
                                </div>
                            </div>
                        </div>

                        <div class="form-row socialImage d-none">
                            <div class="col-md text-md-right">
                                <label for="social_image" class="col-form-label required">Event Social Image (Allowed
                                    dimension: 1200x630)</label>
                            </div>
                            <div class="col-md-8">
                                <input id="social_image" name="social_image" type="file"
                                       {{ isset($insertedData) ? (isset($insertedData->batch_file) ? "" : "" ) : ""  }} class="form-control"
                                       accept="image/*">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide note.
                                </div>
                            </div>
                        </div>
                        <div class="form-row eventImage">
                            <div class="col-md text-md-right">
                                <label for="event_image" class="col-form-label required event_image_label">Event Detail Image</label>
                            </div>
                            <div class="col-md-8">
                                <input id="event_image" name="event_image" type="file"
                                       data-preset="{{ isset($exam) ? (isset($exam->image_file) ? "Y" : "N" ) : "N"  }}"
                                       class="form-control"
                                       accept="image/*">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide note.
                                </div>
                                @if(isset($exam))
                                    @if (isset($exam->image_file))
                                        <p>Pre uploaded: {{$exam->image_file->doc_file_name}} (<a
                                                    href="{{route('exam.file-download',['id'=>$exam->image_file->self_development_file_id,'ce_image'=>'e'])}}"><i
                                                        class="bx bx-download"></i></a>)
                                        </p>
                                    @endif
                                @endisset
                            </div>
                        </div>
                    <!--                        <div class="form-row">
                            <div class="col-md-2 text-md-right">
                                <label for="status" class="col-form-label">Status</label>
                            </div>
                            <div class="col-md-8">
                                <select id="examStatus" name="status" class="form-control">
                                    <option value="p" {{isset($exam) ? ($exam->status == 'p' ? 'selected' : '') : ''}}>
                                        Published
                                    </option>
                                    <option value="u" {{isset($exam) ? ($exam->status == 'u' ? 'selected' : '') : ''}}>
                                        Un-Published
                                    </option>
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please provide note.
                                </div>
                            </div>
                        </div>-->

                        <div class="form-actions row mt-1">
                            <div class="col-md-8 d-flex justify-content-center">
                                <input type="submit" value="{{isset($exam) ? 'Update' : 'Submit' }}"
                                       class="btn btn-primary col-md-4">
                                <a href="{{route('exam.list')}}" class="btn btn-info mx-2">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
@section("footer-script")
    <script src="{{ asset('backend/assets/js/pages/exam/examCreate.js') }}"></script>
@endsection
