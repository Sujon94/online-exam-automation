<?php


namespace App\Entities\backend\exam_system;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EXamQuestion extends Model
{
    use SoftDeletes;
    protected $table = "e_exam_questions";
    protected $primaryKey = "exam_question_id";

    public function exam()
    {
        return $this->belongsTo(EXam::class,'exam_id');
    }

    public function question()
    {
        return $this->belongsTo(EQuestion::class,"question_id","id");
    }
}