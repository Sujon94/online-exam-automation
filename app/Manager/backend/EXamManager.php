<?php


namespace App\Manager\backend;


use App\Contract\backend\EXamContract;
use App\Entities\backend\exam_system\EQuestion;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamQuestion;
use App\Entities\backend\exam_system\EXamResult;
use App\Entities\backend\exam_system\EXamSubject;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LEQuestionType;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Enums\ParentTable;
use App\Helpers\HelperClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EXamManager implements EXamContract
{
    protected EXamQuestion $examQuestion;
    protected EXam $exam;
    protected EXamSubject $examSubject;
    protected EXamResult $examResult;
    private SelfDevelopmentFile $file;

    public function __construct()
    {
        $this->examQuestion = new EXamQuestion();
        $this->exam = new EXam();
        $this->examSubject = new EXamSubject();
        $this->examResult = new EXamResult();
    }

    public function create(Request $request)
    {

        $type = $request->post('exam_type');
        $course = $request->post('course');
        $name = htmlspecialchars($request->post('exam_name'));
        $date = $request->post('exam_date');
        $startAt = $request->post('exam_start_time');
        $endAt = $request->post('exam_end_time');
        $price = $request->post('price');
        $note = $request->post('instruction');
        //$status = $request->post('status');
        $subjects = $request->post('subject_id');
        $certAllow = $request->post('cert_allow', 'N');
        $questions = $request->post('t_question');
        $percent = $request->post('pass_per');

        $exam = new EXam();
        DB::beginTransaction();
        try {
            $exam->exam_type = $type;
            $exam->course_id = $course;
            $exam->exam_name = $name;
            $exam->exam_date = HelperClass::dateFormatForDB($date);
            $exam->exam_start_at = $startAt;
            $exam->exam_end_at = $endAt;
            $exam->price = $price;
            $exam->instruction = $note;
            $exam->allow_certificate = $certAllow;
            $exam->total_question = $questions;
            $exam->min_pass_percentage = $percent;

            //$exam->status = $status;
            $exam->save();

            if ($exam->exam_id == '') {
                DB::rollBack();
                return ['response_code' => 99, 'response_msg' => 'Exam insertion failed.'];
            }

            $examSubject = [];
            foreach ($subjects as $sub) {
                $examSubject[] = [
                    'exam_id' => $exam->exam_id,
                    'subject_id' => (int)$sub
                ];
            }

            $eSubject = EXamSubject::insert($examSubject);

            if (!$eSubject) {
                DB::rollBack();
                return ['response_code' => 99, 'response_msg' => 'Subject insertion failed.'];
            }

            /*Certificate*/
            if ($request->file()) {
                $this->file = new SelfDevelopmentFile();

                $image = $request->file('cert_image');
                if (isset($image)){
                    $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                    $fileExt = $image->getMimeType();
                    $fileName = $image->getClientOriginalName();

                    /* $social_image = $request->file('social_image');
                     $image_ext = $social_image->getMimeType();
                     $image_name = $social_image->getClientOriginalName();*/

                    $this->file->parent_table = "e_exams";
                    $this->file->parent_id = $exam->exam_id;
                    $this->file->certificate_name = $fileName;
                    $this->file->certificate_type = $fileExt;
                    $this->file->certificate_file = $byteCode;
                    $this->file->cert_img_alt_tag = $name;
                }

                $image2 = $request->file('event_image');
                if (isset($image2)/*$type == LExamType::EVENT_COMPETITION */) {
                    $byteCode2 = base64_encode(file_get_contents($image2->getRealPath()));
                    $fileExt2 = $image2->getMimeType();
                    $fileName2 = $image2->getClientOriginalName();

                    /* $social_image = $request->file('social_image');
                     $image_ext = $social_image->getMimeType();
                     $image_name = $social_image->getClientOriginalName();*/
                    $this->file->parent_table = "e_exams";
                    $this->file->parent_id = $exam->exam_id;
                    $this->file->doc_file_name = $fileName2;
                    $this->file->doc_file_type = $fileExt2;
                    $this->file->doc_file = $byteCode2;
                    $this->file->doc_img_alt_tag = $name;
                    /*$this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                    $this->file->social_file_type = $image_ext;
                    $this->file->social_file_name = $image_name;*/
                }

                /*$this->file->social_file_path = Storage::disk('public_root')->putFile('social_files',$social_image);
                $this->file->social_file_type = $image_ext;
                $this->file->social_file_name = $image_name;*/
                $this->file->save();
            }


            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Exam] - Exam Created.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function questionsMap(Request $request)
    {
        $examId = $request->post('exam');
        $questionId = $request->post('question');
        $subjectId = $request->post('subject');
        $status = $request->post('status');

        DB::beginTransaction();
        try {
            $questionInfo = EQuestion::find($questionId);
            $examQ = $this->examQuestion->where(['exam_id' => $examId, 'question_id' => $questionId])->withTrashed()->first();
            if ($status == 'a') {
                $examInfo = EXam::where('exam_id', '=', $examId)->first();
                $questions = EXamQuestion::where('exam_id', '=', $examId)->get();
                if ($examInfo->exam_type != LExamType::SKILL_TEST and $examInfo->exam_type != LExamType::SKILL_TEST_PAID) {
                    if ($examInfo->total_question == $questions->count()) {
                        return ['response_code' => 99, 'response_msg' => 'Max question reached can\'t add more question.'];
                    }
                }
                if (!empty($examQ->exam_question_id)) {
                    $examQ->question_name = $questionInfo->question;
                    $examQ->mark = $questionInfo->mark;
                    $examQ->negative_mark = $questionInfo->negative_mark;
                    $examQ->deleted_at = null;
                    $examQ->save();
                } else {
                    $this->examQuestion->exam_id = $examId;
                    $this->examQuestion->question_id = $questionId;
                    $this->examQuestion->question_name = $questionInfo->question;
                    $this->examQuestion->mark = $questionInfo->mark;
                    $this->examQuestion->negative_mark = $questionInfo->negative_mark;
                    $this->examQuestion->save();
                }
            } else {
                if (!empty($examQ->exam_question_id)) {
                    $examQ->delete();
                } else {
                    DB::rollBack();
                    return ['response_code' => 99, 'response_msg' => 'Question not tagged to untag.'];
                }
            }
            //Sorry for writing raw query
            $result = DB::selectOne("
                select count(question_id)       as subTotalQuestion,
                       IFNULL(sum(q.mark),0)              as subTotalMark,
                       (select IFNULL(sum(seq.mark),0)
                        from e_exam_questions seq
                        where seq.exam_id = :p_1 and seq.deleted_at is null) as totalMark,
                       (select count(seq.question_id)
                        from e_exam_questions seq
                        where seq.exam_id = :p_2 and seq.deleted_at is null) as totalQuestion
                from e_exam_questions eq
                         join e_questions q on eq.question_id = q.id
                where q.subject_id = :p_3
                  and eq.exam_id = :p_4 and eq.deleted_at is null
            ", ['p_1' => $examId, 'p_2' => $examId, 'p_4' => $examId, 'p_3' => $subjectId]);

            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Question] - Status Updated.', 'extra_data' => $result];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function examInfo(int $examId)
    {
        return $this->exam->with(['subjects', 'image_file', 'type'])
            ->where('exam_id', $examId)->first();
    }

    public function update(Request $request, int $examId)
    {
        $type = $request->post('exam_type');
        $course = $request->post('course');
        $name = htmlspecialchars($request->post('exam_name'));
        $date = $request->post('exam_date');
        $startAt = $request->post('exam_start_time');
        $endAt = $request->post('exam_end_time');
        $price = $request->post('price');
        $note = $request->post('instruction');
        //$status = $request->post('status');
        $subjects = $request->post('subject_id');
        $certAllow = $request->post('cert_allow', 'N');
        $questions = $request->post('t_question');
        $percent = $request->post('pass_per');

        $exam = $this->exam->find($examId);
        DB::beginTransaction();
        try {
            $exam->exam_type = $type;
            $exam->course_id = $course;
            $exam->exam_name = $name;
            $exam->exam_date = HelperClass::dateFormatForDB($date);
            $exam->exam_start_at = $startAt;
            $exam->exam_end_at = $endAt;
            $exam->price = $price;
            $exam->instruction = $note;
            //$exam->status = $status;
            $exam->allow_certificate = $certAllow;
            $exam->total_question = $questions;
            $exam->min_pass_percentage = $percent;
            $exam->save();

            if ($exam->exam_id == '') {
                DB::rollBack();
                return ['response_code' => 99, 'response_msg' => 'Exam update failed.'];
            }

            $this->examSubject->where('exam_id', $examId)->delete();
            $examSubject = [];
            foreach ($subjects as $sub) {
                $examSubject[] = [
                    'exam_id' => $exam->exam_id,
                    'subject_id' => (int)$sub
                ];
            }

            $eSubject = EXamSubject::insert($examSubject);

            if (!$eSubject) {
                DB::rollBack();
                return ['response_code' => 99, 'response_msg' => 'Subject update failed.'];
            }

            $cert = $request->file('cert_image');
            $image = $request->file('event_image');
//            $social_image = $request->file('social_image');
            $this->file = SelfDevelopmentFile::where(['parent_table' => ParentTable::E_EXAM, 'parent_id' => htmlspecialchars($examId)])->first() ?? new SelfDevelopmentFile();
            if (isset($image)) {
                $byteCode = base64_encode(file_get_contents($image->getRealPath()));
                $fileExt = $image->getMimeType();
                $fileName = $image->getClientOriginalName();

                $this->file->parent_table = 'e_exams';
                $this->file->parent_id = $examId;
                $this->file->doc_file_name = $fileName;
                $this->file->doc_file_type = $fileExt;
                $this->file->doc_file = $byteCode;
                $this->file->save();
            }

            if (isset($cert)) {
                $byteCode = base64_encode(file_get_contents($cert->getRealPath()));
                $fileExt = $cert->getMimeType();
                $fileName = $cert->getClientOriginalName();

                $this->file->parent_table = 'e_exams';
                $this->file->parent_id = $examId;
                $this->file->certificate_name = $fileName;
                $this->file->certificate_type = $fileExt;
                $this->file->certificate_file = $byteCode;
                $this->file->cert_img_alt_tag = $name;
                $this->file->save();
            }

            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Exam] - Exam Updated.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function updateStatus($examId, $status)
    {
        $examInfo = $this->exam->with('questions')->find($examId);
        /* if ($this->exam->exam_type == LExamType::PROFESSIONAL_EVALUATION){
             $examDate = Carbon::create($this->exam->exam_date);
             if ($examDate->lt(Carbon::now())){
                 return ['response_code' => 99, 'response_msg' => 'Exam is '];
             }
         }*/
        $questions = $examInfo->questions;
        if ((count($questions) == 0) && $status = LExamStatus::PUBLISHED) {
            return ['response_code' => 99, 'response_msg' => '[Exam] - Question set is empty. Can not publish the exam.'];
        }

        try {
            DB::beginTransaction();
            $examInfo->status = $status;
            $examInfo->save();
            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Exam] - Status updated.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function getPublishedSkillTestExams()
    {
        return $this->exam
            ->with('image_file')
            ->whereHas('questions')
            ->whereIn('exam_type', [LExamType::SKILL_TEST, LExamType::SKILL_TEST_PAID])
            ->where(['status' => LExamStatus::PUBLISHED])
            ->get();
    }

    public function examNextQuestion($examId, $eQuestionId, $clientIp)
    {
        return $this->exam->with(['questions' => function ($q) use ($eQuestionId, $clientIp) {
            $q->whereNotIn('exam_question_id',
                EXamResult::select('exam_question_id')->where('ip', $clientIp)->get()->toArray()
            )->inRandomOrder()->limit(1);
        }])->whereHas('questions')
            ->where('exam_id', $examId)
            ->first();
    }

    public function getPublishedExams()
    {
        return $this->exam
            ->whereHas('questions')
            ->where(['exam_type' => LExamType::PROFESSIONAL_EVALUATION, 'status' => LExamStatus::PUBLISHED])
            ->get();
    }

    public function getExamsOnStatus($status)
    {
        $exams = $this->exam
            ->whereHas('questions')
            ->whereNotIn('exam_type', [LExamType::SKILL_TEST])
            ->where(['status' => $status])
            ->get();

        foreach ($exams as $exam) {
            $exam->participants = 0;
            $exam->multiple_choice = 0;
            $exam->image = 0;
            $exam->written = 0;
            $result = DB::selectOne("
            select count(t.student_trans_id) as participant
            from (
                     select student_trans_id, count(distinct exam_id)
                     from e_exam_result
                     where exam_id = :p
                     group by student_trans_id
                 ) as t
            ", ["p" => $exam->exam_id]);
            $exam->participants = $result->participant;

            foreach ($exam->questions as $q) {
                if ($q->question->type_id == LEQuestionType::MULTIPLE_CHOICE) {
                    $exam->multiple_choice += 1;
                } elseif ($q->question->type_id == LEQuestionType::IMAGE) {
                    $exam->image += 1;
                } else {
                    $exam->written += 1;
                }
            }
        }
        return $exams;
    }
}