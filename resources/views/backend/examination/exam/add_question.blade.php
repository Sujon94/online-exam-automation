@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-header bg-white rounded d-flex justify-content-between">
            <span><i class="fa fa-table"></i> Tag questions to exam</span>
            <a href="{{route('exam.list')}}" class="btn btn-info btn-sm">Back</a>
        </div>
        <div class="card-body bg-success bg-opacity-25 rounded">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info bg-opacity-50 rounded">
                            Exam Name: <span
                                    class="badge badge-pill bg-success font-size-12">{{$exam->exam_name}}</span>
                        </div>
                        <div class="card-body rounded">
                            <table>
                                <tr>
                                    <td>Exam Type: <span
                                                class="badge badge-pill bg-success font-size-12">{{$exam->type->name}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Exam Date: <span
                                                class="badge badge-pill bg-success font-size-12">{{$exam->exam_date}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Question: <span
                                                class="badge badge-pill bg-success font-size-12">{{$exam->total_question}}</span>
                                        <span>(Other than skill test you can't exceed total question)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Min Pass %: <span
                                                class="badge badge-pill bg-success font-size-12">{{$exam->min_pass_percentage}}</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-info bg-opacity-50 rounded">
                            Subjects of the exam
                        </div>
                        <div class="card-body rounded table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th class="text-center">Question Selected</th>
                                    <th class="text-center">Total Mark</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($exam->subjects as $sub)
                                    <tr>
                                        <td>{{$sub->subject->name}}</td>
                                        <td class="text-center"><span
                                                    id="{{$exam->exam_id}}q{{$sub->subject->id}}">{{!empty($sub->subTotalQues) ? $sub->subTotalQues : 0}}</span></td>
                                        <td class="text-center"><span
                                                    id="{{$exam->exam_id}}m{{$sub->subject->id}}">{{!empty($sub->subTotalMark) ? $sub->subTotalMark : 0}}</span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot class="">
                                <tr>
                                    <th>Total</th>
                                    <th class="text-center"><span
                                                id="{{$exam->exam_id}}tq">{{$exam->totalQues}}</span></th>
                                    <th class="text-center"><span
                                                id="{{$exam->exam_id}}tm">{{$exam->totalMark}}</span></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center mb-1">
                    @if($exam->exam_type == \App\Enums\Exam\LExamType::SKILL_TEST || $exam->exam_type == \App\Enums\Exam\LExamType::SKILL_TEST_PAID)
                        <span class="alert-danger mb-1"><i class="fa fa-info-circle"></i>Written question will not visible in skill test!</span>
                        @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion accordion-flush" id="questionAccordion">
                        @foreach($exam->subjects as $key=>$sub)
                            <div class="accordion-item">
                                <h2 class="accordion-header bg-info bg-opacity-50 rounded" id="flush-heading{{$key}}">
                                    <button class="accordion-button collapsed bold font-size-15 white" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapse{{$key}}" aria-expanded="false"
                                            aria-controls="flush-collapse{{$key}}">
                                        Subject: {{$sub->subject->name}}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{$key}}" class="accordion-collapse collapse table-responsive"
                                     aria-labelledby="flush-heading{{$key}}" data-bs-parent="#questionAccordion">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <tr>
                                                @foreach($sub->questions as $key=>$q)
                                                    @if(($exam->exam_type == \App\Enums\Exam\LExamType::SKILL_TEST || $exam->exam_type == \App\Enums\Exam\LExamType::SKILL_TEST_PAID) && $q->type_id == \App\Enums\Exam\LEQuestionType::WRITTEN)
                                                        @continue
                                                    @endif

                                                    <td><input {{($exam->status == \App\Enums\Exam\LExamStatus::COMPLETED || $exam->status == \App\Enums\Exam\LExamStatus::RESULT_PUBLISHED) ? 'disabled' : ''}} type="checkbox" {{!empty($q->checked) ? 'checked' : ''}} class="question" data-question="{{$exam->exam_id}}#{{$sub->subject_id}}#{{$q->id}}">
                                                        @if($q->format_id == \App\Enums\Exam\LEQuestionFormat::IMAGE)
                                                            <img id="questionImgPreview"
                                                                 width="100" height="100"
                                                                 alt=""
                                                                 class="{{isset($q->file) ? (empty($q->file) ? 'd-none' : '') : 'd-none'}} border rounded mx-auto "
                                                                 src="{{isset($q->file) ? ( !empty($q->file) ? 'data:'.$q->file->doc_file_type.';base64,'.$q->file->doc_file : '') :''}}"
                                                            >
                                                        @else
                                                            {{$q->question}}
                                                        @endif
                                                        ({{$q->mark}})</td>
                                                    @if(++$key == count($sub->questions) || ($key % 4 == 0))
                                                    </tr>
                                                    @endif
                                                @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section("footer-script")
    <script src="{{ asset('backend/assets/js/pages/exam/examQuestion.js') }}"></script>
@endsection
