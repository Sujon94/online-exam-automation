<?php


namespace App\Manager\backend;


use App\Contract\backend\AssessmentContract;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamQuestion;
use App\Entities\backend\exam_system\EXamResult;
use App\Entities\backend\exam_system\EXamSubject;
use App\Entities\backend\StudentTransaction;
use App\Enums\Exam\ExamResultStatus;
use App\Enums\Exam\LEQuestionType;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Enums\LTransactionStatus;
use App\Traits\RegisterCertificateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssessmentManager implements AssessmentContract
{
    use RegisterCertificateTrait;

    protected EXamQuestion $examQuestion;
    protected EXam $exam;
    protected EXamSubject $examSubject;
    protected EXamResult $examResult;

    public function __construct()
    {
        $this->exam = new EXam();
        $this->examSubject = new EXamSubject();
    }

    public function isStudentAllowedInExam($studentId, $transId, $examId): bool
    {
        $this->exam = $this->exam->where('exam_id', '=', $examId)->first();
        if (($this->exam->exam_type == LExamType::EVENT_COMPETITION) || ($this->exam->exam_type == LExamType::SKILL_TEST_PAID) ) {
            $studentExam = StudentTransaction::where(['student_transaction_id' => $transId, 'exam_id' => $examId, 'student_id' => $studentId])->first();
        } else {
            $studentExam = StudentTransaction::with('batch')->whereHas("batch", function ($q) use ($examId) {
                $q->with('course')->whereHas('course', function ($r) use ($examId) {
                    $r->with('exams')->whereHas('exams', function ($e) use ($examId) {
                        $e->where(['exam_id' => $examId]);
                    });
                });
            })->where(["student_id" => $studentId, "student_transaction_id" => $transId, "transaction_status_id" => LTransactionStatus::APPROVED])->first();
        }


        return isset($studentExam);
    }

    public function examNextQuestion($examId, $eQuestionId, $studentId)
    {
        $query = $this->exam->with(['questions' => function ($q) use ($studentId) {
            $q->whereNotIn('exam_question_id',
                EXamResult::select('exam_question_id')
                    ->where('student_id', $studentId)
                    ->where('status', function ($p) {
                        $p->where('status', 0)
                            ->orWhere('status', 1);
                    })->get()->toArray()
            )->limit(1);
        }])->whereHas('questions')
            ->where('exam_id', $examId);
        if (isset($eQuestionId)) {
            $query->where('exam_question_id', '=', $eQuestionId);
        }
        return $query->first();
    }

    public function getExamQuestions($examId)
    {
        $limit = DB::selectOne("select total_question from e_exams where exam_id = $examId");

        return $this->exam->with(['type','questions'=>function($q) use($limit){
            $q->inRandomOrder();
            $q->limit($limit->total_question);
        }])
            ->whereHas('questions')
            ->where('exam_id', $examId)
            ->first();
    }

    public function submitAssessment($transId, $examId, $answers): array
    {
        $examResult = EXamResult::where(['exam_id'=>$examId,'student_trans_id'=>$transId])->get();
        if (count($examResult) > 0){
            return ['response_code' => 99, 'response_msg' => 'You have already participated in the exam using other device.'];
        }

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
                $this->examResult->answer = $answer;
                $this->examResult->status = $pass;
                $this->examResult->mark = ($questionObj->question->type_id == LEQuestionType::WRITTEN || $pass == ExamResultStatus::FAILED) ? 0 : $questionObj->mark;
                $this->examResult->student_trans_id = $transId;
                $this->examResult->save();
            }

            $exam = EXam::where(['exam_id' => $examId])->first();
            if (($exam->exam_type == LExamType::SKILL_TEST_PAID) && ($exam->allow_certificate == 'Y')) {
                if (!$this->registerByTransaction($examId, $transId)) {
                    DB::rollBack();
                    throw new \Exception('Certificate generation error');
                }
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

    }

    public function getUpComingPublishedExams($studentId): array
    {
        return DB::select('
        Select e.exam_id, e.exam_name, e.status, e.exam_date, e.exam_start_at, e.exam_end_at, st.student_transaction_id as trans_id
from student_transactions st
         join batches b on st.batch_id = b.batch_id
         join courses c on b.course_id = c.course_id
         join e_exams e on c.course_id = e.course_id and e.exam_type = :et and e.status in (:st)
where st.student_id = :p and st.transaction_status_id = :q
  and ((e.exam_date > curdate() or e.exam_date = curdate()) 
      and e.exam_id not in(select distinct r.exam_id from e_exam_result r where r.exam_id = e.exam_id and r.student_trans_id = st.student_transaction_id))',
            ["et" => LExamType::PROFESSIONAL_EVALUATION, "st" => LExamStatus::PUBLISHED, "p" => $studentId, "q" => LTransactionStatus::APPROVED]);
    }

    public function getParticipatedExams($studentId)
    {
        return DB::select('
        Select distinct e.exam_id, 
                        e.exam_name,
                        e.status,
                        e.exam_date,
                        e.exam_start_at,
                        e.exam_end_at,
                        st.student_transaction_id as trans_id
from student_transactions st
         join batches b on st.batch_id = b.batch_id
         join courses c on b.course_id = c.course_id
         join e_exams e on c.course_id = e.course_id and e.exam_type = :et and e.status in (2,3,4)
        join e_exam_result er
              on e.exam_id = er.exam_id and st.student_transaction_id = er.student_trans_id
where st.student_id = :p
  and (e.exam_date < curdate() or e.exam_date = curdate())
  order by e.exam_id desc ',
            ["et" => LExamType::PROFESSIONAL_EVALUATION, "p" => $studentId]);
    }

    public function getPublishedEvents($studentId)
    {
        return DB::select('
        Select e.exam_id, 
               e.exam_name,
               e.status,
               e.exam_date,
               e.exam_start_at,
               e.exam_end_at,
               st.student_transaction_id as trans_id,
               case
                when st.student_transaction_id is null then "<span class=\'badge badge-danger\'>Not Paid</span>"
                when st.transaction_status_id = 1 then "<span class=\'badge badge-warning\'>Pending</span>"
                when st.transaction_status_id = 2 then "<span class=\'badge badge-success\'>Approved</span>"
                else "Rejected"
                end as trans_status,
               st.transaction_status_id
from e_exams e  
left join student_transactions st on e.exam_id = st.exam_id and st.payment_for = 2 and st.student_id = :p1
where e.exam_type = :et and e.status in (:st)
    and ((e.exam_date > curdate() or e.exam_date = curdate())
    and e.exam_id not in(
        select distinct r.exam_id
        from e_exam_result r 
        where r.exam_id = e.exam_id 
          and r.student_trans_id =st.student_transaction_id))',
            ["et" => LExamType::EVENT_COMPETITION, "st" => LExamStatus::PUBLISHED, "p1" => $studentId]);
    }

    public function getParticipatedEvents($studentId)
    {
        return DB::select('
        Select distinct e.exam_id,
                        e.exam_name,
                        case 
                            /*when e.status = 3 then "<span class=\'badge badge-success\'>Pending</span>"*/
                            when e.status = 4 then "<span class=\'badge badge-success\'>Published</span>"
                            else "<span class=\'badge badge-info\'>Not Published</span>"
                        end as exam_status,
                        e.exam_date,
                        e.exam_start_at,
                        e.exam_end_at,
                        st.student_transaction_id as trans_id,
                        e.status
        from student_transactions st
        join e_exams e on st.exam_id = e.exam_id and e.exam_type = :et and e.status in (2,3,4)
        join e_exam_result er
              on e.exam_id = er.exam_id and st.student_transaction_id = er.student_trans_id
        where st.student_id = :p
  and (e.exam_date < curdate() or e.exam_date = curdate())
        order by e.exam_id desc ',
            ["et" => LExamType::EVENT_COMPETITION, "p" => $studentId]);
    }

    public function getPaidPendingSkills($studentId): array
    {
        return DB::select("
                            SELECT *
                            FROM student_transactions st
                            join e_exams e on st.exam_id = e.exam_id
                            where st.student_id = :p_student1
                            and st.payment_for in (2,3) and st.transaction_status_id in (1,2) 
                            and st.student_transaction_id not in
                            (
                              select er.student_trans_id
                              from e_exam_result er
                              join e_exams ee on er.exam_id = ee.exam_id
                              where er.student_trans_id = st.student_transaction_id
                              and ee.exam_type = 3
                            )
                            ",['p_student1'=>$studentId]);
    }

    public function getAttendedSkills($studentId) : array
    {
        return DB::select("
                            SELECT distinct e.exam_id, e.exam_name, st.student_transaction_id, date(r.created_at) as participation_date
                            FROM student_transactions st
                            join e_exams e on st.exam_id = e.exam_id
                            join e_exam_result r on st.student_transaction_id = r.student_trans_id
                            where st.student_id = :p_student1
                            and st.payment_for in (2,3) and st.transaction_status_id = 2 
                            and st.student_transaction_id in
                            (
                              select er.student_trans_id
                              from e_exam_result er
                              join e_exams ee on er.exam_id = ee.exam_id
                              where er.student_trans_id = st.student_transaction_id
                              and ee.exam_type = 3
                            )
                            ",['p_student1'=>$studentId]);
    }
}