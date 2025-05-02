<?php
/**
 *Created by PhpStorm
 *Created at ৩/১০/২১ ৪:৫৭ PM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\StudentContract;
use App\Contract\backend\StudentTransactionContract;
use App\Entities\backend\lookup\LProfessionType;
use App\Entities\backend\lookup\LTransactionStatus;
use App\Entities\backend\SelfDevelopmentFile;
use App\Entities\backend\Students;
use App\Http\Controllers\Controller;
use App\Helpers\HelperClass;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private StudentContract $studentManager;
    private LProfessionType $professionType;
    private SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct(StudentContract $studentManager)
    {
        $this->studentManager = $studentManager;
        $this->professionType = new LProfessionType();
        $this->selfDevelopmentFile = new SelfDevelopmentFile();

    }

    public function index()
    {
        $professionType = $this->professionType->all();
        return view('backend.student.student',compact('professionType'));
    }

    public function detailView($id)
    {
        $student = $this->studentManager->getAStudentDetail($id);

        return view('backend.student.detail_view',compact('student'));
    }

    public function dataList(Request $request)
    {
        $id = $request->post('profession_type');
        $data = $this->studentManager->getStudentsOnProfession($id);

        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('student', function ($data) {
                return $data->candidate_name;
            })
            ->editColumn('profession', function ($data) {
                return $data->profession_type->type_name;
            })
            ->editColumn('mobile', function ($data) {
                return $data->mobile;
            })
            ->editColumn('interested_courses', function ($data) {
                $interested_courses = isset ($data->courses) ? $data->courses->course_name_en : 'No Data Found';
                return $interested_courses;
            })
            ->editColumn('address', function ($data) {
                return $data->present_address;
            })
            ->editColumn('date_time', function ($data) {
                return $data->created_at;
            })
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info" href="' . route("student.detail", ["id" => $data->student_id]) . '"><i class="bx bx-show"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function download($id)
    {
        $file = $this->selfDevelopmentFile->find($id);
        $content =  base64_decode($file->doc_file);

        return response()->make($content, 200, [
            'Content-Type' => $file->doc_file_type,
            'Content-Disposition' => 'attachment;filename="'.$file->doc_file_name.'"'
        ]);
    }
}