<?php
/**
 *Created by PhpStorm
 *Created at ২৭/৯/২১ ১১:৪৩ AM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\CommonContract;
use App\Contract\backend\CourseContract;
use App\Contract\backend\CourseTypeContract;
use App\Entities\backend\Course;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\DocFileCode;
use App\Http\Controllers\Controller;
use App\Rules\ValidateCertAltTag;
use App\Rules\ValidateCertificate;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    private CourseContract $courseManager;
    private CourseTypeContract $courseTypeManager;
    private CommonContract $commonManager;
    private SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct(CourseContract $courseManager, CourseTypeContract $courseTypeManager, CommonContract $commonManager)
    {
        $this->courseManager = $courseManager;
        $this->courseTypeManager = $courseTypeManager;
        $this->commonManager = $commonManager;
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
    }

    public function index()
    {
        $course = $this->courseManager->getAllCourse();
        $courseTypes = $this->courseTypeManager->getAllCourseTypes();

        return view("backend.course.course_setup", compact('courseTypes', 'course'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'course_thumbnail' => 'required|image|max:1024|dimensions:min_width=600,min_height=400,max_width=600,max_height=400',
                'course_certificate' => 'required_with:cert_img_alt_tag',
            ],
            [
                'course_certificate.required_with'  => 'Certificate is required when certificate alt tag is not empty.'
            ]
        );

        $response = $this->courseManager->store($request);

        if ($response['code'] == '1') {
            return redirect()->back()->with($response['status'], $response['message']);
        } else {
            return redirect()->back()->with($response['status'], $response['message'])->withInput();
        }
    }

    public function edit($id)
    {
        $insertedData = $this->courseManager->getACourseInfo($id);
        $courseTypes = $this->courseTypeManager->getAllCourseTypes();
        $course = $this->courseManager->getAllCourse();

        return view("backend.course.course_setup", compact('insertedData', 'courseTypes', 'course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'course_thumbnail' => 'image|max:1024|dimensions:min_width=600,min_height=400,max_width=600,max_height=400',
            'course_certificate' => 'sometimes|image|max:1024|dimensions:min_width=600,min_height=400,max_width=600,max_height=400',
            'cert_img_alt_tag' => [new ValidateCertAltTag($request)]
            ]
        );
        $response = $this->courseManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function delete($id)
    {
        $response = $this->courseManager->delete($id);
        return redirect()->route('course-setup.index')->with($response['status'], $response['message']);
    }

    public function fileDelete($id,$code=DocFileCode::C_THUMBNAIL)
    {
        if ($code == DocFileCode::C_THUMBNAIL){
            $response = $this->commonManager->file_delete($id);
        }else{
            $file = SelfDevelopmentFile::where('self_development_file_id','=',$id)->first();
            if (isset($file)){
                $file->certificate_file = null;
                $file->certificate_type = null;
                $file->certificate_name = null;
                $file->cert_img_alt_tag = null;

                $file->save();
                return response()->json(['response_code'=>'1','response_msg'=>"Certificate removed."]);
            }
        }
        return response()->json(['response_code'=>'1','response_msg'=>$response['message']]);
    }

    public function download($id,$fileCode)
    {
        $file = $this->selfDevelopmentFile->find($id);

        if ($fileCode == DocFileCode::C_CERTIFICATE){
            $content =  base64_decode($file->certificate_file);
            return response()->make($content, 200, [
                'Content-Type' => $file->certificate_type,
                'Content-Disposition' => 'attachment;filename="'.$file->certificate_name.'"'
            ]);

        } else {
            $content =  base64_decode($file->doc_file);
            return response()->make($content, 200, [
                'Content-Type' => $file->doc_file_type,
                'Content-Disposition' => 'attachment;filename="'.$file->doc_file_name.'"'
            ]);
        }
    }

    public function dataList()
    {
        $data = $this->courseManager->getAllCourse();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('course_type', function ($data) {
                return $data->course_type->type_name_en;
            })
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info"
                                           href="' . route("course-setup.edit", ["id" => $data->course_id]) . '"><i
                                                    class="bx bx-edit"></i>Edit</a>
       
                <form class="removeCourse" style="display: inline"
                                                  action="' . route("course-setup.delete", ["id" => $data->course_id]) . '"
                                                  method="POST">' . method_field("DELETE") . csrf_field() . '
                                                <input type="hidden" class="Batch" value="'.$data->batch->count().'"/>
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="bx bx-trash"></i>Remove
                                                </button>
                                            </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}