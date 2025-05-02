<?php


namespace App\Http\Controllers\Frontend;


use App\Contract\backend\AssessmentContract;
use App\Contract\backend\BatchContract;
use App\Contract\backend\BatchScheduleContract;
use App\Contract\backend\EXamContract;
use App\Contract\backend\ExamResultContract;
use App\Contract\backend\StudentContract;
use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\Batch;
use App\Entities\backend\Course;
use App\Entities\backend\exam_system\ECertificateRegister;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\lookup\LExam;
use App\Entities\backend\lookup\LGender;
use App\Entities\backend\lookup\LPaymentProcessType;
use App\Entities\backend\lookup\LReligion;
use App\Entities\backend\StudentTransaction;
use App\Entities\frontend\StudentUser;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Enums\Exam\LPayFor;
use App\Enums\LTransactionStatus;
use App\Enums\LViewFor;
use App\Enums\Role;
use App\Enums\YesNoFlag;
use App\Helpers\Mpdf;
use App\Http\Controllers\Controller;
use App\Manager\backend\StudentTransactionManager;
use App\User;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    //private StudentTransactionContract $studentTransactionManger;
    private StudentTransactionContract $studentTransactionManger;
    private StudentContract $studentManager;
    private AssessmentContract $assessmentManager;
    private ExamResultContract $examResultManager;
    private EXamContract $examManager;
    private BatchScheduleContract $batchScheduleManager;

    private $student;
    private $upcoming;
    private $upcomingEvent;
    private $pendingSkillTest;

    public function __construct(BatchScheduleContract $batchScheduleManager, StudentContract $studentManager, StudentTransactionContract $studentTransactionManger, AssessmentContract $assessmentManager, EXamContract $examManager, ExamResultContract $examResultManager)
    {
        $this->batchScheduleManager = $batchScheduleManager;
        $this->studentTransactionManger = $studentTransactionManger;
        $this->studentManager = $studentManager;
        $this->assessmentManager = $assessmentManager;
        $this->examResultManager = $examResultManager;
        $this->examManager = $examManager;
    }

    public function index()
    {
        if (Auth::user()->user_role == Role::ADMIN){
            return redirect()->route('dashboard');
        }else{
            $user_id = auth()->id();
            $userInfoView = User::with(['student_details', 'student_details.religion_info', 'student_details.profession_type', 'student_details.student_photo', 'student_details.student_cert'])
                ->where('id', '=', $user_id)
                ->where('user_role', '=', Role::STUDENT)
                ->first();
            $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($userInfoView->parent_table_id);
            $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($userInfoView->parent_table_id);

            return view('frontend.student.user-details', [
                'userInfoView' => $userInfoView,
                'upcoming' => $this->upcoming,
                'upcomingEvent' => $this->upcomingEvent
            ]);
        }
    }

    public function loginUserProfile()
    {
        $user_id = auth()->id();
        $lReligion = LReligion::all();
        $lExam = LExam::all();
        $courseList = Course::all();
        $lGender = LGender::all();
        $userInfo = User::with(['student_details', 'student_details.profession_type', 'student_details.student_photo', 'student_details.student_cert'])
            ->where('id', '=', $user_id)
            ->where('user_role', '=', Role::STUDENT)
            ->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($userInfo->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($userInfo->parent_table_id);

        return view('frontend.student.user-details', [
            'userInfo' => $userInfo,
            'lReligion' => $lReligion,
            'lExam' => $lExam,
            'courseList' => $courseList,
            'lGender' => $lGender,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent
        ]);
    }

    public function loginUserCourses(Request $request)
    {
        $courseList = 'Course List';
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => LViewFor::COURSE_PAGE,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent
        ]);
    }

    public function courseDataList()
    {
        $data = Batch::with(['course'])->where('active_yn', '=', YesNoFlag::YES)->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('course_medium', function ($data) {
                return $data->course->course_medium;
            })
            ->addColumn('action', function ($data) {
                $user_id = auth()->id();
                $stuInfo = User::with(['student_details'])->where('id', '=', $user_id)->first();

                $stuTranInfo = StudentTransaction::where('student_id', '=', $stuInfo->student_details->student_id)->where('batch_id', '=', $data->batch_id)->first();
                $stuTranStatus = isset($stuTranInfo->transaction_status_id) ? $stuTranInfo->transaction_status_id : null;

                return '<a class="" href="' . route("course.detail", [$data->course_id]) . '" data-toggle="tooltip" data-placement="top" title="View Course Details"><i class="fa fa-eye"></i></a> ||
                        <a class="user-status" href="' . route('login-user.login-user-course-pay', [$data->course_id]) . '" data-user-status="' . $stuInfo->student_details->student_status_id . '" data-tran-status="' . $stuTranStatus . '" data-toggle="tooltip" data-placement="top" title="Pay Now"><i class="fa fa-arrow-right"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function loginUserPayableCourses(Request $request)
    {
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => '',
            'upcoming' => $this->upcoming, 'upcomingEvent' => $this->upcomingEvent]);
    }

    public function loginUserProfileUpdate(Request $request, $studentId)
    {
        $request->validate([
            'profile_image' => 'image|max:1024|dimensions:max_width=120,max_height=120',
            'certificate_file' => 'max:200|mimes:pdf'
        ]);

        $response = $this->studentManager->studentUpdate($studentId, $request);

        $message = $response['message'];

        if ($response['code'] != '1') {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message)->withInput();
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('login-user.login-user-profile');

    }

    public function payableCourseDataList()
    {
        $user_id = auth()->id();

        $data = User::with(['student_details.student_trans.batch.course'])->where('id', '=', $user_id)->first();

        $transactions = $data->student_details->student_trans;
        if (!isset($transactions)) {
            $transactions = [];
        }

        return datatables()->of($transactions)
            ->addIndexColumn()
            ->editColumn('course_code', function ($transactions) {
                if (isset($transactions->batch) && isset($transactions->batch->course))
                {
                    return $transactions->batch->course->course_code;
                }else{
                    return '';
                }
            })
            ->editColumn('course_name', function ($transactions) {
                if (isset($transactions->batch) && isset($transactions->batch->course))
                {
                    return $transactions->batch->course->course_name_en;
                }else{
                    return '';
                }
            })
            ->editColumn('batch', function ($transactions) {
                if (isset($transactions->batch))
                {
                    return $transactions->batch->batch_name_en;
                }else{
                    return '';
                }
            })
            ->editColumn('course_medium', function ($transactions) {
                if (isset($transactions->batch) && isset($transactions->batch->course))
                {
                    return $transactions->batch->course->course_medium;
                }else{
                    return '';
                }
            })
            ->editColumn('note', function ($transactions) {
                return $transactions->note;
            })
            ->addColumn('action', function ($transactions) {
                //$kk = User::with('student_details')->first();
                /*return '<a class="btn btn-sm btn-info" href="' . route("login.login-user-course-pay", ["id" => $data->course_id]) . '"><i class="bx bx-edit"></i>Pay Now</a>';*/
                /*if($data->student_trans == null){
                    return '<a class="btn btn-sm btn-info leaf-list" href="' . route("login-user.login-user-course-pay", ["id" => $data->course_id]) . '"><i class="bx bx-edit"></i>Pay Now</a>';
                } else if($data->student_trans->transaction_status_id == LTransactionStatus::PENDING){
                    return '<span class="text-success font-weight-bold">Payment Pending</span>';
                } else if ($data->student_trans->transaction_status_id == LTransactionStatus::APPROVED){
                    return '<span class="text-success font-weight-bold">Payment Approved</span>';
                } else {
                    return '<span class="text-danger font-weight-bold">Payment Rejected</span>';
                }*/
                /*if ($data->student_details->student_trans){*/
                if ($transactions->transaction_status_id == LTransactionStatus::PENDING) {
                    return '<span class="text-info font-weight-bold">Payment Pending</span>';
                } else if ($transactions->transaction_status_id == LTransactionStatus::APPROVED) {
                    return '<span class="text-success font-weight-bold">Payment Approved</span>';
                } else {
                    //return '<span class="text-danger font-weight-bold">Payment Rejected</span>';
                    if (isset($transactions->batch) && isset($transactions->batch->course))
                    {
                        return '<a class="btn btn-sm btn-danger" href="' . route('login-user.login-user-course-pay', [$transactions->batch->course->course_id]) . '"  data-toggle="tooltip" data-placement="top" title="Pay Now">Rejected (Please Re-payment)<i class="fa fa-arrow-right"></i></a>';
                    }else{
                        return 'N/A';
                    }
                }
                /* }*/

            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function loginUserCoursePay(Request $request, $id)
    {
        $LPayProcess = LPaymentProcessType::all();
        $batchInfo = Batch::with(['course'])->where('course_id', '=', $id)->where('active_yn', '=', 'Y')->first();
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => LViewFor::COURSE_PAYMENT,
            'LPayProcess' => $LPayProcess,
            'batchInfo' => $batchInfo,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent
        ]);
    }

    public function loginUserCoursePayStore(Request $request, $batchId)
    {
        $response = $this->studentTransactionManger->userCoursePayApiStore($request, $batchId);

        $message = $response['message'];

        if ($response['code'] != '1') {
            session()->flash('m-class', 'alert-danger');
            session()->flash('code', $response['code']);
            session()->flash('message', $message);
            return redirect()->back()->with('message', $message)->withInput();
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('code', $response['code']);
        session()->flash('message', $message);

        return redirect()->route('login-user.login-user-payable-courses');

    }

    public function exams()
    {
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);
        $old = $this->assessmentManager->getParticipatedExams($this->student->parent_table_id);
        $oldEvents = $this->assessmentManager->getParticipatedEvents($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => LViewFor::EXAM_PAGE,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent,
            'old' => $old,
            'oldEvents' => $oldEvents
        ]);
    }

    public function events()
    {
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);
        $oldEvents = $this->assessmentManager->getParticipatedEvents($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => LViewFor::EVENT_PAGE,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent,
            'oldEvents' => $oldEvents
        ]);
    }

    public function skills()
    {
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->pendingSkillTest = $this->assessmentManager->getPaidPendingSkills($this->student->parent_table_id);

        $oldTests = $this->assessmentManager->getAttendedSkills($this->student->parent_table_id);
        return view('frontend.student.user-details', [
            'viewFor' => LViewFor::SKILL_PAGE,
            'pendingTests' => $this->pendingSkillTest,
            'oldTests' => $oldTests
        ]);
    }

    public function eventList()
    {
        //where(['status'=>LExamStatus::PUBLISHED])->
        $events = EXam::whereIn('exam_type',[LExamType::EVENT_COMPETITION,LExamType::EVENT_COMPETITION_FREE])
            ->whereNotIn('status',[LExamStatus::DRAFT,LExamStatus::UN_PUBLISHED])
            ->orderBY('exam_date','desc')->get();
        return view('frontend.event.event_list',compact('events'));
    }

    public function eventView(Request $request, $event)
    {
            $this->student = User::with('student_details')->where("id", Auth::id())->first();
            $examId = decrypt($event);
            $eventInfo = $this->examManager->examInfo($examId);

            if (isset($this->student)){
                $paymentInfo = $this->studentTransactionManger->getEventPaymentStatus($examId, $this->student->parent_table_id);
            }else{
                $paymentInfo= null;
            }
            return view('frontend.event.event_detail', compact('eventInfo', 'paymentInfo'));
    }

    public function paymentPage(Request $request)
    {
        $LPayProcess = LPaymentProcessType::all();
        $event = $request->get('event',null);
        $skill = $request->get('skill',null);
        $examId = decrypt($event ?? $skill);
        $eventInfo = $this->examManager->examInfo($examId);
        $this->student = User::with('student_details')->where("id", Auth::id())->first();
        $this->upcoming = $this->assessmentManager->getUpComingPublishedExams($this->student->parent_table_id);
        $this->upcomingEvent = $this->assessmentManager->getPublishedEvents($this->student->parent_table_id);

        return view('frontend.student.user-details', [
            'viewFor' => isset($event) ? LViewFor::EVENT_PAYMENT : LViewFor::SKILL_PAYMENT,
            'LPayProcess' => $LPayProcess,
            'eventInfo' => $eventInfo,
            'upcoming' => $this->upcoming,
            'upcomingEvent' => $this->upcomingEvent
        ]);
    }

    public function paymentMake(Request $request)
    {
        $response = $this->studentTransactionManger->userPayApiStore($request);
        if ($response['code'] != '1') {
            return redirect()->back()->with($response['status'], $response['message'])->withInput();
        }
        if ($response["pay_for"] == LPayFor::SKILL_TEST){ //Skill
            return redirect()->route('login-user.login-user-skills')->with($response['status'], $response['message']);
        }else{ //Event
            return redirect()->route('login-user.login-user-events')->with($response['status'], $response['message']);
        }
    }

    public function resultView(Request $request)
    {
        $examId = $request->get('exam');
        $tranId = $request->get('tran');

        $transInfo = $this->studentTransactionManger->getStudentInfo($tranId);
        $result = $this->examResultManager->getExamResult($examId, $tranId);
        $resultDetail = $this->examResultManager->getExamResultDetail($examId, $tranId);
        $examInfo = $this->examManager->examInfo($examId);

        $data['participant'] = $transInfo->student->candidate_name;
        $data['exam_name'] = (($examInfo->exam_type == LExamType::EVENT_COMPETITION) ? 'Event: ' : 'Exam: ') . $examInfo->exam_name;

        $data['totalQuestion'] = count($result);
        $data['totalMark'] = $examInfo->questions->sum("mark");
        $data['totalAnswered'] = 0;
        $data['wrongAnswered'] = 0;
        $data['correctAnswered'] = 0;
        $data['totalMarkAchieved'] = 0;
        $data['passPercentage'] = 0;
        $data['needToManualCheck'] = 0;
        $data['exam'] = $examId;
        $data['tran'] = $tranId;

        foreach ($result as $res) {
            $data['totalAnswered'] += (isset($res->answer) ? 1 : 0);
            $data['wrongAnswered'] += (($res->status == 0) ? 1 : 0);
            $data['correctAnswered'] += (($res->status == 1) ? 1 : 0);
            $exam = $examInfo->questions->where("exam_question_id", $res->exam_question_id)->first();
            $data['totalMarkAchieved'] += (($res->status == 1) ? $exam->mark : 0);
            $data['needToManualCheck'] += (($res->status == 2) ? 1 : 0);
        }
        $data['passPercentage'] = floor(($data['totalMarkAchieved'] / $data['totalMark']) * 100);
        $data['status'] = ($data['passPercentage'] >= $examInfo->min_pass_percentage) ? '<span class="bg-success rounded-pill">Passed</span>' : '<span class="bg-danger rounded-pill">Failed</span>';

        $certInfo = ECertificateRegister::where(['exam_id' => $examId, 'student_transaction_id' => $tranId])->first();
        $data['allow_cert'] = (($examInfo->allow_certificate == 'Y') && ($data['passPercentage'] >= $examInfo->min_pass_percentage));
        $data['cert'] = $examInfo->allow_certificate == 'Y' ? ($certInfo->certificate_short_code ?? '0') : '';

        $view = view('backend.examination.exam-result.result_summary_frontend', compact('data','resultDetail'))->render();

        return response()->json(['response_code' => 1, 'response_msg' => 'Result fetched', 'content' => $view]);

    }

    public function certificateDownload($exam, $trans)
    {
        try {
            $examId = decrypt($exam);
            $transId = decrypt($trans);
        } catch (\Exception $e) {
            $examId = null;
            $transId = null;
        }

        $mpdf = new Mpdf();
        $data = (object)[];
        $data->transInfo = $this->studentTransactionManger->getStudentInfo($transId);
        $data->result = $this->examResultManager->getExamResult($examId, $transId);
        $data->examInfo = $this->examManager->examInfo($examId);
        $data->certInfo = ECertificateRegister::where(['exam_id' => $examId, 'student_transaction_id' => $transId])->first();

        if ($data->examInfo->exam_type == LExamType::PROFESSIONAL_EVALUATION) {
            $duration = $this->batchScheduleManager->getBatchDuration($data->transInfo->batch->batch_id);

            $data->transInfo->batch->batch_days = $duration['day'];
            $data->transInfo->batch->batch_hour = $duration['hour'];
        } else {
            $duration = '';
        }

        $mpdf->generateReport($data->examInfo->image_file->certificate_file, $data->examInfo->image_file->certificate_type,$data->transInfo->student->candidate_name . '.pdf', 'backend.examination.exam-result.professional_cert',$data);
    }
}