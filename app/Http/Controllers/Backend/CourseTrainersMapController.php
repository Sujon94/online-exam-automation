<?php


namespace App\Http\Controllers\Backend;

use App\Contract\backend\CourseContract;
use App\Contract\backend\TrainerContract;
use App\Entities\backend\CourseTrainersMap;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CourseTrainersMapController extends Controller
{

    private CourseContract $courseManager;
    private TrainerContract $trainerManager;

    public function __construct(CourseContract $courseManager, TrainerContract $trainerManager)
    {
        $this->courseManager = $courseManager;
        $this->trainerManager = $trainerManager;
    }

    public function index()
    {
        return view('backend.course-trainers-map.index', [
            'courseList' => $this->courseManager->getAllActiveCourses(),
            'trainerList' => $this->trainerManager->getAllTrainer()
        ]);
    }

    public function dataList()
    {
        $data = DB::SELECT( DB::raw("SELECT a.course_id,
(SELECT course_name_en FROM courses WHERE course_id= a.course_id) as course_name,
GROUP_CONCAT((SELECT CONCAT(name , '(' ,contact_no , ') ') FROM trainers where trainer_id=a.trainer_id)) trainers 
FROM course_trainers_map a
GROUP BY a.course_id"));


        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info" href="' . route("course-trainers-map.edit", ["id" => $data->course_id]) . '"><i class="bx bx-edit"></i>Edit</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $response = $this->insertUpdate($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        $trainerList = DB::SELECT( DB::raw("Select a.trainer_id, a.name, a.contact_no,
(CASE WHEN (select COUNT(*) from course_trainers_map b WHERE b.course_id='$id' AND b.trainer_id=a.trainer_id) > 0 THEN 'selected'
    ELSE ''
END) AS selected_val
FROM trainers a"));

        return view('backend.course-trainers-map.index', [
            'courseList' => $this->courseManager->getAllActiveCourses(),
            'trainerList' => $trainerList,
            'course_id' => $id,
            'insertedData'=> NULL
        ]);
    }

    public function update(Request $request, $id)
    {
        $response = $this->insertUpdate($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function delete($id)
    {
        // TODO: Implement Delete method.
    }

    private function insertUpdate(Request $request, $id = null)
    {
        DB::beginTransaction();
        try {

            $dTrainers = [];
            $course_id = $request->post('course_id');
            $trainers = $request->post('trainer_id');

            CourseTrainersMap::where('course_id', $course_id)->delete();

            foreach ($trainers as $trainer) {
                $dTrainers[] =
                    [
                        "course_id" => $request->post('course_id'),
                        "trainer_id" => $trainer
                    ];
            }
            CourseTrainersMap::insert($dTrainers);


            DB::commit();
            if (isset($id)) {
                return ["status" => 'success', "message" => 'Course Wise Trainer Map Updated.'];

            }
            return ["status" => 'success', "message" => 'Course Wise Trainer Map Created.'];

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($id)) {
                return ["status" => 'error', "message" => 'Exception Occurred'. $e->getMessage()];
            }
            return ["status" => 'error', "message" => 'Exception Occurred'. $e->getMessage()];
        }
    }

}