<?php


namespace App\Contract\backend;


use Illuminate\Http\Request;

interface SkillTestContract
{
    public function storeTestResult($examId, $answers, $clientIp, $transId=null);
    public function skillTestResult(int $examId, string $clientIp);
    public function removeClientOldResults(string $clientIp);
}