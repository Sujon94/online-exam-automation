<?php


namespace App\Entities\backend\exam_system;


use Illuminate\Database\Eloquent\Model;

class ESubject extends Model
{
    protected $table = "e_subjects";
    protected $primaryKey = "id";

    public function topics()
    {
        return $this->hasMany(ESubjectTopic::class,"subject_id","id");
    }
}