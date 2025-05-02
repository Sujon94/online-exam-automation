<?php


namespace App\Entities\backend\exam_system;


use Illuminate\Database\Eloquent\Model;

class ESubjectTopic extends Model
{
    protected $table = "e_subject_topics";

    public function topic()
    {
        return $this->belongsTo(ETopic::class, 'topic_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(ESubject::class, 'subject_id', 'id');
    }
}