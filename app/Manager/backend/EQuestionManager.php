<?php


namespace App\Manager\backend;


use App\Contract\backend\EQuestionContract;
use App\Entities\backend\exam_system\EMultipleChoiceQuestion;
use App\Entities\backend\exam_system\EQuestion;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\Exam\LEQuestionFormat;
use App\Enums\Exam\LEQuestionType;
use App\Enums\TableName;
use App\Enums\YesNoFlag;
use App\Helpers\HelperClass;
use App\Helpers\ProcessImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EQuestionManager implements EQuestionContract
{
    public function create(Request $request): array
    {
        $formatId = $request->post('questionFormat');
        $question = htmlspecialchars($request->post('question'));
        $typeId = $request->post('questionType');
        $subjectId = $request->post('subject');
        $topic = $request->post('topic');
        $mark = $request->post('mark');
        $negativeMark = $request->post('negativeMark');
        $answer = htmlspecialchars($request->post('answer'));
        $answerDesc = htmlspecialchars($request->post('answerDesc'));
        $activeYn = $request->post('in_active', 'Y');

        $que = new EQuestion();
        DB::beginTransaction();
        try {
            $que->format_id = $formatId;
            $que->question = $question;
            $que->type_id = $typeId;
            $que->subject_id = $subjectId;
            $que->topic_id = $topic;
            $que->mark = $mark;
            $que->negative_mark = $negativeMark;
            $que->answer = $answer;
            $que->answer_description = $answerDesc;
            $que->status = $activeYn;

            $que->save();
            if ($que->id != '') {
                if ($formatId == LEQuestionFormat::IMAGE || $formatId == LEQuestionFormat::BOTH){
                    $file = $request->file();
                    if (isset($file)){
                        $byteCode = base64_encode(file_get_contents($file['question_img']->getRealPath()));
                        $fileExt = $file['question_img']->getMimeType();
                        $fileName = $file['question_img']->getClientOriginalName();

                        $files = [
                            'parent_table' => 'e_questions',
                            'parent_id' => $que->id,
                            'doc_file_name' => $fileName,
                            'doc_file_type' => $fileExt,
                            'doc_file' => $byteCode,
                            'doc_img_alt_tag' => 'Question in image format',
                            'created_at' => Carbon::now()->toDateString()
                        ];

                        $imgRes = SelfDevelopmentFile::insert($files);
                        if (!$imgRes) {
                            DB::rollBack();
                            return ['response_code' => 99, 'response_msg' => '[Question Image] - Update Failed.'];
                        }
                    }
                }


                if ($typeId == LEQuestionType::MULTIPLE_CHOICE || $typeId == LEQuestionType::IMAGE) {
                    $multiQuestion = new EMultipleChoiceQuestion();

                    $multiQuestion->question_id = $que->id;
                    $multiQuestion->answer = $request->post('choiceAnswer');
                    $multiQuestion->choice1 = $request->post('choice1');
                    $multiQuestion->choice2 = $request->post('choice2');
                    $multiQuestion->choice3 = $request->post('choice3');
                    $multiQuestion->choice4 = $request->post('choice4');

                    $multiQuestion->save();

                    if ($multiQuestion->id == '') {
                        DB::rollBack();
                        return ['response_code' => 99, 'response_msg' => '[Multiple Choice] - Insert Failed.'];
                    }

                    if ($typeId == LEQuestionType::IMAGE) {
                        $files = [];
                        $date = Carbon::now()->toDateString();
                        $images = $request->file();
                        foreach ($images['image'] as $file) {
                            $byteCode = base64_encode(file_get_contents($file->getRealPath()));
                            $fileExt = $file->getMimeType();
                            $fileName = $file->getClientOriginalName();

                            $files[] = [
                                'parent_table' => 'e_multiple_choice_question',
                                'parent_id' => $multiQuestion->id,
                                'doc_file_name' => $fileName,
                                'doc_file_type' => $fileExt,
                                'doc_file' => $byteCode,
                                'doc_img_alt_tag' => null,
                                'img_order' => 1,
                                'created_at' => $date
                            ];
                        }

                        $imgRes = SelfDevelopmentFile::insert($files);
                        if (!$imgRes) {
                            DB::rollBack();
                            return ['response_code' => 99, 'response_msg' => '[Multiple Choice Image] - Insert Failed.'];
                        }
                    }
                }
            }
            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Question] - Question Created.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function allQuestions()
    {
        return EQuestion::with('type', 'subject', 'topic','file')->get();
    }

    public function removeQuestions($id)
    {
        DB::beginTransaction();
        try {
            $question = EQuestion::with(['choice','exams'])->where('id', $id)->first();

            if ($question->exams->count() == 0){

                if ($question->format_id == LEQuestionFormat::IMAGE){
                    SelfDevelopmentFile::where(['parent_table' => TableName::E_QUESTION, 'parent_id' => $question->id]);
                }

                if ($question->type_id == LEQuestionType::MULTIPLE_CHOICE) {
                    //Removing choices
                    EMultipleChoiceQuestion::where('question_id', $id)->delete();
                }
                if ($question->type_id == LEQuestionType::IMAGE) {
                    //Removing files
                    SelfDevelopmentFile::where(['parent_table' => TableName::E_MULTIPLE_CHOICE_QUESTION, 'parent_id' => $question->choice->id])
                        ->delete();
                    //Removing choices
                    EMultipleChoiceQuestion::where('id', $question->choice->id)->delete();
                }

                //Removing parent question
                EQuestion::where('id', $question->id)->delete();
                DB::commit();
                return ['response_code' => 1, 'response_status' => 'success', 'response_msg' => 'Question Removed'];
            }else{
                DB::rollBack();
                return ['response_code' => 99, 'response_status' => 'warning', 'response_msg' => '<span class="fa fa-warning"></span>Can\'t delete. This question is mapped with exams. Remove from the exams first.'];
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_status' => 'error', 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function questionInfo($questionId)
    {
        try {
            $question = EQuestion::where('id', $questionId)->first();
            if ($question->type_id == LEQuestionType::IMAGE) {
                $question->choice->files = SelfDevelopmentFile::where(['parent_table' => TableName::E_MULTIPLE_CHOICE_QUESTION, 'parent_id' => $question->choice->id])
                    ->get();
            }
            if ($question->format_id == LEQuestionFormat::IMAGE || $question->format_id == LEQuestionFormat::BOTH) {
                $question->file = SelfDevelopmentFile::where(['parent_table' => TableName::E_QUESTION, 'parent_id' => $questionId])
                    ->first();
            }

            return ['response_code' => 1, 'response_status' => 'success', 'response_msg' => 'Question found', 'question' => $question];
        } catch (\Exception $e) {
            return ['response_code' => 99, 'response_status' => 'error', 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }

    public function update(Request $request, $id)
    {
        $formatId = $request->post('questionFormat');
        $question = htmlspecialchars($request->post('question'));
        $typeId = $request->post('questionType');
        $subjectId = $request->post('subject');
        $topic = $request->post('topic');
        $mark = $request->post('mark');
        $negativeMark = $request->post('negativeMark');
        $answer = htmlspecialchars($request->post('answer'));
        $answerDesc = htmlspecialchars($request->post('answerDesc'));
        $activeYn = $request->post('in_active', 'Y');

        if ($activeYn != 'Y') {
            $question = EQuestion::with(['choice', 'exams'])->where('id', $id)->first();
            if ($question->exams->count() != 0) {
                return ['response_code' => 99, 'response_msg' => '[Question] - Question can not be in-activated as it is used in a active exam.'];
            }
        }
        $que = EQuestion::where('id', $id)->first();
        DB::beginTransaction();
        try {
            //$que->format_id = $formatId;
            $que->question = $question;
            //$que->type_id = $typeId;
            //$que->subject_id = $subjectId;
            //$que->topic_id = $topic;
            $que->mark = $mark;
            $que->negative_mark = $negativeMark;
            $que->answer = $answer;
            $que->answer_description = $answerDesc;
            $que->status = $activeYn;
            $que->save();
            $file = $request->file();

            if (($formatId == LEQuestionFormat::IMAGE || $formatId == LEQuestionFormat::BOTH) && !empty($file['question_img'])){
                $byteCode = base64_encode(file_get_contents($file['question_img']->getRealPath()));
                $fileExt = $file['question_img']->getMimeType();
                $fileName = $file['question_img']->getClientOriginalName();

                $updateFile = [
                    'parent_table' => TableName::E_QUESTION,
                    'parent_id' => $que->id,
                    'doc_file_name' => $fileName,
                    'doc_file_type' => $fileExt,
                    'doc_file' => $byteCode,
                    'doc_img_alt_tag' => null
                ];
                $file = SelfDevelopmentFile::where(['parent_table'=>TableName::E_QUESTION,'parent_id'=>$que->id])->first();
                $imgRes = SelfDevelopmentFile::where(['self_development_file_id' => $file->self_development_file_id])->update($updateFile);

                if (!$imgRes) {
                    DB::rollBack();
                    return ['response_code' => 99, 'response_msg' => '[Question Image] - Update Failed.'];
                }
            }

            if ($typeId == LEQuestionType::MULTIPLE_CHOICE || $typeId == LEQuestionType::IMAGE) {
                $multiQuestion = EMultipleChoiceQuestion::where('question_id', $id)->first();
                $multiQuestion->question_id = $que->id;
                $multiQuestion->answer = $request->post('choiceAnswer');
                $multiQuestion->choice1 = $request->post('choice1');
                $multiQuestion->choice2 = $request->post('choice2');
                $multiQuestion->choice3 = $request->post('choice3');
                $multiQuestion->choice4 = $request->post('choice4');
                $multiQuestion->save();
                $images = $request->file();

                if (($typeId == LEQuestionType::IMAGE) && !empty($images['image'])) {
                    $date = Carbon::now()->toDateString();
                    foreach ($images['image'] as $key => $file) {
                        $byteCode = base64_encode(file_get_contents($file->getRealPath()));
                        $fileExt = $file->getMimeType();
                        $fileName = $file->getClientOriginalName();
                        $file_id = DB::selectOne("
                                            select self_development_file_id,row_num from
                                            (select *, row_number() over (order by self_development_file_id asc ) as row_num
                                            from self_development_file
                                            where parent_table='e_multiple_choice_question' and parent_id=:p_parent_id) as `*rn` where row_num = :p_row_num",
                                    ["p_parent_id" => $multiQuestion->id, "p_row_num" => ++$key]);

                        $updateFile = [
                            'parent_table' => 'e_multiple_choice_question',
                            'parent_id' => $multiQuestion->id,
                            'doc_file_name' => $fileName,
                            'doc_file_type' => $fileExt,
                            'doc_file' => $byteCode,
                            'doc_img_alt_tag' => null
                        ];

                        $imgRes = SelfDevelopmentFile::where(['self_development_file_id' => $file_id->self_development_file_id])->update($updateFile);
                        if (!$imgRes) {
                            DB::rollBack();
                            return ['response_code' => 99, 'response_msg' => '[Multiple Choice Image] - Update Failed.'];
                        }
                    }
                }
            }
            DB::commit();
            return ['response_code' => 1, 'response_msg' => '[Question] - Question Updated.'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['response_code' => 99, 'response_msg' => 'Error Msg: ' . $e->getMessage() . ' Error Line: ' . $e->getLine()];
        }
    }
}