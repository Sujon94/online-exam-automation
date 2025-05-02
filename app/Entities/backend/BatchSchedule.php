<?php


namespace App\Entities\backend;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchSchedule extends Model
{
    use SoftDeletes;
    protected $table = "batch_schedules";
    protected $primaryKey = "batch_schedule_id";

    public function batch()
    {
        return $this->belongsTo(Batch::class,'batch_id','batch_id');
    }
}