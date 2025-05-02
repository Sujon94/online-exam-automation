<form action="" method="post" name="assessment-form">
    <div class="row">
        <div class="col-md-2">
            <ul class="">
                @foreach($examInfo->questions as $ind=>$q)
                    <li class="wizard-li">
                        <a href="#q_{{$ind}}" data-toggle="tab">
                            <div class="icon-circle q{{$ind}} p-1">
                                <span>{{($ind < 9)?'0'.++$ind:++$ind}}</span>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-7">
            <div class="tab-content ml-2 mr-2 pt-0" style="background-color: rgba(153,238,215,0.29);">
                <input type="hidden" id="t" name="t" value="{{encrypt($examInfo->exam_id)}}">
                <input type="hidden" id="i" name="i" value="{{isset($trans) ?$trans: null}}">
                <input type="hidden" id="ci" name="ci" value="{{$clientIp}}">
                <div class="row">
                    <div class="col-md-12">
                        <h6 style="text-decoration: underline" class="d-flex justify-content-center">{{$examInfo->exam_name}}</h6>
                        <h6 style="text-decoration: underline" class="d-flex justify-content-center">Total Mark : {{$totalMark}}</h6>
                    </div>
                </div>
                @foreach($examInfo->questions as $ind=>$q)
                    <div class="tab-pane" id="q_{{$ind}}">
                        @if($q->question->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE)
                            <div class="row">
                                <div class="col-md-12">
                                    @if($q->question->format_id == \App\Enums\Exam\LEQuestionFormat::IMAGE|| $q->question->format_id == \App\Enums\Exam\LEQuestionFormat::BOTH)
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>

                                        <br>
                                        <h5><img id="questionImgPreview"
                                                                        width="150" height="150"
                                                                        alt=""
                                                                        class="{{isset($q->question->file) ? (empty($q->question->file) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                                                        src="{{isset($q->question->file) ? ( !empty($q->question->file) ? 'data:'.$q->question->file->doc_file_type.';base64,'.$q->question->file->doc_file : '') :''}}"
                                            >
                                        </h5>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @endif

                                    <input type="hidden" name="q[{{$ind}}][id]" id="q"
                                           value="{{encrypt($q->exam_question_id)}}">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1 form-check-input" type="radio"
                                                       value="1" id="choice1">
                                                <label class="form-check-label" for="choice1">
                                                    {{$q->question->choice->choice1}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1 form-check-input" type="radio"
                                                       value="2"
                                                       id="choice2">
                                                <label class="form-check-label" for="choice2">
                                                    {{$q->question->choice->choice2}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-xs-6 ">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1 form-check-input" type="radio"
                                                       value="3"
                                                       id="choice3">
                                                <label class="form-check-label" for="choice3">
                                                    {{$q->question->choice->choice3}}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1 form-check-input" type="radio"
                                                       value="4"
                                                       id="choice4">
                                                <label class="form-check-label" for="choice4">
                                                    {{$q->question->choice->choice4}}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($q->question->type_id == \App\Enums\Exam\LEQuestionType::IMAGE)
                            <div class="row">
                                <div class="col-md-12">
                                    @if($q->question->format_id == \App\Enums\Exam\LEQuestionFormat::IMAGE|| $q->question->format_id == \App\Enums\Exam\LEQuestionFormat::BOTH)
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>
                                        <br>
                                        <h5> <img id="questionImgPreview"
                                                                        width="450" height="100"
                                                                        alt=""
                                                                        class="{{isset($q->question->file) ? (empty($q->question->file) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                                                        src="{{isset($q->question->file) ? ( !empty($q->question->file) ? 'data:'.$q->question->file->doc_file_type.';base64,'.$q->question->file->doc_file : '') :''}}"
                                            >
                                        </h5>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @endif

                                    <input type="hidden" name="q[{{$ind}}][id]" id="q"
                                           value="{{encrypt($q->exam_question_id)}}">
                                    <div class="row">
                                        <div class="col-md-6 p-1">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1" type="radio"
                                                       value="1"
                                                       id="preview1">
                                                <label class="form-check-label" for="preview1">
                                                    <img width="150" height="150"
                                                         src="data:{{$q->question->choice->files[0]->doc_file_type}};base64,{{$q->question->choice->files[0]->doc_file}}"
                                                         alt="" class="border">
                                                </label>

                                            </div>
                                        </div>
                                        <div class="col-md-6 p-1">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1" type="radio"
                                                       value="2"
                                                       id="preview2">
                                                <label class="form-check-label" for="preview2">
                                                    <img width="150" height="150"
                                                         src="data:{{$q->question->choice->files[1]->doc_file_type}};base64,{{$q->question->choice->files[1]->doc_file}}"
                                                         alt="" class="border">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 p-1">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1" type="radio"
                                                       value="3"
                                                       id="preview3">
                                                <label class="form-check-label" for="preview3">
                                                    <img width="150" height="150"
                                                         src="data:{{$q->question->choice->files[2]->doc_file_type}};base64,{{$q->question->choice->files[2]->doc_file}}"
                                                         alt="" class="border">
                                                </label>
                                            </div>

                                        </div>
                                        <div class="col-md-6 p-1">
                                            <div class="form-check">
                                                <input name="q[{{$ind}}][answer]" data-e="{{$examInfo->exam_id}}"
                                                       data-ind="q{{$ind}}"
                                                       {{--                                                                           data-i="{{$clientIp}}"--}}
                                                       class="answer float-left mt-1" type="radio"
                                                       value="4"
                                                       id="preview4">
                                                <label class="form-check-label" for="preview4">
                                                    <img width="150" height="150"
                                                         src="data:{{$q->question->choice->files[3]->doc_file_type}};base64,{{$q->question->choice->files[3]->doc_file}}"
                                                         alt="" class="border">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    @if($q->question->format_id == \App\Enums\Exam\LEQuestionFormat::IMAGE || $q->question->format_id == \App\Enums\Exam\LEQuestionFormat::BOTH)
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>
                                        <br>
                                        <h5> <img id="questionImgPreview"
                                                                        width="100" height="100"
                                                                        alt=""
                                                                        class="{{isset($q->question->file) ? (empty($q->question->file) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                                                        src="{{isset($q->question->file) ? ( !empty($q->question->file) ? 'data:'.$q->question->file->doc_file_type.';base64,'.$q->question->file->doc_file : '') :''}}"
                                            >
                                        </h5>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @else
                                        <div class="d-flex justify-content-between">
                                            <h5><i class="badge badge-info">
                                                    Q:({{$ind+1}})</i> {{$q->question->question}}
                                            </h5>
                                            <h5 class="badge badge-info">
                                                Mark: {{ $q->question->mark }}
                                            </h5>
                                        </div>
                                        <br>
                                        <i class="badge badge-info">
                                            Ans:({{$ind+1}})</i>
                                    @endif
                                    <input type="hidden" name="q[{{$ind}}][id]" id="q"
                                           value="{{encrypt($q->exam_question_id)}}">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-12 ml-1">
                                                        <textarea name="q[{{$ind}}][answer]"
                                                                  data-ind="q{{$ind}}" style="width: 100%; min-height: 200px"
                                                                  class="answer-text-area form-control-sm"
                                                                  data-e="{{$examInfo->exam_id}}"
                                                        ></textarea>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="wizard-footer">
                <div class="pull-right">
                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd'
                           name='next'
                           value='Next'/>
                    <input type='button' class='btn btn-finish btn-fill btn-warning btn-wd'
                           id="finish"
                           name='finish'
                           value='Finish'/>
                </div>

                <div class="pull-left">
                    <input type='button' class='btn btn-previous btn-default btn-wd' name='previous'
                           value='Previous'/>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!--                            Timer start-->
        <div class="col-md-3 d-flex justify-content-center mt-1">
            <div class="rounded-circle timer-content">
                <div class="timer-container text-center rounded-circle w-60">
                    <div class="timer-display rounded-circle bg-light p-5">
                        <span id="min" style="font-size: 30px;">00</span><span
                                style="font-size: 30px;">:</span><span id="secnd"
                                                                       style="font-size: 30px;">00</span>
                        <br>
                        <span id="timerDiv" data-time="{{$duration}}" style="color: red;font-size: 15px">Remains</span>
                    </div>
                    <div class="pulse-animation"></div>
                </div>
            </div>
        </div>
    </div>
</form>