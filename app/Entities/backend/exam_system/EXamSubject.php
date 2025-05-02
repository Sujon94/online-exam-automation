<?php


namespace App\Entities\backend\exam_system;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EXamSubject extends Model
{
    use SoftDeletes;
    protected $table = "e_exam_subjects";
    protected $primaryKey = "exam_subject_id";

    public function subject()
    {
        return $this->belongsTo(ESubject::class,'subject_id','id');
    }

    public function exam()
    {
        return $this->belongsTo(EXam::class,"exam_id");
    }

    public function questions()
    {
        return $this->hasMany(EQuestion::class,'subject_id','subject_id');
    }
}