<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৩:৫২ PM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\lookup\LTransactionStatus;
use App\Enums\Exam\LPayFor;
use App\Http\Controllers\Controller;
use App\Helpers\HelperClass;
use App\Mail\EventConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class StudentTransactionController extends Controller
{
    private StudentTransactionContract $studentTransactionManager;
    private LTransactionStatus $transactionStatus;

    public function __construct(StudentTransactionContract $studentTransactionManager)
    {
        $this->transactionStatus = new LTransactionStatus();
        $this->studentTransactionManager = $studentTransactionManager;
    }

    public function index()
    {
        $transactionStatus = $this->transactionStatus->all();
        return view('backend.transaction.student_transaction', compact('transactionStatus'));
    }

    public function dataList(Request $request)
    {
        $id = $request->post('transaction_status');
        $data = $this->studentTransactionManager->getTransactionOnStatus($id);
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('student', function ($data) {
                return $data->student_name;
            })->editColumn('payment_for', function ($data) {
                $payment = '';
                 switch ($data->payment_for) {
                    case LPayFor::SKILL_TEST:
                        $payment = 'Skill Test';
                        break;
                    case LPayFor::EVENT_COMPETITION:
                        $payment = 'Event/Competition';
                        break;
                    default:
                        $payment = 'Course';
                    break;
                };
                 return $payment;
            })
            /*->editColumn('event', function ($data) {
                return ($data->payment_for == LPayFor::EVENT_COMPETITION) ? $data->event_info->exam_name : '';
            })*/
            ->editColumn('course', function ($data) {
                $exam = '';
                switch ($data->payment_for) {
                    case LPayFor::COURSE:
                        $exam = $data->course_name;
                        break;
                    default:
                        $exam = isset($data->event_info) ? $data->event_info->exam_name : 'N/A';
                        break;
                };
                return $exam;
            })
            ->editColumn('batch', function ($data) {
                return $data->batch_name;
            })
            ->editColumn('amount',function ($data){
                return $data->amount;
            })
            ->editColumn('payment_type', function ($data) {
                return $data->payment_type->process_name;
            })
            ->editColumn('transaction_code', function ($data) {
                return $data->transaction_code;
            })
            ->editColumn('transaction_date', function ($data) {
                return $data->transaction_datetime;
            })
            ->editColumn('status', function ($data) {
                return $data->transaction_status->status_name;
            })
            ->editColumn('action', function ($data) {
                $html = '';
                if ($data->transaction_status_id == \App\Enums\LTransactionStatus::PENDING) {
                    $html .= '<button class="btn btn-sm btn-success transAppRej" data-transaction="' . $data->student_transaction_id . '" data-status="1">approve</button> <button class="btn btn-sm btn-danger transAppRej" data-transaction="' . $data->student_transaction_id . '" data-status="0">reject</button>';
                } elseif ($data->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED) {
                    //return '<button class="btn btn-sm btn-danger transAppRej" data-transaction="'.$data->student_transaction_id.'" data-status="0">reject</button>';
                    if ($data->payment_for == LPayFor::EVENT_COMPETITION){
                        $html .= '<button class="sendMail btn btn-sm btn-primary" type="button" data-id="'.Crypt::encrypt($data->student_transaction_id).'">Confirmation Email</button>';
                    }else{
                        $html .= 'N/A';
                    }
                } else {
                    $html .= '<button class="btn btn-sm btn-success transAppRej" data-transaction="' . $data->student_transaction_id . '" data-status="1">approve</button> ';
                }



                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function sendConfirmEmail($id)
    {
        $transId = (isset($id) ? Crypt::decrypt($id) : null);
        if ($transId){
        $student = $this->studentTransactionManager->getStudentInfo($transId);

            try {
                Mail::to($student->student)->send(new EventConfirmation($student->event_info));
                return response()->json(['response_code'=>1,'response_msg'=>'Confirmation mail sent.']);
            }catch (\Exception $e){
                DB::statement('CALL GENERATE_EXCEPTION(:p_exception, :p_entity, :p_user_id);',
                    ['p_exception' => $e->getMessage().'||'.$e->getCode().'||'.$e->getLine().'||'.$e->getTraceAsString(),
                        'p_entity'=>'email_process',
                        'p_user_id'=>Auth::id()]);
                return response()->json(['response_code'=>99,'response_msg'=>'Email not sent. Exception Occurred.']);
            }
        }else{
            return response()->json(['response_code'=>99,'response_msg'=>'Transaction Not Found']);
        }
    }
}