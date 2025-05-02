<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৪:৩৪ PM
 */

namespace App\Entities\backend;


use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\exam_system\EXamResult;
use App\Entities\backend\lookup\LPaymentProcessType;
use App\Entities\backend\lookup\LTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentTransaction extends Model
{
    use SoftDeletes;
    protected $table = "student_transactions";
    protected $primaryKey = "student_transaction_id";

    public function student()
    {
        return $this->belongsTo(Students::class,'student_id','student_id')
            ->select('student_id','candidate_name','mobile','email');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class,'batch_id','batch_id');
    }

    public function payment_type()
    {
        return $this->belongsTo(LPaymentProcessType::class,'payment_type_id','payment_type_id');
    }

    public function transaction_status()
    {
        return $this->belongsTo(LTransactionStatus::class,'transaction_status_id','id');
    }

    public function event_info()
    {
        return $this->belongsTo(EXam::class,'exam_id','exam_id');
    }

    public function transaction_exam()
    {
        return $this->hasMany(EXamResult::class,'student_trans_id','student_transaction_id');
    }
}