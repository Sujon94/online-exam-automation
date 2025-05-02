<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৩:৫৪ PM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

interface StudentTransactionContract
{
    public function getTransactionOnStatus($id);
    public function updateTransactionStatus(Request $request);
    public function userCoursePayApiStore(Request $request, int $batchId):array ;
    public function userPayApiStore(Request $request);
    public function getEventPaymentStatus($examId, $studentId);
    public function getStudentInfo($transId);
    public function getSkillPaymentInfo($examId, $studentId);
}