<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৫:০৪ PM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

interface StudentContract
{
    public function studentCreate(array $data);

    public function studentUpdate(int $studentId, Request $request);

    public function getAllStudents();

    public function getAStudentDetail(int $id);

    public function getStudentsOnProfession(int $id);
}