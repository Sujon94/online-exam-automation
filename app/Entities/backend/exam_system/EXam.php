<?php


namespace App\Entities\backend\exam_system;


use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\StudentTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EXam extends Model
{
    use SoftDeletes;
    protected $table = "e_exams";
    protected $primaryKey = "exam_id";

    public function subjects()
    {
        return $this->hasMany(EXamSubject::class,'exam_id');
    }

    public function questions()
    {
        return $this->hasMany(EXamQuestion::class,"exam_id");
    }

    public function type()
    {
        return $this->belongsTo(LExamType::class,'exam_type','id');
    }

    public function image_file()
    {
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','exam_id')->where('parent_table','=','e_exams');
    }

    public function transaction_status()
    {
        return $this->hasMany(StudentTransaction::class,'exam_id','exam_id');
    }
}