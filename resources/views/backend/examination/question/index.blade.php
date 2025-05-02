@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
    <link href="{{asset('backend/assets/css/exam/jquery-ui.min.css')}}" />
    <link href="{{asset('backend/assets/css/exam/jquery-ui.theme.min.css')}}" />

    <style rel="stylesheet">
        .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            text-align: left;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
        }

        .ui-autocomplete > li > div {
            display: block;
            padding: 3px 20px;
            clear: both;
            font-weight: normal;
            line-height: 1.42857143;
            color: #333333;
            white-space: nowrap;
        }

        .ui-state-hover,
        .ui-state-active,
        .ui-state-focus {
            text-decoration: none;
            color: #262626;
            background-color: #83e883;
            cursor: pointer;
        }

        .ui-helper-hidden-accessible {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

    </style>
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <h3>Question Create</h3>
            <hr>
            <div class="card-block m-t-35">
                <form class="form-horizontal" name="questionForm" id="popup-validation" method="post"
                      @if(isset($insertedData))
                      action="{{route('question.store',['id'=>$insertedData->id])}}"
                      @else
                      action="{{route('question.store')}}"
                      @endif
                      enctype="multipart/form-data"
                >
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row p-1">
                                <div class="col-md-4 ">
                                    <label for="subject" class="col-form-label required">Subject</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="subject" id="subject" required
                                            class=" form-control {{isset($insertedData) ? 'make-readonly-bg' : ''}}">
                                        <option value="">Select a Subject</option>
                                        @foreach ($subjects as $s)
                                            <option {{(isset($insertedData) ? (($insertedData->subject_id == $s->id) ? 'selected': '') :'')}} value="{{$s->id}}">{{$s->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row p-1">
                                <div class="col-md-4">
                                    <label for="topic" class="col-form-label required">Topics</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="topic" id="topic" required
                                            class=" form-control select2 {{isset($insertedData) ? 'make-readonly-bg' : ''}}" data-preselect="{{(isset($insertedData) ? $insertedData->topic_id :'')}}">
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-4 ">
                                    <label for="mark" class="col-form-label required">Mark</label>
                                </div>
                                <div class="col-md-8">
                                    <input min="0" type="number" id="mark" name="mark" required value="{{isset($insertedData) ? $insertedData->mark :'' }}"
                                           class="form-control  ">
                                </div>
                            </div>
                            <div class="p-1 row" hidden>
                                <div class="col-md-4 ">
                                    <label for="negativeMark" class="col-form-label">Negative mark</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="negativeMark" name="negativeMark" value="{{isset($insertedData) ? $insertedData->negative_mark :'' }}"
                                           class="form-control  ">
                                </div>
                            </div>
                            <div class="p-1 row">
                                <div class="col-md-4">
                                    <label for="question" class="col-form-label required">Question Format</label>
                                </div>
                                <div class="col-md-8">
                                    <select name="questionFormat" id="format" required
                                            class=" form-control select2 {{ isset($insertedData) ? 'make-readonly-bg' : '' }}">
                                        <option value="">Select a format</option>
                                        @foreach ($format as $t)
                                            <option {{(isset($insertedData) ? (($insertedData->format_id == $t->id) ? 'selected': '') :'')}} value="{{$t->id}}">{{$t->format_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-1 row question-desc" style="display: none;">
                        <div class="col-md-2">
                            <label for="question" class="col-form-label required">Question Description</label>
                        </div>
                        <div class="col-md-10">
                            <textarea id="question" name="question" class="form-control  question " cols="50"
                                      rows="3">{{(isset($insertedData) ? $insertedData->question :'')}}</textarea>
                        </div>
                    </div>
                    <div class="p-1 row question-img" style="display: none;">
                        <div class="col-md-2">
                            <label for="question_img" class="col-form-label required">Question Image</label>
                        </div>
                        <div class="col-md-10">
                            <input type="file" id="question_img" name="question_img" class="form-control" accept="image/*">
                            <img id="questionImgPreview" width="100" height="100" alt=""
                                 class="{{isset($insertedData) ? (empty($insertedData->file) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                 src="{{isset($insertedData) ? ( !empty($insertedData->file) ? 'data:'.$insertedData->file->doc_file_type.';base64,'.$insertedData->file->doc_file : '') :''}}"
                            >
                        </div>
                    </div>

                    <div class="p-1 row">
                        <div class="col-md-2">
                            <label for="type" class="col-form-label required">Answer Type</label>
                        </div>
                        <div class="col-md-10">
                            <select name="questionType" id="type" required
                                    class=" form-control select2 {{isset($insertedData) ? 'make-readonly-bg' : ''}}">
                                <option value="">Select a type</option>
                                @foreach ($types as $t)
                                    <option {{(isset($insertedData) ? (($insertedData->type_id == $t->id) ? 'selected': '') :'')}} value="{{$t->id}}">{{$t->type}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row choice" style="display: none;">
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="choice1" class="col-form-label required">Choice 1</label>
                                </div>
                                <div class="col-md-5">
                                    <textarea id="choice1" name="choice1" rows="3" class="form-control">{{isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE) ? $insertedData->choice->choice1 :'' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="choice2" class="col-form-label required">Choice 2</label>
                                </div>
                                <div class="col-md-5">
                                    <textarea id="choice2" name="choice2" rows="3" class="form-control">{{isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE) ? $insertedData->choice->choice2 :'' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row choice" style="display: none;">
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="choice3" class="col-form-label required">Choice 3</label>
                                </div>
                                <div class="col-md-5">
                                    <textarea id="choice3" name="choice3" rows="3" class="form-control">{{isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE) ? $insertedData->choice->choice3 :'' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="choice4" class="col-form-label required">Choice 4</label>
                                </div>
                                <div class="col-md-5">
                                    <textarea id="choice4" name="choice4" rows="3" class="form-control">{{isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE) ? $insertedData->choice->choice4 :'' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row imageChoice" style="display: none;">
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="image1" class="col-form-label required">Option 1</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="file" id="image1" name="image[]" class="form-control" accept="image/*">
                                    <img id="preview1" width="100" height="100" alt=""
                                         class="{{(isset($insertedData) && isset($insertedData->choice)) ? ((count($insertedData->choice->files) == 0) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto"
                                         src="{{(isset($insertedData) && isset($insertedData->choice)) ? ( (count($insertedData->choice->files) > 0) ? 'data:'.$insertedData->choice->files[0]->doc_file_type.';base64,'.$insertedData->choice->files[0]->doc_file : '') :''}}"
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="image2" class="col-form-label required">Option 2</label>
                                </div>
                                <div class="col-md-5">
                                    <input type="file" id="image2" name="image[]" class="form-control" accept="image/*">
                                    <img id="preview2" width="100" height="100"

                                         src="{{(isset($insertedData) && isset($insertedData->choice)) ? ( (count($insertedData->choice->files) > 0) ? 'data:'.$insertedData->choice->files[1]->doc_file_type.';base64,'.$insertedData->choice->files[1]->doc_file : '') :''}}" alt=""
                                         class="{{(isset($insertedData) && isset($insertedData->choice)) ? ((count($insertedData->choice->files) == 0) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row imageChoice" style="display: none;">
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="image3" class="col-form-label required">Option 3</label>
                                </div>
                                <div class="col-md-5">
                                    <input accept="image/*" type="file" id="image3" name="image[]"
                                           class="form-control" >
                                    <img id="preview3" width="100" height="100"
                                         src="{{(isset($insertedData) && isset($insertedData->choice)) ? ( (count($insertedData->choice->files) > 0) ? 'data:'.$insertedData->choice->files[2]->doc_file_type.';base64,'.$insertedData->choice->files[2]->doc_file : '') :''}}" alt=""
                                         class="{{(isset($insertedData) && isset($insertedData->choice)) ? ((count($insertedData->choice->files) == 0) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto ">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1 row">
                                <div class="col-md-3 offset-4">
                                    <label for="image4" class="col-form-label required">Option 4</label>
                                </div>
                                <div class="col-md-5">
                                    <input accept="image/*" type="file" id="image4" name="image[]"
                                           class="form-control ">
                                    <img id="preview4" width="100" height="100"
                                         src="{{(isset($insertedData) && isset($insertedData->choice)) ? ( (count($insertedData->choice->files) > 0) ? 'data:'.$insertedData->choice->files[3]->doc_file_type.';base64,'.$insertedData->choice->files[3]->doc_file : '') :''}}" alt=""
                                         class="{{(isset($insertedData) && isset($insertedData->choice)) ? ((count($insertedData->choice->files) == 0) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto ">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-1 row">
                        <div class="col-md-2">
                            <label for="answer" style="display: none" id="answerLabel" class="col-form-label required">Answer</label>
                        </div>
                        <div class="col-md-10">
                            <div class="choiceAnswer form-control" style="display: none;">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="choiceAnswer"  id="ans1"
                                           value="1" {{(isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE || $insertedData->type_id == \App\Enums\Exam\LEQuestionType::IMAGE ) ? (($insertedData->choice->answer == 1) ? 'checked': '') :'')}}>
                                    <label class="form-check-label required" for="ans1">Choice 1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="choiceAnswer" id="ans2"
                                           value="2" {{(isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE || $insertedData->type_id == \App\Enums\Exam\LEQuestionType::IMAGE ) ? (($insertedData->choice->answer == 2) ? 'checked': '') :'')}}>
                                    <label class="form-check-label required" for="ans2">Choice 2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="choiceAnswer" id="ans3"
                                           value="3" {{(isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE || $insertedData->type_id == \App\Enums\Exam\LEQuestionType::IMAGE ) ? (($insertedData->choice->answer == 3) ? 'checked': '') :'')}}>
                                    <label class="form-check-label required" for="ans3">Choice 3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="choiceAnswer" id="ans4"
                                           value="4" {{(isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE || $insertedData->type_id == \App\Enums\Exam\LEQuestionType::IMAGE ) ? (($insertedData->choice->answer == 4) ? 'checked': '') :'')}}>
                                    <label class="form-check-label required" for="ans4">Choice 4</label>
                                </div>
                            </div>
<!--                            <textarea id="gAnswer" name="answer" class="form-control " cols="50"
                                      rows="3">{{(isset($insertedData) ? $insertedData->answer:'')}}</textarea>-->
                        </div>
                    </div>

                    <div class="p-1 row">
                        <div class="col-md-2">
                            <label for="description" class="col-form-label">Description/Hint/Note</label>
                        </div>
                        <div class="col-md-10">
                            <textarea id="description" name="answerDesc" class="form-control" cols="50"
                                      rows="3">{{(isset($insertedData) ? $insertedData->answer_description:'')}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6 offset-2">
                            <input name="in_active" value="N"
                                   {{ old('in_active',isset($insertedData) ? ($insertedData->active_yn == 'N' ? 'checked' : '') : '') }}  type="checkbox"
                                   class="checkbox" aria-label="Checkbox for following text input">In-Active
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <div class="form-actions p-1 row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input type="submit" value="{{(isset($insertedData) ? 'Update':'Submit')}}" class="btn btn-primary">
                            {!! (isset($insertedData) ? '|<a href="'.route("question.list").'" class="btn btn-info">Back</a>' : '') !!}

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("footer-script")
    <script src="{{asset('backend/assets/js/pages/exam/jquery-ui.min.js')}}"></script>
    <script type="text/javascript">
        submit();

        function submit() {
            $("form[name=questionForm]").submit(function (e) {
                e.preventDefault();

                if ((($("#type").val() == '{{\App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE}}') || ($("#type").val() == '{{\App\Enums\Exam\LEQuestionType::IMAGE}}')) && !answerChoiceSelected()) {
                    $(".choiceAnswer").notify("Set an answer.");
                    return false;
                }

                swal.fire({
                    text: 'Create Confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            processData: false,
                            contentType: false,

                            header: {'x-csrf-token': '{{csrf_token()}}'},
                            data: new FormData($(this)[0])
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
                                Swal.fire({text: res.response_msg, icon: 'error'});
                            }
                        });

                        request.fail(function (jqXHR, textStatus) {
                            console.log(jqXHR);
                        });
                    }
                })
            })

        }

        function resetImageFields() {

        }

        imagePreview();

        function imagePreview() {
            function generatePreview(selector, preview) {
                let file = $(selector).get(0).files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function () {
                        $(preview).removeClass('d-none');
                        $(preview).attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            }

            $("#question_img").on('change', function () {
                generatePreview(this, '#questionImgPreview');
            })


            $("#image1").on('change', function () {
                generatePreview(this, '#preview1')
            });
            $("#image2").on('change', function () {
                generatePreview(this, '#preview2')
            });
            $("#image3").on('change', function () {
                generatePreview(this, '#preview3')
            });
            $("#image4").on('change', function () {
                generatePreview(this, '#preview4')
            })
        }

        function resetChoiceFields() {
            $("#choice1, #choice2, #choice3, #choice4").val("");
        }

        $("#subject").on('change', function () {
            let response = $.ajax({
                url: '{{route('ajax.topics-of-subject')}}',
                data: {'subject-id': $(this).find(':selected').val(),'preselect-topic':$("#topic").data('preselect')}
            });
            response.done(function (d) {
                $("#topic").html(d.options);
            });

            response.fail(function (d) {
                console.log(d);
            });
        });

        function answerChoiceSelected() {
            if ($("#ans1").is(":checked")){
                return true;
            }
            if ($("#ans2").is(":checked")){
                return true;
            }
            if ($("#ans3").is(":checked")){
                return true;
            }
            if ($("#ans4").is(":checked")){
                return true;
            }

            return false;
        }
        
        function makeMultipleChoiceEnableDisable(status) {
            if (status === 'e') {
                $(".choice").show(1000);

                $("#choice1").attr("required", true);
                $("#choice2").attr("required", true);
                $("#choice3").attr("required", true);
                $("#choice4").attr("required", true);

            } else {
                $(".choice").hide(1000);

                $("#choice1").removeAttr("required");
                $("#choice2").removeAttr("required");
                $("#choice3").removeAttr("required");
                $("#choice4").removeAttr("required");
            }
        }

        function makeImageEnableDisable(status) {
            if (status === 'e') {
                $(".imageChoice").show(1000);
                @if(isset($insertedData) && ($insertedData->type_id == \App\Enums\Exam\LEQuestionType::IMAGE))
                        @if($insertedData->choice->files == '')
                            $("#image1").attr("required", true);
                            $("#image2").attr("required", true);
                            $("#image3").attr("required", true);
                            $("#image4").attr("required", true);
                        @endif
                @else
                $("#image1").attr("required", true);
                $("#image2").attr("required", true);
                $("#image3").attr("required", true);
                $("#image4").attr("required", true);
                @endif

            } else {
                $(".imageChoice").hide(1000);

                $("#image1").removeAttr("required");
                $("#image2").removeAttr("required");
                $("#image3").removeAttr("required");
                $("#image4").removeAttr("required");
            }
        }

        function makeGanswerEnableDisable(status) {
            if (status === 'e') {
                $("#answerLabel").hide();
               /* $("#gAnswer").show(1000);
                $("#gAnswer").attr("required", true);*/
            } else {
                $("#answerLabel").show();
                /*$("#gAnswer").hide(1000);
                $("#gAnswer").removeAttr("required");*/
            }
        }

        $("#question").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: '{{route("ajax.question-suggestion")}}',
                    dataType: 'JSON',
                    data:{ term: request.term},
                    success: function (data) {
                        response(data);
                    }
                });
            }
        })

       /* function callAutoComplete(){
            console.log("hee");
        }

        ClassicEditor
            .create(document.querySelector('#question'))
            .then(question => {
                question.editing.view.document.on( 'keydown', function () {
                    console.log(this.val());
                } )
            })
            .catch(error => {
                console.error(error);
            });*/


        $("#format").on('change', function () {
            if ($(this).val() == '{{\App\Enums\Exam\LEQuestionFormat::DESCRIPTIVE}}'){
                $(".question-desc").show(1000);
                $(".question-desc").attr("required","required");

                $(".question-img").hide(1000);
                $(".question-img").removeAttr("required");
            }else if ($(this).val() == '{{\App\Enums\Exam\LEQuestionFormat::IMAGE}}'){
                $(".question-desc").hide(1000);
                $(".question-desc").removeAttr("required");

                $(".question-img").show(1000);
                $(".question-img").attr("required","required");
            }else if ($(this).val() == '{{\App\Enums\Exam\LEQuestionFormat::BOTH}}'){
                $(".question-desc").show(1000);
                $(".question-desc").attr("required","required");

                $(".question-img").show(1000);
                $(".question-img").attr("required","required");
            }else{
                $(".question-desc").hide(1000);
                $(".question-desc").removeAttr("required");

                $(".question-img").hide(1000);
                $(".question-img").removeAttr("required");
            }
        });
        $("#type").on('change', function () {
            if ($("#type").val() == '{{\App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE}}') {
                makeMultipleChoiceEnableDisable('e');
                $(".choiceAnswer").show(1000);
                $("#answerLabel").show(1000);

                makeImageEnableDisable('d');
            } else if ($("#type").val() == '{{\App\Enums\Exam\LEQuestionType::IMAGE}}') {
                makeImageEnableDisable('e');
                $(".choiceAnswer").show(1000);
                $("#answerLabel").show(1000);

                makeMultipleChoiceEnableDisable('d');
            } else {
                makeImageEnableDisable('d');
                makeMultipleChoiceEnableDisable('d');
                $(".choiceAnswer").hide(1000);
                $("#answerLabel").hide(1000);
            }
        })
        $(document).ready(function () {
            @if(isset($insertedData))
                $("#subject").trigger('change');
                $("#format").trigger('change');
                $("#type").trigger('change');
            @endif
        });
    </script>
@endsection