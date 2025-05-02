<?php


namespace App\Manager\backend;


use App\Contract\backend\SkillTestContract;
use App\Entities\backend\exam_system\EXamQuestion;
use App\Entities\backend\exam_system\EXamResult;
use App\Enums\Exam\ExamResultStatus;
use App\Enums\Exam\LEQuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillTestManager implements SkillTestContract
{
    protected EXamResult $examResult;
    protected EXamQuestion $examQuestion;
    protected EXamResult $EXamResult;

    protected int $examQuestionId;
    protected string $answer;
    protected string $clientIp;


    public function __construct(EXamResult $EXamResult, EXamQuestion $examQuestion, EXamResult $examResult)
    {
        $this->examResult = $EXamResult;
        $this->examQuestion = $examQuestion;
        $this->EXamResult = $examResult;

    }

    public function storeTestResult($examId, $answers, $clientIp, $transId=null)
    {
        DB::beginTransaction();
        try {
            foreach ($answers as $q) {
                $examQuestionId = decrypt($q["id"]);
                $answer = array_key_exists('answer', $q) ? (isset($q['answer'])? $q['answer'] :'') : '';
                $pass = ExamResultStatus::FAILED; //Failed
                $this->examQuestion = new EXamQuestion();
                $questionObj = $this->examQuestion->with('question')
                    ->where('exam_question_id', $examQuestionId)->first();
                if ($questionObj->question->type_id == LEQuestionType::MULTIPLE_CHOICE || $questionObj->question->type_id == LEQuestionType::IMAGE) {
                    if ($questionObj->question->choice->answer == $answer) {
                        $pass = ExamResultStatus::PASSED; //Passed
                    }
                } else {
                    $pass = ExamResultStatus::MANUAL_CHECk;
                }

                $this->examResult = new EXamResult();
                $this->examResult->exam_id = $examId;
                $this->examResult->exam_question_id = $examQuestionId;
                $this->examResult->student_trans_id = $transId;
                $this->examResult->answer = $answer;
                $this->examResult->status = $pass;
                $this->examResult->ip = $clientIp;
                $this->examResult->save();
            }
            DB::commit();
            return ['response_code' => 1, 'response_msg' => 'Okay'];
        } catch (\Exception $e) {
            DB::rollBack();

            DB::statement('CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);',
                ['p_exception' => $e->getMessage().'||'.$e->getCode().'||'.$e->getLine().'||'.$e->getTraceAsString(),
                    'p_entity'=>'e_exam_result',
                    'p_user_id'=>Auth::id()]);

            return ['response_code' => 99, 'response_msg' => 'Something Went Wrong.'];
        }
        /*$this->examQuestionId = $examQuesId;
        $this->answer = (is_null($answer) ? '' : $answer);
        $this->clientIp = $clientIp;
        $pass = 0;

        $questionObj = $this->examQuestion->with('question')
            ->where('exam_question_id',$this->examQuestionId)->first();
        if ($questionObj->question->type_id == LEQuestionType::MULTIPLE_CHOICE || $questionObj->question->type_id == LEQuestionType::IMAGE){
             if ($questionObj->question->choice->answer == $this->answer){
                 $pass = 1;
             }
        }

        $this->examResult->exam_question_id = $this->examQuestionId;
        $this->examResult->answer = $this->answer;
        $this->examResult->status = $pass;
        $this->examResult->ip = $this->clientIp;
        $this->examResult->save();
        return ['response_code'=>1,'response_msg'=>'Okay'];*/
    }

    public function skillTestResult($examId, $clientIp)
    {
        return $this->EXamResult
            ->with('exam_question')
            ->whereHas('exam_question',function ($e) use($examId){
                $e->where('exam_id',$examId);
            })
            ->where('ip',$clientIp)
            ->get();
    }

    public function removeClientOldResults($clientIp)
    {
        return $this->EXamResult->where('ip',$clientIp)->delete();
    }
}