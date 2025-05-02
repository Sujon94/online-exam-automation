<?php


namespace App\Contract\backend;


use Illuminate\Http\Request;

interface BatchScheduleContract
{
    public function store(Request $request);

    public function getAllBatchSchedule();

    public function getABatchScheduleInfo($id);

    public function getScheduleOnBatch($id);

    public function update(Request $request, $id);

    public function delete($id);

    public function getBatchDuration($batchId);
}