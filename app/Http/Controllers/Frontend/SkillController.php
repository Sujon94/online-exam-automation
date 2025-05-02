<?php

namespace App\Http\Controllers\Frontend;

use App\Contract\backend\AssessmentContract;
use App\Contract\backend\BatchScheduleContract;
use App\Contract\backend\CourseContract;
use App\Contract\backend\EXamContract;
use App\Contract\backend\ExamResultContract;
use App\Contract\backend\SkillTestContract;
use App\Contract\backend\StudentContract;
use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\exam_system\ECertificateRegister;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LEQuestionType;
use App\Enums\Exam\LExamType;
use App\Enums\LTransactionStatus;
use App\Helpers\Mpdf;
use App\Http\Controllers\Controller;
use App\Manager\backend\AssessmentManager;
use App\Manager\backend\EXamManager;
use App\Manager\backend\SkillTestManager;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    private EXamManager $eXamManager;
    private SkillTestManager $skillTestManager;
    private ExamResultContract $examResultManager;
    private BatchScheduleContract $batchScheduleManager;
    private StudentTransactionContract $studentTransactionManger;
    private AssessmentManager $assessmentManager;

    public function __construct(AssessmentContract $assessmentManager, EXamContract $EXamManager, SkillTestContract $skillTestManager, ExamResultContract $examResultManager, BatchScheduleContract $batchScheduleManager, StudentContract $studentManager, StudentTransactionContract $studentTransactionManger)
    {
        $this->assessmentManager = $assessmentManager;
        $this->eXamManager = $EXamManager;
        $this->skillTestManager = $skillTestManager;
        $this->examResultManager = $examResultManager;
        $this->batchScheduleManager = $batchScheduleManager;
        $this->studentTransactionManger = $studentTransactionManger;
    }

    public function availableTests()
    {
        $exams = $this->eXamManager->getPublishedSkillTestExams();
        return view('frontend.skill-test.skills', compact('exams'));
    }

    public function testDetail(Request $request, $e)
    {
        $examId = decrypt($e);
        $user = User::with('student_details')->where('id','=',Auth::id())->first();
        if (isset($user->student_details)){
            $examInfo = $this->eXamManager->examInfo($examId);
            $transactions = $this->studentTransactionManger->getSkillPaymentInfo($examId, $user->student_details->student_id);
            if (count($transactions) > 0){
                foreach ($transactions as $t){
                    if ($t->transaction_status_id == LTransactionStatus::PENDING){
                        $examInfo->transaction_id = $t->student_transaction_id;
                        $examInfo->transaction_status = LTransactionStatus::PENDING;
                        $examInfo->exam_participation_status = 0;
                    }elseif ($t->transaction_status_id == LTransactionStatus::APPROVED){
                        $examInfo->transaction_id = $t->student_transaction_id;
                        $examInfo->transaction_status = LTransactionStatus::APPROVED;
                        if (count($t->transaction_exam) == 0 ){
                            $examInfo->exam_participation_status = 0;
                        }else{
                            $examInfo->exam_participation_status = 1;
                        }
                    }else{
                        $examInfo = $this->eXamManager->examInfo($examId);
                        $examInfo->transaction_id = null;
                        if ($examInfo->exam_type == LExamType::SKILL_TEST_PAID){
                            $examInfo->transaction_status = LTransactionStatus::UNPAID;
                        }else{
                            $examInfo->transaction_status = LTransactionStatus::APPROVED;
                        }
                        $examInfo->exam_participation_status = 0;
                    }
                }
            }else{
                $examInfo = $this->eXamManager->examInfo($examId);
                $examInfo->transaction_id = null;
                if ($examInfo->exam_type == LExamType::SKILL_TEST_PAID){
                    $examInfo->transaction_status = LTransactionStatus::UNPAID;
                }else{
                    $examInfo->transaction_status = LTransactionStatus::APPROVED;
                }
                $examInfo->exam_participation_status = 0;
            }
        }else{
            $examInfo = $this->eXamManager->examInfo($examId);
            $examInfo->transaction_id = null;
            if ($examInfo->exam_type == LExamType::SKILL_TEST_PAID){
                $examInfo->transaction_status = LTransactionStatus::UNPAID;
            }else{
                $examInfo->transaction_status = LTransactionStatus::APPROVED;
            }
            $examInfo->exam_participation_status = 0;
        }

        /*** If skill test free remove old result. ***/
        if ($examInfo->exam_type == LExamType::SKILL_TEST){
            $this->skillTestManager->removeClientOldResults($request->ip());
        }

        $social = (object) [
            'title' => $examInfo->exam_name,
            'description' => '',
            'image' => '',
            'image_alt' => $examInfo->exam_name,
            'url' => route('skills.test-participate',['e'=>$e]),
            'fb_app_id' => ''
        ];

        return view('frontend.skill-test.skill_detail', ['exam' => $examInfo,'social'=>$social]);
    }

    public function testStart(Request $request, $e, $trans=null)
    {
        /*$examId = $e;
        $examInfo = $this->eXamManager->examInfo(decrypt($examId));
        $start_time = new Carbon($examInfo->exam_start_at);
        $end_time = new Carbon($examInfo->exam_end_at);
        $duration = $end_time->diffInSeconds($start_time);
        $clientIp = encrypt($request->ip());

        return view('frontend.skill-test.skill_test_page', compact('clientIp', 'examId', 'duration'));
  */
        $examId = decrypt($e);
        $examInfo = $this->assessmentManager->getExamQuestions($examId);
        /*$totalMark = 0;
        foreach($examInfo->questions as $q){
            $totalMark += $q->question->mark;
        }*/
        $totalMark = array_reduce((array)$examInfo->questions, function ($sum, $item){
            $s = array_reduce($item, function ($summ, $it){
                if (isset($it['mark'])){
                    return $summ+$it['mark'];
                }
                return $summ;
            },0);
            return $s+$sum;
        }, 0);

        $examStartAt = new Carbon($examInfo->exam_start_at);
        $end_time = new Carbon($examInfo->exam_end_at);
        $clientIp = encrypt($request->ip());
        $duration = $examStartAt->diffInSeconds($end_time);

        return view('backend.examination.exam-page.skill_test', compact('clientIp','examInfo','duration','trans','totalMark'));

    }

    public function postAnswer(Request $request)
    {
        $timeOut = $request->post('t_out', 'N');

        $clientIp = decrypt($request->post('ci'));
        $examId = decrypt($request->post('t'));
        $answers = $request->post('q');
        $transId = $request->post('i');
        $response = $this->skillTestManager->storeTestResult($examId, $answers, $clientIp,(isset($transId) ? decrypt($transId): null));
        /*if ($timeOut == 'Y') {
            // if timeout then finish the exam and show the result. f=1 [finished]
            $pageContent = $this->generateResult($examId, $clientIp);
            return response()->json(['c' => $pageContent, 'e_c' => 0, 'response_code' => 1, 'response_msg' => 'Success', 'f' => 1]);
        }*/
        /*        return response()->json(array_merge($response, ['f' => 0]));*/
        if ($response["response_code"] != 1){
            return response()->json(['response_code'=>99, 'response_msg'=>$response["response_msg"], 'f'=>0]);
        }else{
            $pageContent = $this->generateResult($examId, $clientIp);
            return response()->json(['c' => $pageContent, 'e_c' => 0, 'response_code' => 1, 'response_msg' => 'Success', 'f' => 1]);
        }
    }

    public function generateResult($examId, $clientIp)
    {
        $exam = $this->eXamManager->examNextQuestion($examId, (isset($questionId) ? decrypt($questionId) : null), $clientIp);
        $testResult = $this->skillTestManager->skillTestResult($examId, $clientIp);
        $examName = $exam->exam_name;
        $totalQuestion = count($testResult->toArray());
        $totalMark = 0;
        $securedMark = 0;
        foreach ($testResult as $result) {
            $totalMark += $result->exam_question->mark;
            $securedMark += (($result->status == 1) ? $result->exam_question->mark : 0);
        }
        $passRatio = round(($securedMark * 100) / $totalMark);
        $emojiPath = '';
        $resultMsg = '';
        if (($passRatio > 80) || ($passRatio == 80)) {
            $emojiPath = asset('frontend/assets/emoji/80-100.png');
            $resultMsg = 'Congrats you have secured ' . $passRatio . '% marks';
        } elseif (($passRatio < 80) && ($passRatio > 49)) {
            $emojiPath = asset('frontend/assets/emoji/50-79.png');
            $resultMsg = 'Congrats you have secured ' . $passRatio . '% mark';
        } elseif (($passRatio < 50) && ($passRatio > 38)) {
            $emojiPath = asset('frontend/assets/emoji/39-49.png');
            $resultMsg = 'Though you have secured ' . $passRatio . '% mark, you can do much better. Try next time.';
        } else {
            $emojiPath = asset('frontend/assets/emoji/0-30.png');
            $resultMsg = 'You have secured only ' . $passRatio . '% mark. You can do better if you try. Better luck next time.';
        }

        return view("frontend.skill-test.result_page", compact('examId', 'examName', 'totalQuestion', 'totalMark', 'securedMark', 'passRatio', 'emojiPath', 'resultMsg'))->render();
    }


    public function viewCert($cert)
    {
        $certificate = ECertificateRegister::where('certificate_short_code', '=', $cert)->first();
        if ($certificate) {
            $mpdf = new Mpdf();
            $data = (object)[];
            $data->transInfo = $this->studentTransactionManger->getStudentInfo($certificate->student_transaction_id);
            $data->result = $this->examResultManager->getExamResult($certificate->exam_id, $certificate->student_transaction_id);
            $data->examInfo = $this->eXamManager->examInfo($certificate->exam_id);
            $data->certInfo = $certificate;

            if ($data->examInfo->exam_type == LExamType::PROFESSIONAL_EVALUATION) {
                $duration = $this->batchScheduleManager->getBatchDuration($data->transInfo->batch->batch_id);
                $data->transInfo->batch->batch_days = $duration['day'];
                $data->transInfo->batch->batch_hour = $duration['hour'];
            }else{
                $duration = "";
            }
            $mpdf->generateReport($data->examInfo->image_file->certificate_file, $data->examInfo->image_file->certificate_type,$data->transInfo->student->candidate_name . '.pdf', 'backend.examination.exam-result.professional_cert',$data);
            exit();
        } else {
            return abort(404);
        }
    }
}
