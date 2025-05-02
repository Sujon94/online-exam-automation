<?php
/**
 *Created by PhpStorm
 *Created at ২৭/৯/২১ ১২:০৮ PM
 */

namespace App\Entities\backend;


use App\Entities\backend\exam_system\EXam;
use App\Entities\backend\lookup\LCourseType;
use App\Enums\Exam\LExamStatus;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    use Sluggable;
    protected $table = 'courses';
    protected $primaryKey = 'course_id';
    public function course_type()
    {
        return $this->belongsTo(LCourseType::class,'course_type_id');
    }

    public function course_by_batch()
    {
        return $this->belongsTo(Batch::class,'course_id','course_id')->where('active_yn','Y');
    }

    public function course_file()
    {
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','course_id')->where('parent_table','=','courses');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source'=>'course_name_en'
            ]
        ];
    }

    public function batch()
    {
        return $this->hasMany(Batch::class,"course_id","course_id")->where(['active_yn'=>'Y']);
    }
    
    public function exams()
    {
        return $this->hasMany(EXam::class,'course_id','course_id')->where('status',LExamStatus::PUBLISHED);
    }
}