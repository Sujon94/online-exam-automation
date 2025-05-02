<?php


namespace App\Http\Controllers\Frontend;


use App\Contract\backend\CourseContract;
use App\Entities\backend\Batch;
use App\Entities\backend\Course;
use App\Entities\backend\lookup\LReligion;
use App\Entities\backend\StudentTransaction;
use App\Enums\Role;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $courseManager;

    public function __construct(CourseContract $courseManager)
    {
        $this->courseManager = $courseManager;
    }

    public function index(Request $request)
    {
        $courseInfo = $this->courseManager->getAllMstCourse();
        return view('frontend.course.courses_mst', [
            'courseInfo' => $courseInfo,
        ]);
    }

    public function courseList(Request $request, $id)
    {
        $courseInfo = $this->courseManager->getTypeWiseCourses($id);
        return view('frontend.course.courses', [
            'courseInfo' => $courseInfo,
        ]);
    }

    public function courseDetail(Request $request, $slug)
    {
        $stuTransInfo = '';
        $userInfo = '';
        $batchInfo = '';
        $user_id = auth()->id();
        $lReligion = LReligion::all();
        try{

            $courseInfo = Course::where('slug',$slug)->first();
            $id = $courseInfo->course_id;

            if ($user_id) {
                $userInfo = User::with(['student_details'])->where('id', '=', $user_id)->where('user_role', '=', Role::STUDENT)->first();
                $batchInfo = Batch::where('course_id', '=', $id)->where('active_yn', '=', 'Y')->first();
            }
            if ($userInfo && $batchInfo) {
                $stuTransInfo = StudentTransaction::where('student_id', '=', $userInfo->student_details->student_id)->where('batch_id', '=', $batchInfo->batch_id)->first();
            }

            $courseDetails = $this->courseManager->getCourseDetails($id);
            $relatedCourses = $this->courseManager->getTypeWiseRandomCourses($id, $courseDetails->course_type_id);
            $totalCourseWiseStudent = StudentTransaction::with(['batch' => function ($query) use ($id) {
                $query->where('course_id', '=', $id);
            }])->get();
            if (!empty($courseDetails->course_material_en)) {
                $material = trim($courseDetails->course_material_en);
                $courseMaterial = explode('#', $material);
            } else {
                $courseMaterial = [];
            }
            if (!empty($courseDetails->course_topic)) {
                $topic = trim($courseDetails->course_topic);
                $courseTopic = explode('#', $topic);
            } else {
                $courseTopic = [];
            }
            return view('frontend.course.course_details', [
                'relatedCourses' => $relatedCourses,
                'courseDetails' => $courseDetails,
                'courseTopic' => $courseTopic,
                'userInfo' => $userInfo,
                'stuTransInfo' => $stuTransInfo,
                'totalCourseWiseStudent' => $totalCourseWiseStudent,
                'courseMaterial' => $courseMaterial,
                'metaInfo' => (object) [
                    'meta_title' => $courseDetails->meta_title,
                    'meta_description' => $courseDetails->meta_description
                ],
                'social' => (object) [
                    'title' => $courseDetails->course_name_en,
                    'description' => strip_tags($courseDetails->course_summary_en),
                    'image' => isset($courseDetails->course_by_batch->batch_file) ? $courseDetails->course_by_batch->batch_file->social_file_path : '',
                    'image_alt' => $courseDetails->course_name_en,
                    'url' => route('course.detail',['slug'=>$courseDetails->slug]),
                    'fb_app_id' => ''
                ]
            ]);
        }catch(\Exception $e){
            return view('frontend.content_not_found');
        }
    }
}