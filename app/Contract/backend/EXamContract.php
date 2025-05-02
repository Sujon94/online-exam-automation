<?php


namespace App\Contract\backend;


use Illuminate\Http\Request;

interface EXamContract
{
    public function create(Request $request);
    public function update(Request $request, int $examId);
    public function updateStatus($examId, $status);
    public function examInfo(int $examId);
    public function questionsMap(Request $request);

    public function getPublishedSkillTestExams();
    public function examNextQuestion(int $examId, ?int $eQuestionId, string $clientIp);

    public function getPublishedExams();
    public function getExamsOnStatus($status);
}