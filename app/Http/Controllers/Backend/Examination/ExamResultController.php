<?php


namespace App\Http\Controllers\Backend\Examination;


use App\Contract\backend\EXamContract;
use App\Contract\backend\ExamResultContract;
use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamQuestion;
use App\Entities\backend\StudentTransaction;
use App\Enums\Exam\LExamStatus;
use App\Http\Controllers\Controller;
use App\Manager\backend\ExamResultManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExamResultController extends Controller
{
    private EXamContract $examManager;
    private ExamResultContract $examResultManager;
    private StudentTransactionContract $transactionManager;

    public function __construct(StudentTransactionContract $transactionManager, EXamContract $examManager, ExamResultContract $examResultManager)
    {
        $this->examManager = $examManager;
        $this->examResultManager = $examResultManager;
        $this->transactionManager = $transactionManager;
    }

    public function index()
    {
        return view("backend.examination.exam-result.index");

        /*$exams = $this->examManager->getPublishedExams();
        return view("backend.examination.exam-result.student_list", compact('exams'));*/
    }

    public function studentList($examId)
    {
        $students = $this->examResultManager->getParticipantsList(Crypt::decrypt($examId));
        return view("backend.examination.exam-result.student_list", compact('students', 'examId'));
    }

    public function examResultExport($examId)
    {
        $students = $this->examResultManager->getParticipantsList(Crypt::decrypt($examId));
        $examInfo = $this->examManager->examInfo(Crypt::decrypt($examId));

        $exCelData[] = ['SERIAL','STUDENT NAME', 'MOBILE', 'EMAIL', 'TOTAL MARK', 'MARK ACHIEVED', 'MIN PASS PERCENT', 'ACHIEVED PERCENT'];
        foreach ($students as $key=>$stu) {
            $closure = function () use ($examId, $stu) {
                $data = [];
                $result = $this->examResultManager->getExamResult(Crypt::decrypt($examId), $stu->student_trans_id);
                foreach ($result as $res) {
                    $data = [
                        'totalAnswered' => (isset($data['totalAnswered']) ? ($data['totalAnswered'] + (isset($res->answer) ? 1 : 0)) : (isset($res->answer) ? 1 : 0)),
                        'wrongAnswered' => (isset($data['wrongAnswered']) ? ($data['wrongAnswered'] + (($res->status == 0) ? 1 : 0)) : (($res->status == 0) ? 1 : 0)),
                        'correctAnswered' => (isset($data['correctAnswered']) ? ($data['correctAnswered'] + (($res->status == 1) ? 1 : 0)) : (($res->status == 1) ? 1 : 0)),
                        'totalMarkAchieved' => (isset($data['totalMarkAchieved']) ? ($data['totalMarkAchieved'] + (($res->status == 1) ? $res->mark : 0)) : (($res->status == 1) ? $res->mark : 0)),
                        'needToManualCheck' => (isset($data['needToManualCheck']) ? ($data['needToManualCheck'] + (($res->status == 2) ? 1 : 0)) : (($res->status == 2) ? 1 : 0))
                    ];
                }
                return $data;
            };
            $eResult = $closure();
            $exCelData[] = [
                'SERIAL' => ++$key,
                'STUDENT NAME' => $stu->participant->student_name,
                'MOBILE' => $stu->participant->mobile,
                'EMAIL' => $stu->participant->student->email,
                'TOTAL MARK' => $examInfo->questions->sum("mark"),
                'MARK ACHIEVED' => $eResult['totalMarkAchieved'],
                'MIN PASS PERCENT' => $examInfo->min_pass_percentage.'%',
                'ACHIEVED PERCENT' => floor(($eResult['totalMarkAchieved'] / $examInfo->questions->sum("mark")) * 100).'%'
            ];
        }

        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->getHeaderFooter()->setOddHeader('&C&BEvent Competition');
            $spreadSheet->getActiveSheet()->fromArray($exCelData);

            $excel = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$examInfo->exam_name.'.xls"');
            header('Cache-Control: max-age=0');
            ob_end_clean();

            $excel->save('php://output');
            exit();
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    public function getAnswers($examId = 22, $transId = 30): \Illuminate\Http\JsonResponse
    {
        $questions = $this->examResultManager->getStudentWrittenAnswers($examId, $transId);
        $view = view("backend.examination.exam-result.result_judge", compact("questions", "examId", "transId"))->render();
        return response()->json(['content' => $view, 'response_code' => 1]);
    }

    public function submitMarks(Request $request)
    {
        $response = $this->examResultManager->storeReviewedAnswers($request);
        return response()->json(['response_code' => $response['response_code'], 'response_msg' => $response['response_msg']]);
    }

    public function studentResult(Request $request)
    {
        $examId = $request->get('exam');
        $transId = $request->get('trans');
        $transInfo = $this->transactionManager->getStudentInfo($transId);
        $result = $this->examResultManager->getExamResult($examId, $transId);
        $resultDetail = $this->examResultManager->getExamResultDetail($examId, $transId);
        $examInfo = $this->examManager->examInfo($examId);

        $data['participant'] = $transInfo->student->candidate_name;
        $data['exam'] = $examInfo->exam_name;
        $data['totalQuestion'] = count($result);
        $data['totalMark'] = $examInfo->questions->sum("mark");
        $data['totalAnswered'] = 0;
        $data['wrongAnswered'] = 0;
        $data['correctAnswered'] = 0;
        $data['totalMarkAchieved'] = 0;
        $data['passPercentage'] = 0;
        $data['needToManualCheck'] = 0;

        foreach ($result as $res) {
            $data['totalAnswered'] += (isset($res->answer) ? 1 : 0);
            $data['wrongAnswered'] += (($res->status == 0) ? 1 : 0);
            $data['correctAnswered'] += (($res->status == 1) ? 1 : 0);
            //$exam = $examInfo->questions->where("exam_question_id", $res->exam_question_id)->first();
            $data['totalMarkAchieved'] += (($res->status == 1) ? $res->mark : 0);
            $data['needToManualCheck'] += (($res->status == 2) ? 1 : 0);
        }
        $data['passPercentage'] = floor(($data['totalMarkAchieved'] / $data['totalMark']) * 100);
        return view("backend.examination.exam-result.result_summary", compact('data', 'resultDetail', 'examId'));
    }

    public function resultPublish(Request $request)
    {
        $examId = $request->post('exam');
        $response = $this->examResultManager->publishExamResult($examId);

        return response()->json($response);
    }
}