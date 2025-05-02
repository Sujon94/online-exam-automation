<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৪:৩১ PM
 */

namespace App\Manager\backend;


use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\Batch;
use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\Students;
use App\Entities\backend\StudentTransaction;
use App\Enums\Exam\LExamType;
use App\Enums\LTransactionStatus;
use App\Enums\Role;
use App\Helpers\HelperClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTransactionManager implements StudentTransactionContract
{
   // private StudentTransaction $studentTransaction;
    private  StudentTransaction $studentTransaction;

    public function __construct()
    {
        $this->studentTransaction = new StudentTransaction();
    }

    public function getTransactionOnStatus($id)
    {
        return $this->studentTransaction
            ->where('transaction_status_id', '=', $id)
            ->with('student', 'batch', 'payment_type', 'transaction_status','event_info')
            ->orderBy('transaction_datetime','desc')
            ->get();
    }

    public function updateTransactionStatus(Request $request)
    {
        $status = $request->post('status');
        $remark = $request->post('remark');
        $transactionId = $request->post('transaction_id');

        try {
            DB::beginTransaction();
            $trans = $this->studentTransaction->find($transactionId);
            if ($remark != "") {
                $trans->note = htmlspecialchars($remark);
            }
            $trans->transaction_status_id = ($status == '1') ? '2' : '3';

            $trans->save();

            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Transaction Updated'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    /**
     * @param Request $request
     * @param int $batchId
     * @return array
     */
    public function userCoursePayApiStore(Request $request, int $batchId): array
    {
        $user_id = auth()->id();
        $userInfo = User::with(['student_details'])->where('id', '=', $user_id)->where('user_role', '=', Role::STUDENT)->first();
        $stuTransInfo = StudentTransaction::where('student_id', '=', $userInfo->student_details->student_id)->where('batch_id', '=', $batchId)->first();
        $batchInfo = Batch::with('course')->where('batch_id',$batchId)->first();
        try {
            DB::beginTransaction();

            if (!empty($stuTransInfo)){
                $stuTransInfo->student_id = $userInfo->student_details->student_id;
                $stuTransInfo->student_name = $userInfo->student_details->candidate_name;
                $stuTransInfo->batch_id = $batchId;
                $stuTransInfo->batch_name = $batchInfo->batch_name_en;
                $stuTransInfo->course_id = $batchInfo->course->course_id;
                $stuTransInfo->course_name = $batchInfo->course->course_name;
                $stuTransInfo->amount = $request->post('trans_amount');
                $stuTransInfo->payment_type_id = $request->post('trans_payment_type');
                $stuTransInfo->transaction_status_id = LTransactionStatus::PENDING;
                $stuTransInfo->mobile = $request->post('trans_mobile_acc_name');
                $stuTransInfo->transaction_code = $request->post('trans_code_acc_no');
                $stuTransInfo->transaction_datetime = HelperClass::dateTimeFormatForDB($request->post('trans_date_time'));
                $stuTransInfo->save();

            } else {
                $this->studentTransaction->student_id = $userInfo->student_details->student_id;
                $this->studentTransaction->student_name = $userInfo->student_details->candidate_name;
                $this->studentTransaction->batch_id = $batchId;
                $this->studentTransaction->batch_name = $batchInfo->batch_name_en;
                $this->studentTransaction->course_id = $batchInfo->course->course_id;
                $this->studentTransaction->course_name = $batchInfo->course->course_name;
                $this->studentTransaction->amount = $request->post('trans_amount');
                $this->studentTransaction->payment_type_id = $request->post('trans_payment_type');
                $this->studentTransaction->transaction_status_id = LTransactionStatus::PENDING;
                $this->studentTransaction->mobile = $request->post('trans_mobile_acc_name');
                $this->studentTransaction->transaction_code = $request->post('trans_code_acc_no');
                $this->studentTransaction->transaction_datetime = HelperClass::dateTimeFormatForDB($request->post('trans_date_time'));
                $this->studentTransaction->save();
            }

            DB::commit();
            return ["code"=>'1',"status" => 'success', "message" => 'Your payment information is received with thanks.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function userPayApiStore(Request $request)
    {
        $user_id = auth()->id();
        try {
            $examId = decrypt($request->post('exam'));
        }catch (\Exception $e){
            return abort(404);
        }
        $userInfo = User::with(['student_details'])->where('id', '=', $user_id)->where('user_role', '=', Role::STUDENT)->first();
        $stuTransInfo = StudentTransaction::where('student_id', '=', $userInfo->student_details->student_id)
            ->where('exam_id', '=', $examId)->first();
        $examInfo = EXam::where('exam_id','=',$examId)->first();
        try {
            DB::beginTransaction();
            //I don't understand why update is performed. Just bypassing for Skill test and event
            if (($examInfo->exam_type == LExamType::SKILL_TEST_PAID) || ($examInfo->exam_type == LExamType::EVENT_COMPETITION)){
                $this->studentTransaction->student_id = $userInfo->student_details->student_id;
                $this->studentTransaction->student_name = $userInfo->student_details->candidate_name;
                $this->studentTransaction->exam_id = $examId;
                $this->studentTransaction->amount = $request->post('trans_amount');
                $this->studentTransaction->payment_for = $request->post('pay_for');
                $this->studentTransaction->payment_type_id = $request->post('trans_payment_type');
                $this->studentTransaction->transaction_status_id = LTransactionStatus::PENDING;
                $this->studentTransaction->mobile = $request->post('trans_mobile_acc_name');
                $this->studentTransaction->transaction_code = $request->post('trans_code_acc_no');
                $this->studentTransaction->transaction_datetime = HelperClass::dateTimeFormatForDB($request->post('trans_date_time'));
                $this->studentTransaction->save();
            }else{
                if (!empty($stuTransInfo)){
                    $stuTransInfo->student_id = $userInfo->student_details->student_id;
                    $stuTransInfo->student_name = $userInfo->student_details->candidate_name;
                    $stuTransInfo->exam_id = $examId;
                    $stuTransInfo->amount = $request->post('trans_amount');
                    $stuTransInfo->payment_for = $request->post('pay_for');
                    $stuTransInfo->payment_type_id = $request->post('trans_payment_type');
                    $stuTransInfo->transaction_status_id = LTransactionStatus::PENDING;
                    $stuTransInfo->mobile = $request->post('trans_mobile_acc_name');
                    $stuTransInfo->transaction_code = $request->post('trans_code_acc_no');
                    $stuTransInfo->transaction_datetime = HelperClass::dateTimeFormatForDB($request->post('trans_date_time'));
                    $stuTransInfo->save();

                } else {
                    $this->studentTransaction->student_id = $userInfo->student_details->student_id;
                    $this->studentTransaction->student_name = $userInfo->student_details->candidate_name;
                    $this->studentTransaction->exam_id = $examId;
                    $this->studentTransaction->amount = $request->post('trans_amount');
                    $this->studentTransaction->payment_for = $request->post('pay_for');
                    $this->studentTransaction->payment_type_id = $request->post('trans_payment_type');
                    $this->studentTransaction->transaction_status_id = LTransactionStatus::PENDING;
                    $this->studentTransaction->mobile = $request->post('trans_mobile_acc_name');
                    $this->studentTransaction->transaction_code = $request->post('trans_code_acc_no');
                    $this->studentTransaction->transaction_datetime = HelperClass::dateTimeFormatForDB($request->post('trans_date_time'));
                    $this->studentTransaction->save();
                }
            }

            DB::commit();
            return ["code"=>'1',"status" => 'success', "message" => 'Your payment information is received with thanks.', "pay_for"=>$request->post('pay_for')];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function getStudentInfo($transId)
    {
        return $this->studentTransaction->with(['student','event_info'])->where("student_transaction_id",$transId)->first();
    }

    public function getEventPaymentStatus($examId, $studentId)
    {
        return $this->studentTransaction->where(["exam_id"=>$examId,"student_id"=>$studentId])->first();
    }

    public function getSkillPaymentInfo($examId, $studentId){
        return $this->studentTransaction
            ->with('transaction_exam')
            ->where(["exam_id"=>$examId,"student_id"=>$studentId])
            ->get();
    }
}