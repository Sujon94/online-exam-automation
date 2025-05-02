<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\BatchContract;
use App\Contract\backend\EXamContract;
use App\Contract\backend\ExamResultContract;
use App\Contract\backend\PostCategoryContract;
use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\Course;
use App\Entities\backend\exam_system\EQuestion;
use App\Entities\backend\exam_system\ESubjectTopic;
use App\Entities\backend\Post;
use App\Enums\Exam\LExamStatus;
use App\Enums\Exam\LExamType;
use App\Helpers\HelperClass;
use App\Helpers\Mpdf;
use App\Http\Controllers\Controller;
use Cviebrock\EloquentSluggable\Services\SlugService;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Imagick;
use function PHPUnit\Framework\returnArgument;

class AjaxController extends Controller
{
    private BatchContract $batchManager;
    private StudentTransactionContract $transactionManager;
    private PostCategoryContract $postCategoryManager;
    private ExamResultContract $examResultManager;
    private EXamContract $examManager;

    public function __construct(EXamContract $examManager, BatchContract $batchContract, StudentTransactionContract $transactionManager, PostCategoryContract $postCategoryManager, ExamResultContract $examResultManager)
    {
        $this->batchManager = $batchContract;
        $this->transactionManager = $transactionManager;
        $this->postCategoryManager = $postCategoryManager;
        $this->examResultManager = $examResultManager;
        $this->examManager = $examManager;
    }

    public function batchOfACourse($id)
    {
        return $this->batchManager->getBatchOnCourse($id);
    }

    public function changeTransactionStatus(Request $request)
    {
        $response = $this->transactionManager->updateTransactionStatus($request);
        return response()->json($response);
    }

    public function getPostCategories(Request $request)
    {
        $postFor = $request->get('postFor');
        $preSelected = $request->get('preSelected');
        $options = '<option value="">Select a category</option>';
        if (isset($postFor)) {
            $response = $this->postCategoryManager->getCategoriesOnPostType($postFor);
            foreach ($response as $res) {
                $options .= '<option value="' . $res->post_category_id . '" ' . (($preSelected == $res->post_category_id) ? "selected" : '') . '>' . $res->name . '</option>';
            }
        }

        return response()->json($options);
    }

    public function generateSlug(Request $request, string $name)
    {
        $slug = "";
        $response_code = 1;
        $response_msg = 'Success';
        try {
            if ($request->get('slugFor') == 'post') {
                $slug = SlugService::createSlug(Post::class, 'slug', $name);
            } else {
                $slug = SlugService::createSlug(Course::class, 'slug', $name);
            }
        } catch (\Exception $e) {
            $response_code = '99';
            $response_msg = $e->getMessage();
        }
        return response()->json(['slug' => $slug, 'response_code' => $response_code, 'response_msg' => $response_msg]);
    }

    public function getTopOnSubject(Request $request)
    {
        $subject = $request->get('subject-id');
        $topic = $request->get('preselect-topic', null);
        $subjectTopics = ESubjectTopic::with('topic')->where('subject_id', '=', $subject)->get();
        $option = '<option value="">Select a Topic</option>';
        foreach ($subjectTopics as $t) {
            if (is_null($topic)) {
                $option .= '<option value="' . $t->topic->id . '">' . $t->topic->name . '</option>';
            } elseif ($topic == $t->topic->id) {
                $option .= '<option selected value="' . $t->topic->id . '">' . $t->topic->name . '</option>';
            }
        }
        return response()->json(['options' => $option]);
    }

    public function batchStudents(Request $request)
    {
        $courseId = $request->get('course');
        $batch = $this->batchManager->getApprovedStudents($courseId);

        dd($batch);
    }

    public function examParticipants(Request $request)
    {
        $examId = $request->get('exam');
        $data = $this->examResultManager->getParticipantsList($examId);

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn("student_name", function ($q) {
                return $q->participant->student->candidate_name;
            })
            ->editColumn("course", function ($q) {
                return $q->participant->batch->course->course_name_en;
            })
            ->editColumn("batch", function ($q) {
                return $q->participant->batch->batch_name_en;
            })
            ->editColumn("action", function ($q) {
                return '<a class="btn btn-success" target="_blank" href="' . route("exam.student-result", ['exam' => $q->exam_id, 'trans' => $q->student_trans_id]) . '">Results</a>';
            })
            ->make(true);
    }

    public function examResultList(Request $request)
    {
        $status = $request->get('status');
        $data = $this->examManager->getExamsOnStatus($status);

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn("exam_name", function ($q) {
                return $q->exam_name;
            })
            ->editColumn("exam_type", function ($q) {
                return $q->type->name;
            })
            ->editColumn("exam_date", function ($q) {
                return $q->exam_date;
            })
            ->editColumn("questions", function ($q) {
                return $q->questions->count();
            })
            ->editColumn("multiple_choice", function ($q) {
                return $q->multiple_choice;
            })
            ->editColumn("image", function ($q) {
                return $q->image;
            })
            ->editColumn("written", function ($q) {
                return $q->written;
            })
            ->editColumn("participants", function ($q) {
                return $q->participants;
            })
            ->editColumn("action", function ($q) {
                $publish = '';
                if ($q->status == LExamStatus::COMPLETED) {
                    $publish = '<button class="result-publish btn btn-sm btn-info" onclick="publish(this,' . $q->exam_id . ')" >Publish</button>|';
                }
                return $publish . '<a class="btn btn-sm btn-success" target="_blank" href="' . route("exam.student-list", ['exam' => Crypt::encrypt($q->exam_id)]) . '">Results</a>';
            })
            ->make(true);
    }

    public function getQuestionSuggestion(Request $request)
    {
        $term = $request->get('term');
        $questions = EQuestion::select('question')->where('question', 'like', "%$term%")->pluck('question');
        return json_encode($questions);
    }

    public function previewCertificateProcess(Request $request)
    {
        $image = $request->file('cert_image');
        $byteCode = base64_encode(file_get_contents($image->getRealPath()));
        $fileExt = $image->getMimeType();
        $fileName = 'preview/cert_preview.pdf';
        $data = [
            'course' => $request->post('course'),
            'exam_type' => $request->post('exam_type'),
            'exam' => $request->post('exam'),
            'exam_date' => $request->post('exam_date')
        ];
        $mpdf = new Mpdf();
        $response = $mpdf->storeReport($byteCode, $fileExt, $fileName, 'backend.examination.exam.cert_preview', $data);
        return response()->json(['response_code'=>1,'response_msg' => 'Certificate Processed.','response_url'=>route('ajax.cert-preview',['name'=>$response['filename']])]);
    }

    public function generateCertificatePreview($name)
    {
       if(isset($name)){
            return response()->file(storage_path('app/public/preview/'.$name),  [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment;filename="'.$name.'"'
            ]);
        }else{
            abort('404');
        }
    }
}