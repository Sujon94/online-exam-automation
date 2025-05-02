<?php


namespace App\Http\Controllers\Backend\Examination;


use App\Contract\backend\EQuestionContract;
use App\Entities\backend\exam_system\EQuestion;
use App\Entities\backend\exam_system\ESubject;
use App\Entities\backend\exam_system\LEQuestionFormat;
use App\Entities\backend\exam_system\LEQuestionType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    protected $questionManager;

    public function __construct(EQuestionContract $questionManager)
    {
        $this->questionManager = $questionManager;
    }

    public function index()
    {
        $subjects = ESubject::all();
        $types = LEQuestionType::all();
        $format = LEQuestionFormat::all();

        return view('backend.examination.question.index', compact('subjects', 'types', 'format'));
    }

    public function create(Request $request, $id = null)
    {
        if (is_null($id)) {
            $response = $this->questionManager->create($request);
        } else {
            $response = $this->questionManager->update($request, $id);
        }
        return response()->json($response);
    }

    public function list()
    {
        $questions = $this->questionManager->allQuestions();
        $subjects = ESubject::all();
        $types = LEQuestionType::all();
        return view('backend.examination.question.list', compact('questions', 'subjects', 'types'));
    }

    public function remove(Request $request)
    {
        $questionId = $request->get('id');
        $response = $this->questionManager->removeQuestions($questionId);
        return redirect()->back()->with($response['response_status'], $response['response_msg']);
    }

    public function edit($questionId)
    {
        $response = $this->questionManager->questionInfo($questionId);
        if ($response['response_code'] != 1) {
            return redirect()->back()->with(['error' => $response['response_msg']]);
        } else {
            $subjects = ESubject::all();
            $types = LEQuestionType::all();
            $format = LEQuestionFormat::all();

            $insertedData = $response['question'];
            return view('backend.examination.question.index', compact('subjects', 'types', 'insertedData','format'));
        }
    }
}