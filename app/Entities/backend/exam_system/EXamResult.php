<?php


namespace App\Entities\backend\exam_system;


use App\Entities\backend\StudentTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EXamResult extends Model
{
    use SoftDeletes;
    protected $table = 'e_exam_result';

    public function exam_question()
    {
        return $this->belongsTo(
            EXamQuestion::class,'exam_question_id','exam_question_id'
        );
    }

    public function participant()
    {
        return $this->belongsTo(StudentTransaction::class,'student_trans_id','student_transaction_id');
    }

    public function exam_info()
    {
        return $this->belongsTo(EXam::class,'exam_id','exam_id');
    }
}