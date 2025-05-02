<?php


namespace App\Entities\backend\exam_system;


use Illuminate\Database\Eloquent\Model;

class ETopic extends Model
{
    protected $table = "e_topic";
    protected $primaryKey = "id";

    public function subjects()
    {
        return $this->hasMany(ESubjectTopic::class,"topic_id","id");
    }
}