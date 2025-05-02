<?php


namespace App\Contract\backend;


interface AssessmentContract
{
    public function isStudentAllowedInExam($studentId, $transId, $examId);
    public function getExamQuestions($examId);
    public function getUpComingPublishedExams($studentId);
    public function getParticipatedExams($studentId);

    public function getPublishedEvents($studentId);
    public function getParticipatedEvents($studentId);

    public function getPaidPendingSkills($studentId);
    public function getAttendedSkills($studentId);

    public function submitAssessment($transId, $examId, $answers);
}