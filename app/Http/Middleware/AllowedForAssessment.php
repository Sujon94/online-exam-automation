<?php

namespace App\Http\Middleware;

use App\Contract\backend\AssessmentContract;
use App\Contract\backend\EXamContract;
use App\Entities\backend\exam_system\EXamResult;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Enums\ValidateMsg;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AllowedForAssessment
{
    protected AssessmentContract $assessmentManager;
    protected EXamContract $examManager;

    public function __construct(AssessmentContract $assessmentManager, EXamContract $examManager)
    {
        $this->assessmentManager = $assessmentManager;
        $this->examManager = $examManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $param = $request->route()->parameters();
        $examId = decrypt($param['exam']);
        $transId = decrypt($param['trans']);

        $examInfo = $this->examManager->examInfo($examId);
        $currentDate = new Carbon();
        $examStartAt = new Carbon($examInfo->exam_date. $examInfo->exam_start_at);
        $examEndAt = new Carbon($examInfo->exam_date. $examInfo->exam_end_at);
        $user = User::where('id',Auth::id())->first();
        $studentId = $user->parent_table_id;

        $examRes = EXamResult::where(['exam_id'=>$examId,'student_trans_id'=>$transId])->first();

        if (!$this->assessmentManager->isStudentAllowedInExam($studentId, $transId, $examId)){
            return redirect()->route('page-not-allowed',['message'=>Crypt::encryptString(ValidateMsg::PAGE_NOT_ALLOWED_MSG)]);
        }elseIf($examInfo->status != LExamStatus::PUBLISHED){
            return redirect()->route('page-not-allowed',['message'=>Crypt::encryptString(ValidateMsg::PAGE_NOT_ALLOWED_MSG)]);
        }elseif (!in_array($examInfo->exam_type, [LExamType::SKILL_TEST/*, LExamType::EVENT_COMPETITION_FREE*/ , LExamType::SKILL_TEST_PAID]) &&$currentDate->lt($examStartAt)){
            return redirect()->route('parking-page',['message'=>Crypt::encryptString(ValidateMsg::EXAM_IS_NOT_STARTED_MSG.' Exam will start at '.$examStartAt->format("d-m-Y g:i A")),'departure'=>$examStartAt->format("d-m-Y g:i A"),'requested_url'=>Crypt::encryptString(url()->full())]);
        }elseif (!in_array($examInfo->exam_type, [LExamType::SKILL_TEST/*, LExamType::EVENT_COMPETITION_FREE*/ , LExamType::SKILL_TEST_PAID]) &&$currentDate->gt($examEndAt)){
            return redirect()->route('page-not-allowed',['message'=>Crypt::encryptString(ValidateMsg::EXAM_EXPIRED_MSG)]);
        }elseif(isset($examRes)){
            return redirect()->route('page-not-allowed',['message'=>Crypt::encryptString(ValidateMsg::EXAM_ALREADY_PARTICIPATED_MSG)]);
        }else{
            return $next($request);
        }
    }
}
