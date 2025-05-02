<?php


namespace App\Entities\backend\exam_system;


use App\Entities\backend\SelfDevelopmentFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EMultipleChoiceQuestion extends Model
{
    use SoftDeletes;
    protected $table = 'e_multiple_choice_question';
    protected $primaryKey = 'id';

    public function question(){
        return $this->belongsTo(EQuestion::class,'question_id');
    }

    public function files()
    {
        return $this->hasMany(SelfDevelopmentFile::class,'parent_id','id')
            ->where(['parent_table'=>'e_multiple_choice_question']);
    }
}