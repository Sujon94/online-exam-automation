<?php
/**
 *Created by PhpStorm
 *Created at ২৭/৯/২১ ১২:০৮ PM
 */

namespace App\Entities\backend;

use App\Entities\backend\lookup\LExam;
use App\Entities\backend\lookup\LGender;
use App\Entities\backend\lookup\LProfessionType;
use App\Entities\backend\lookup\LReligion;
use App\Enums\DocFileCode;
use App\Enums\TableName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Students extends Model
{
    use SoftDeletes;
    protected $table = 'students';
    protected $primaryKey = 'student_id';

    public function profession_type()
    {
        return $this->belongsTo(LProfessionType::class,'profession_type_id','profession_type_id');
    }

    public function religion()
    {
        return $this->belongsTo(LReligion::class,'religion_id','religion_id');
    }

    public function photo(){
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','student_id')->where('parent_table','=','students');
    }

    public function exam()
    {
        return $this->belongsTo(LExam::class,'exam_id');
    }

    public function student_trans()
    {
        return $this->hasMany(StudentTransaction::class,'student_id','student_id');
    }

    public function student_photo(){
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','student_id')->where(['parent_table' => TableName::STUDENTS_TABLE,'doc_file_short_code' => DocFileCode::PROFILE]);
    }

    public function student_cert(){
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','student_id')->where(['parent_table' => TableName::STUDENTS_TABLE,'doc_file_short_code' => DocFileCode::S_CERT]);
    }

    public function religion_info()
    {
        return $this->belongsTo(LReligion::class,'religion_id','religion_id');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class,'interested_courses','course_id');
    }
}