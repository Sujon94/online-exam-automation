<?php


namespace App\Contract\backend;


use Illuminate\Http\Request;

interface EQuestionContract
{
    public function create(Request $request);
    public function update(Request $request, $id);
    public function allQuestions();
    public function removeQuestions($id);
    public function questionInfo($questionId);
}