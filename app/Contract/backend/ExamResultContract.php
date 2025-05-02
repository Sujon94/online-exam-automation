<?php


namespace App\Contract\backend;


use Illuminate\Http\Request;

interface ExamResultContract
{
    public function getParticipantsList($examId);

    public function getExamResult($examId, $transId);

    public function getExamResultDetail($examId, $transId);

    public function getStudentWrittenAnswers($examId, $transId);

    public function storeReviewedAnswers(Request $request);

    public function publishExamResult($examId);
}