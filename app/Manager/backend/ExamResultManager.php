<?php


namespace App\Manager\backend;


use App\Contract\backend\ExamResultContract;
use App\Entities\backend\exam_system\ECertificateRegister;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamResult;
use App\Enums\Exam\ExamResultStatus;
use App\Enums\Exam\LEQuestionType;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Helpers\HelperClass;
use App\Traits\RegisterCertificateTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultManager implements ExamResultContract
{
    use RegisterCertificateTrait;

    public function getParticipantsList($examId)
    {
        return EXamResult::select('exam_id', 'student_trans_id')
            ->where('exam_id', $examId)
            ->with(['participant.student', 'exam_info'])
            ->groupBy('exam_id', 'student_trans_id')
            ->get();
    }

    public function getExamResult($examId, $transId)
    {
        return EXamResult::where(["exam_id" => $examId, "student_trans_id" => $transId])->get();
    }

    public function publishExamResult($examId): array
    {
        $writtenAnswers = EXamResult::where(['exam_id' => $examId, 'status' => 2])->get();
        if ($writtenAnswers->count() > 0) {
            return ['response_code' => 99, 'response_msg' => 'Please judge the written answers first, than publish the result.'];
        }
        DB::beginTransaction();
        try {
            $exam = EXam::where(['exam_id' => $examId, 'status' => LExamStatus::COMPLETED])
                ->update(['status' => LExamStatus::RESULT_PUBLISHED]);
            if ($exam == 1) {
                $exam = EXam::where(['exam_id' => $examId, 'status' => LExamStatus::RESULT_PUBLISHED])->first();
                if ($exam->allow_certificate == 'Y') {
                    if (!$this->registerByExamId($examId)) {
                        DB::rollBack();
                        return ['response_code' => 99, 'response_msg' => 'Certificate generation error'];
                    }
                }
            }
            DB::commit();
            return ['response_code' => 1, 'response_msg' => 'Result is published.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => $e->getMessage()];
        }
    }



    public function getExamResultDetail($examId, $transId): array
    {
        return DB::select('
select 
es.name as subject
,et.name as topic
, if(eer.status = 1, sum(eer.mark), 0 )  as achived_mark
FROM e_exam_result eer
JOIN e_exam_questions eeq on eer.exam_question_id = eeq.exam_question_id
join e_questions eq on eeq.question_id = eq.id
join e_subjects es on eq.subject_id = es.id
join e_topic et on eq.topic_id = et.id
WHERE eer.exam_id =:p_exam_id and eer.student_trans_id = :p_trans_id and eer.status=1
group by es.id, es.name, et.id, et.name, eer.status
        ', ["p_exam_id" => $examId, "p_trans_id" => $transId]);
    }

    public function getStudentWrittenAnswers($examId, $transId): array
    {
        return DB::select('
        select eq.question, eq.id, eer.exam_result_id,eer.mark as result_mark, eq.mark as question_mark, eer.answer, leqt.type
        FROM e_exam_result eer
        JOIN e_exam_questions eeq on eer.exam_question_id = eeq.exam_question_id
        join e_questions eq on eeq.question_id = eq.id
        join l_e_question_types leqt on eq.type_id = leqt.id
        WHERE  eer.exam_id =:p_exam_id and eer.student_trans_id = :p_trans_id and 
              eq.type_id=:q_type
        ', ["p_exam_id" => $examId, "p_trans_id" => $transId, "q_type" => LEQuestionType::WRITTEN]);
    }

    public function storeReviewedAnswers(Request $request): array
    {
        DB::beginTransaction();
        try {
            foreach ($request->post('q') as $q) {
                $exam = EXamResult::with("exam_info")->where('exam_result_id', '=', $q['id'])->first();
                if ($exam->exam_info->status != LExamStatus::COMPLETED){
                    DB::rollBack();
                    return ['response_code' => 99, 'response_msg' => 'Result is already published. Can not modify the data.'];
                }
                $passStatus = ExamResultStatus::FAILED;
                if ($q['mark'] > 0) {
                    $passStatus = ExamResultStatus::PASSED;
                } else {
                    $passStatus = ExamResultStatus::FAILED;
                }
                EXamResult::where('exam_result_id', '=', $q['id'])
                    ->update(['mark' => $q['mark'], 'status' => $passStatus]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => $e->getMessage()];
        }
        DB::commit();
        return ['response_code' => 1, 'response_msg' => 'Okay'];
    }
}