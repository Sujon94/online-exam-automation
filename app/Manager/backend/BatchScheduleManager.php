<?php


namespace App\Manager\backend;


use App\Contract\backend\BatchScheduleContract;
use App\Entities\backend\Batch;
use App\Entities\backend\BatchSchedule;
use App\Enums\LBatchType;
use App\Helpers\HelperClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchScheduleManager implements BatchScheduleContract
{
    protected BatchSchedule $batchSchedule;
    protected Batch $batch;

    public function __construct()
    {
        $this->batchSchedule = new BatchSchedule();
        $this->batch = new Batch();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $batch = $request->post('batch');
            $date = $request->post('date');
            $start = $request->post('start_time');
            $end = $request->post('end_time');
            $schedule_action = $request->post('schedule_action');

            $batchInfo = $this->batch->where('batch_id', '=', $batch)->first();
            if ($batchInfo->batch_type == LBatchType::LONG_TERM) {
                DB::rollBack();
                return ["code" => '99', "status" => 'error', "message" => 'Can\'t set schedule for long course'];
            }
            foreach ($date as $key => $schedule) {
                if ($schedule_action[$key] == "A") {
                    $this->batchSchedule = new BatchSchedule();

                    $this->batchSchedule->batch_id = $batch;
                    $this->batchSchedule->schedule_date = HelperClass::dateFormatForDB($date[$key]);
                    $this->batchSchedule->schedule_start_time = HelperClass::timeFormatForDB($start[$key]);
                    $this->batchSchedule->schedule_end_time = HelperClass::timeFormatForDB($end[$key]);
                    $this->batchSchedule->active_yn = $request->post('active_yn');

                    $this->batchSchedule->save();
                }
            }
            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Schedule Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred' . $e->getMessage()];
        }
    }

    public function getAllBatchSchedule()
    {
        return $this->batchSchedule->with('batch.course')->get();
    }

    public function getABatchScheduleInfo($id)
    {
        // TODO: Implement getABatchScheduleInfo() method.
    }

    public function getScheduleOnBatch($id)
    {
        // TODO: Implement getScheduleOnBatch() method.
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->batchSchedule->where('batch_schedule_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["code" => '1', "status" => 'success', "message" => 'Schedule Removed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code" => '99', "status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getBatchDuration($batchId):array
    {
        $schedules = BatchSchedule::where('batch_id','=',$batchId)->get();
        $durationH = 0;
        $durationD = 0;
        foreach ($schedules as $s){
            $startTime = new Carbon($s->schedule_start_time);
            $endTime = new Carbon($s->schedule_end_time);
            $durationH += $startTime->diffInHours($endTime);
            $durationD++;
        }

        return ['day'=>$durationD,'hour'=>$durationH];
    }
}