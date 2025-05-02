<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:৩৫ PM
 */

namespace App\Entities\backend;


use App\Enums\LTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batch extends Model
{
    use SoftDeletes;
    protected $table = "batches";
    protected $primaryKey = "batch_id";

    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','course_id');
    }

    public function batch_file()
    {
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','batch_id')->where('parent_table','=','batches');
    }

    public function student_trans()
    {
        return $this->belongsTo(StudentTransaction::class,'batch_id','batch_id');
    }

    public function batch_schedule()
    {
        return $this->hasMany(BatchSchedule::class, 'batch_id','batch_id');
    }

    public function transactions()
    {
        return $this->hasMany(StudentTransaction::class, 'batch_id','batch_id');
    }
    
        public function approved_students()
    {
        return $this->hasMany(StudentTransaction::class,'batch_id','batch_id');
                //->where('transaction_status_id','=',LTransactionStatus::APPROVED);
    }
}