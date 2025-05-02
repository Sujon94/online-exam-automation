<?php

namespace App\Http\Controllers\Backend\Examination;

use App\Contract\backend\CourseContract;
use App\Contract\backend\EXamContract;
use App\Entities\backend\exam_system\ESubject;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamQuestion;
use App\Entities\backend\exam_system\LExamType;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LExamStatus;
use App\Enums\ImageType;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    private EXamContract $eXamManager;
    private CourseContract $courseManager;
    private SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct(EXamContract $eXamManager,CourseContract $courseManager, SelfDevelopmentFile $selfDevelopmentFile)
    {
        $this->eXamManager = $eXamManager;
        $this->courseManager = $courseManager;
        $this->selfDevelopmentFile = $selfDevelopmentFile;
    }

    public function index()
    {
        $subjects = ESubject::with('topics')->get();
        $examTypes = LExamType::where('active_yn','=','Y')->get();
        $course = $this->courseManager->getAllActiveCourses();
        return view("backend.examination.exam.index", compact("course","subjects", "examTypes"));
    }

    public function create(Request $request)
    {
        $response = $this->eXamManager->create($request);
        return response()->json(['response_code' => $response['response_code'], 'response_msg' => $response['response_msg']]);
    }

    public function edit($id)
    {
        $exam = $this->eXamManager->examInfo($id);
        $subjects = ESubject::with('topics')->get();
        $examTypes = LExamType::where('active_yn','=','Y')->get();
        $course = $this->courseManager->getAllActiveCourses();
        return view("backend.examination.exam.index", compact("course","subjects", "examTypes","exam"));
    }

    public function update(Request $request, $id)
    {
        $response = $this->eXamManager->update($request, $id);
        return response()->json(['response_code' => $response['response_code'], 'response_msg' => $response['response_msg']]);
    }

    public function list()
    {
        $examTypes = LExamType::where('active_yn','Y')->get();
        return view("backend.examination.exam.list",compact('examTypes'));
    }

    public function listDataTable(Request $request)
    {
        $examType = $request->post('examType');
        $data = EXam::with("subjects.subject", "questions", "type")->where('exam_type',$examType)->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('exam_name', function ($data) {
                return $data->exam_name.'<a href="'.route('exam.edit',['id'=>$data->exam_id]).'" class="pl-1"><i class="fa fa-edit"></i></a>';
            })/*->editColumn('type', function ($data) {
                return $data->type->name;
            })*/->editColumn('subject', function ($data) {
                $subjects = [];
                foreach ($data->subjects as $s) {
                    $subjects[] = $s->subject->name;
                }
                return implode(',', $subjects);
            })->editColumn('start_date', function ($data) {
                return HelperClass::dateConvert($data->exam_date);
            })->editColumn('duration', function ($data) {
                $start_time = new Carbon($data->exam_start_at);
                $end_time = new Carbon($data->exam_end_at);
                return $end_time->diffInMinutes($start_time) . ' minutes';
            })->editColumn('total_question', function ($data) {
                return '<span class="btn-info btn-sm font-weight-bold">' . count($data->questions) . '</span>';
            })->editColumn('price', function ($data) {
                return $data->price;
            })
            ->editColumn('status', function ($data) {
                if ($data->status == LExamStatus::COMPLETED){
                    return '<span class="btn btn-info btn-sm">Completed</span>';
                }elseif ($data->status == LExamStatus::RESULT_PUBLISHED){
                    return '<span class="btn btn-success btn-sm">Result Published</span>';
                }elseif ($data->status == LExamStatus::EXPIRED){
                    return '<span class="btn btn-danger btn-sm">Expired</span>';
                }elseif ($data->status == LExamStatus::UN_PUBLISHED){
                    return '<span class="btn btn-warning btn-sm">Un-published</span>';
                }else{
                    return '<select class="updateStatus form-control form-control-sm" data-e="'.$data->exam_id.'" data-d="'.$data->status.'">
                                <option value="'.LExamStatus::DRAFT.'" '.(LExamStatus::DRAFT == $data->status ? "selected" : "").'>Draft</option>
                                <option value="'.LExamStatus::PUBLISHED.'" '.(LExamStatus::PUBLISHED == $data->status ? "selected" : "").'>Publish</option>
                                <option value="'.LExamStatus::UN_PUBLISHED.'" '.(LExamStatus::UN_PUBLISHED == $data->status ? "selected" : "").'>Un-publish</option>
                            </select>';

                }
            })
            ->editColumn('action', function ($data) {
                $html = '<a href="' . route("exam.question-add", ['exam_id' => $data->exam_id]) . '" target="_blank"
                           target="_blank" data-toggle="tooltip" data-placement="top" title="Add question" class="btn btn-sm btn-info"><i
                                    class="fa fa-plus addQuestion">Question</i></a>';
                /*if ($data->exam_type != \App\Enums\Exam\LExamType::SKILL_TEST){
                    if (count($data->questions) == 0){
                        $status = "make-readonly";
                        $tooltip = "Questions not set.";
                        $button = "btn btn-light";
                    }else{
                        $status = "";
                        $tooltip = "Distribute Exam";
                        $button = "btn btn-info";
                    }
                    $html .= '<a href="' . route("exam.distribute", ['exam_id' => $data->exam_id]) . '" target="_blank"
                           data-toggle="tooltip" data-placement="top" title="'.$tooltip.'" class="btn btn-sm '.$button." ".$status.'"><i
                                    class="fa fa-wrench">Manage</i></a>';
                }*/
                return $html;
            })
            ->rawColumns(['status','exam_name','action', 'total_question'])
            ->make(true);
    }

    public function statusUpdate(Request $request)
    {
        $response = $this->eXamManager->updateStatus($request->post('examId'), $request->post('status'));
        return response()->json($response);
    }

    public function tagQuestionView($exam_id)
    {
        $exam = EXam::with('subjects', 'type')->where('exam_id', '=', $exam_id)->first();
        $tagedQuestions = EXamQuestion::where('exam_id', '=', $exam_id)->get();

        $exam->totalQues = 0;
        $exam->totalMark = 0;

        if (count($tagedQuestions) > 0) {
            foreach ($exam->subjects as $sub) {
                $sub->subTotalQues = 0;
                $sub->subTotalMark = 0;

                foreach ($sub->questions as $key => $q) {
                    foreach ($tagedQuestions as $tq) {
                        if ($tq->question_id == $q->id) {
                            $q->checked = true;
                            $sub->subTotalQues++;
                            $sub->subTotalMark += $q->mark;
                        }
                    }
                }

                $exam->totalQues += $sub->subTotalQues;
                $exam->totalMark += $sub->subTotalMark;
            }
        }

        return view('backend.examination.exam.add_question', compact('exam'));
    }

    public function tagQuestion(Request $request)
    {
        $response = $this->eXamManager->questionsMap($request);
        return response()->json($response);
    }

    public function examDistribute($examId)
    {
        $exam = EXam::with( "questions","type")->where('exam_id',$examId)->first();
        if (count($exam->questions) == 0){
            return redirect()->back()->with("warning","[".$exam->exam_name." (".$exam->type->name.")] - Questions are empty.");
        }
        $course = $this->courseManager->getAllActiveCourses();
        return view('backend.examination.exam.distribute',compact('course'));
    }

    public function download($id,$ce_image, $type=ImageType::BASE64)
    {
        $file = $this->selfDevelopmentFile->find($id);

        if ($type == ImageType::BASE64){
            $content =  base64_decode($file->doc_file);
            return response()->make($content, 200, [
                'Content-Type' => $file->doc_file_type,
                'Content-Disposition' => 'attachment;filename="'.$file->doc_file_name.'"'
            ]);
        }else{
            //$filepath =  asset('backend/assets/'.$file->social_file_path); //for cpanel
            $filepath =  asset('public/backend/assets/'.$file->social_file_path);

            return response()->make($filepath, 200, [
                'Content-Type' => $file->social_file_type,
                'Content-Disposition' => 'attachment;filename="'.$file->social_file_name.'"'
            ]);
        }

    }
}
