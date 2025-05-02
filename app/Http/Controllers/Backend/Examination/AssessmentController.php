<?php


namespace App\Http\Controllers\Backend\Examination;


use App\Contract\backend\AssessmentContract;
use App\Contract\backend\EXamContract;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LEQuestionType;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    protected $assessmentManager;
    protected $examManager;

    public function __construct(AssessmentContract $assessmentManager, EXamContract $examManager)
    {
        $this->assessmentManager = $assessmentManager;
        $this->examManager = $examManager;
    }

    public function detail($examId,$transId)
    {
        $examId = decrypt($examId);
        $examInfo = $this->examManager->examInfo($examId);

        $start_time = new Carbon($examInfo->exam_start_at);
        $end_time = new Carbon($examInfo->exam_end_at);
        $examInfo->requiredTime = $end_time->diffInMinutes($start_time) . ' minutes';
        return view('backend.examination.exam-page.assessment_rules', ['exam' => $examInfo,'trans'=>$transId]);
    }

    public function start(Request $request, $exam, $trans)
    {
        $examId = decrypt($exam);
        $examInfo = $this->assessmentManager->getExamQuestions($examId);
        $totalMark = array_reduce((array)$examInfo->questions, function ($sum, $item){
            $s = array_reduce($item, function ($summ, $it){
                if (isset($it['mark'])){
                    return $summ+$it['mark'];
                }
                return $summ;
            },0);
            return $s+$sum;
        }, 0);
        $clientIp = encrypt($request->ip());
        if ($examInfo->type->maintain_date_time_yn == 'Y'){
            $currentDate = new Carbon();
            $examStartAt = new Carbon($examInfo->exam_date. $examInfo->exam_start_at);
            $diffSecond = 0;
            if ($currentDate->gt($examStartAt)){
                $diffSecond = $currentDate->diffInSeconds($examStartAt);
            }
            //$start_time = new Carbon($examInfo->exam_start_at);
            $end_time = new Carbon($examInfo->exam_end_at);
            $duration = $examStartAt->diffInSeconds($end_time) - $diffSecond;
        }else{
            $start_time = new Carbon($examInfo->exam_start_at);
            $end_time = new Carbon($examInfo->exam_end_at);
            $duration =  $end_time->diffInSeconds($start_time);
        }
        return view('backend.examination.exam-page.assessment_page', compact('examInfo','duration','trans','clientIp','totalMark'));
    }

    public function postAnswer(Request $request, $examId, $transId)
    {
        try {
            $transId = decrypt($request->post('i'));
            $user = User::where('id',Auth::id())->first();
            $examId = decrypt($examId);
            //$examInfo = $this->examManager->examInfo($examId);
            $answers = $request->post('q');
            $response = $this->assessmentManager->submitAssessment($transId, $examId, $answers);

            if ($response["response_code"] != 1){
                return response()->json(['response_code'=>99, 'response_msg'=>$response["response_msg"],'redirect'=>route('user-home')]);
            }else{
                return response()->json(['response_code'=>1, 'response_msg'=>'Exam submitted. You will get the result while it will publish.','redirect'=>route('user-home')]);
            }
        }catch (\Exception $e){
            return response()->json(['response_code'=>99, 'response_msg'=>$e->getMessage(),'redirect'=>route('user-home')]);
        }
    }
}