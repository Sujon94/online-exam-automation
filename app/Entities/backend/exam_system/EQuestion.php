<?php


namespace App\Entities\backend\exam_system;


use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LExamStatus;
use App\Enums\TableName;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EQuestion extends Model
{
    use SoftDeletes;
    use Timestamp;

    protected $table = 'e_questions';
    protected $primaryKey = 'id';

    public function type()
    {
        return $this->belongsTo(LEQuestionType::class, 'type_id');
    }

    public function subject()
    {
        return $this->belongsTo(ESubject::class, 'subject_id');
    }

    public function topic()
    {
        return $this->belongsTo(ETopic::class, 'topic_id');
    }

    public function choice()
    {
        return $this->hasOne(EMultipleChoiceQuestion::class, 'question_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(EXamQuestion::class, 'question_id', 'id')->with(['exam'])
            ->whereHas('exam'/*, function ($q) {
                $q->whereNotIn('status', [LExamStatus::PUBLISHED,LExamStatus::COMPLETED,LExamStatus::RESULT_PUBLISHED,LExamStatus::]);
            }*/);
    }

    public function file()
    {
        return $this->hasOne(SelfDevelopmentFile::class,'parent_id','id')
            ->where('parent_table','=',TableName::E_QUESTION);

    }
}