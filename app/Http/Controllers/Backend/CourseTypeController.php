<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\CourseTypeContract;
use App\Entities\backend\LCourseType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseTypeController extends Controller
{
    private CourseTypeContract $courseTypeManager;

    public function __construct(CourseTypeContract $courseTypeManager)
    {
        $this->courseTypeManager = $courseTypeManager;
    }

    public function index()
    {
        $courseTypes = $this->courseTypeManager->getAllCourseTypes();
        return view("backend.course-type-setup.course_type_setup", compact('courseTypes'));
    }

    public function store(Request $request)
    {
        $response = $this->courseTypeManager->store($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        $insertedData = $this->courseTypeManager->getACourseTypeInfo($id);
        $courseTypes = $this->courseTypeManager->getAllCourseTypes();

        return view("backend.course-type-setup.course_type_setup", compact('insertedData', 'courseTypes'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->courseTypeManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);    }

    public function delete($id)
    {
        $response = $this->courseTypeManager->delete($id);
        return redirect()->route('course-type-setup.index')->with($response['status'], $response['message']);
    }
}