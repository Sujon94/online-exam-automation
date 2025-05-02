<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:১৭ PM
 */

namespace App\Contract\backend;


use Illuminate\Http\Request;

interface BatchContract
{
    public function store(Request $request);

    public function getAllBatch();

    public function getABatchInfo($id);

    public function getBatchOnCourse($id);

    public function update(Request $request, $id);

    public function delete($id);

    public function getApprovedStudents($course);
}