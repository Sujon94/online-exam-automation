<?php

namespace App\Http\Controllers\Backend;

use App\Contract\backend\CommonContract;
use App\Contract\backend\CourseContract;
use App\Contract\backend\CourseTypeContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseUiController extends Controller
{
    private CourseContract $courseManager;
    private CourseTypeContract $courseTypeManager;
    private CommonContract $commonManager;

    public function __construct(CourseContract $courseManager, CourseTypeContract $courseTypeManager, CommonContract $commonManager)
    {
        $this->courseManager = $courseManager;
        $this->courseTypeManager = $courseTypeManager;
        $this->commonManager = $commonManager;
    }

    public function index()
    {
        $courses = $this->courseManager->getAllActiveCourses();
        return view('backend.course.course_ui_setup',compact('courses'));
    }

    public function dataList()
    {
        $data = $this->courseManager->getAllActiveCourses();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('course_type', function ($data) {
                return $data->course_type->type_name_en;
            })
            ->editColumn('action', function ($data) {
                return '<div class="form-check form-check-inline d-flex justify-content-center">
                             <input data-id="'.$data->course_id.'" class="form-check-input courseCheck" '.(($data->master_yn == 'Y') ? "checked" : "").' type="checkbox">
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function checkUnCheck(Request $request)
    {
        return response()->json($this->courseManager->updateMasterYN($request->post('courseId'),$request->post('status')));
    }

}