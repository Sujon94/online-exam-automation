<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 text-white text-center bold">
                <h6>{{$exam->exam_name}}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container">
            @if($exam->questions[0]->question->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE)
                <div class="row">
                    <div class="col-md-12">
                        <h6><i class="badge badge-info">Q</i> {{$exam->questions[0]->question->question}}</h6>
                        <input type="hidden" name="q" id="q" value="{{encrypt($exam->questions[0]->exam_question_id)}}">
                        <div class="row">
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="1" id="choice1">
                                    <label class="form-check-label" for="choice1">
                                        {{$exam->questions[0]->question->choice->choice1}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="2"
                                           id="choice2">
                                    <label class="form-check-label" for="choice2">
                                        {{$exam->questions[0]->question->choice->choice2}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row choice">
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="3"
                                           id="choice3">
                                    <label class="form-check-label" for="choice3">
                                        {{$exam->questions[0]->question->choice->choice3}}
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="4"
                                           id="choice4">
                                    <label class="form-check-label" for="choice4">
                                        {{$exam->questions[0]->question->choice->choice4}}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($exam->questions[0]->question->type_id == \App\Enums\Exam\LEQuestionType::IMAGE)
                <div class="row">
                    <div class="col-md-12">
                        <h6><i class="badge badge-info">Q</i> {!! $exam->questions[0]->question->question !!}</h6>
                        <input type="hidden" name="q" id="q" value="{{encrypt($exam->questions[0]->exam_question_id)}}">
                        <div class="row">
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="1"
                                           id="preview1">
                                    <label class="form-check-label" for="preview1">
                                        <img width="70" height="70"
                                             src="data:{{$exam->questions[0]->question->choice->files[0]->doc_file_type}};base64,{{$exam->questions[0]->question->choice->files[0]->doc_file}}"
                                             alt="" class="border">
                                    </label>

                                </div>
                            </div>
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="2"
                                           id="preview2">
                                    <label class="form-check-label" for="preview2">
                                        <img width="70" height="70"
                                             src="data:{{$exam->questions[0]->question->choice->files[1]->doc_file_type}};base64,{{$exam->questions[0]->question->choice->files[1]->doc_file}}"
                                             alt="" class="border">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="3"
                                           id="preview3">
                                    <label class="form-check-label" for="preview3">
                                        <img width="70" height="70"
                                             src="data:{{$exam->questions[0]->question->choice->files[2]->doc_file_type}};base64,{{$exam->questions[0]->question->choice->files[2]->doc_file}}"
                                             alt="" class="border">
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-6 p-1">
                                <div class="form-check">
                                    <input name="answer" class="answer" type="radio" value="4"
                                           id="preview4">
                                    <label class="form-check-label" for="preview4">
                                        <img width="70" height="70"
                                             src="data:{{$exam->questions[0]->question->choice->files[3]->doc_file_type}};base64,{{$exam->questions[0]->question->choice->files[3]->doc_file}}"
                                             alt="" class="border">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="card-footer">
        <div class="container">
            @if(($exam->questions[0]->question->type_id == \App\Enums\Exam\LEQuestionType::MULTIPLE_CHOICE) || ($exam->questions[0]->question->type_id == \App\Enums\Exam\LEQuestionType::IMAGE))
                <div class="row">
                    <div class="col-md-10 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-info submit" data-e="{{$exam->exam_id}}"
                                data-i="{{$clientIp}}">submit
                        </button>
                    </div>
                </div>
            @else
                <div class="row mt-1">
                    <div class="col-1">
                        <i class="badge badge-info">Ans:</i>
                    </div>
                    <div class="col-6 ml-1">
                        <textarea name="answer" style="width: 100%; min-height: 200px" class="answer form-control-sm" data-e="{{$exam->exam_id}}"
                                  data-i="{{$clientIp}}"></textarea>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-sm btn-info submit">submit</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
