<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\BatchContract;
use App\Contract\backend\BatchScheduleContract;
use App\Contract\backend\CourseContract;
use App\Entities\backend\lookup\LPaymentProcessType;
use App\Entities\backend\SelfDevelopmentFile;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BatchScheduleController extends Controller
{
    private CourseContract $courseManager;
    private BatchContract $batchManager;
    private LPaymentProcessType $paymentType;
    private SelfDevelopmentFile $selfDevelopmentFile;
    private BatchScheduleContract $scheduleManager;
    public function __construct(CourseContract $courseManager, BatchContract $batchManager, BatchScheduleContract $scheduleManager)
    {
        $this->courseManager = $courseManager;
        $this->batchManager = $batchManager;
        $this->paymentType = new LPaymentProcessType();
        $this->scheduleManager = $scheduleManager;
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
    }

    public function index()
    {
        $course = $this->courseManager->getAllActiveCourses();
        $paymentType = $this->paymentType->where('active_yn', '=', 'Y')->get();
        $batch = $this->batchManager->getAllBatch();

        return view("backend.batch.batch_schedule", compact('course', 'paymentType', 'batch'));
    }

    public function store(Request $request)
    {
        $response = $this->scheduleManager->store($request);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function edit($id)
    {
        $insertedData = $this->batchManager->getABatchInfo($id);
        $course = $this->courseManager->getAllActiveCourses();
        $paymentType = $this->paymentType->where('active_yn', '=', 'Y')->get();
        $batch = $this->batchManager->getAllBatch();

        return view("backend.batch.batch_schedule", compact('insertedData', 'course', 'paymentType', 'batch'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->batchManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function download($id)
    {
        $file = $this->selfDevelopmentFile->find($id);
        $content = base64_decode($file->doc_file);

        return response()->make($content, 200, [
            'Content-Type' => $file->doc_file_type,
            'Content-Disposition' => 'attachment;filename="' . $file->doc_file_name . '"'
        ]);
    }

    public function delete($id)
    {
        $response = $this->scheduleManager->delete($id);
        return redirect()->route('batch-schedule.index')->with($response['status'], $response['message']);
    }

    public function dataList()
    {
        $data = $this->scheduleManager->getAllBatchSchedule();


        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('course', function ($data) {
                return $data->batch->course->course_name_en;
            })
            ->editColumn('batch', function ($data) {
                return $data->batch->batch_name_en;   
                
            })
            ->editColumn('date', function ($data) {
                return HelperClass::dateConvert($data->schedule_date);
            })
            ->editColumn('start_time', function ($data) {
                return HelperClass::timeFormat($data->schedule_start_time);
            })
            ->editColumn('end_time', function ($data) {
                return HelperClass::timeFormat($data->schedule_end_time);
            })
            ->editColumn('action', function ($data) {
                return '
                <form class="isConfirmOnSubmit" style="display: inline"
                                                  action="' . route("batch-schedule.delete", ["id" => $data->batch_schedule_id]) . '"
                                                  method="POST">' . method_field("DELETE") . csrf_field() . '
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="bx bx-trash"></i>Remove
                                                </button>
                                            </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}