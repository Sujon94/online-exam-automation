<?php
/**
 *Created by PhpStorm
 *Created at ২৯/৯/২১ ১:১৬ PM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\BatchContract;
use App\Contract\backend\CommonContract;
use App\Contract\backend\CourseContract;
use App\Entities\backend\lookup\LPaymentProcessType;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\ImageType;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use App\Manager\CommonManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BatchController extends Controller
{
    private CourseContract $courseManager;
    private BatchContract $batchManager;
    private LPaymentProcessType $paymentType;
    private SelfDevelopmentFile $selfDevelopmentFile;
    private CommonContract $commonManager;

    public function __construct(CourseContract $courseManager, BatchContract $batchManager, CommonContract $commonManager)
    {
        $this->courseManager = $courseManager;
        $this->batchManager = $batchManager;
        $this->paymentType = new LPaymentProcessType();
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
        $this->commonManager = $commonManager;
    }

    public function index()
    {
        $course = $this->courseManager->getAllActiveCourses();
        $paymentType = $this->paymentType->where('active_yn','=','Y')->get();
        return view("backend.batch.batch_setup", compact('course','paymentType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_image' => 'required|image|max:1024|dimensions:min_width=1200,min_height=400,max_width=1200,max_height=400',
            'social_image' => 'required|image|max:1024|dimensions:min_width=1200,min_height=630,max_width=1200,max_height=630'
        ]);
        $response = $this->batchManager->store($request);
        return redirect()->back()->with($response['status'], $response['message'], $request);
    }

    public function edit($id)
    {
        $insertedData = $this->batchManager->getABatchInfo($id);
        $course = $this->courseManager->getAllActiveCourses();
        $paymentType = $this->paymentType->where('active_yn','=','Y')->get();
        return view("backend.batch.batch_setup", compact('insertedData', 'course','paymentType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'batch_image' => 'image|max:1024|dimensions:min_width=1200,min_height=400,max_width=1200,max_height=400',
            'social_image' => 'image|max:1024|dimensions:min_width=1200,min_height=630,max_width=1200,max_height=630'
        ]);
        $response = $this->batchManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function download($id,$type=ImageType::BASE64)
    {
        $file = $this->selfDevelopmentFile->find($id);

        if ($type == ImageType::BASE64){
            $content =  base64_decode($file->doc_file);
            return response()->make($content, 200, [
                'Content-Type' => $file->doc_file_type,
                'Content-Disposition' => 'attachment;filename="'.$file->doc_file_name.'"'
            ]);
        }else{
            //$filepath =  asset('backend/assets/'.$file->social_file_path); //for cpanel
            $filepath =  asset('public/backend/assets/'.$file->social_file_path);

            return response()->make($filepath, 200, [
                'Content-Type' => $file->social_file_type,
                'Content-Disposition' => 'attachment;filename="'.$file->social_file_name.'"'
            ]);
        }

    }

    public function delete($id)
    {
        $response = $this->batchManager->delete($id);
        return redirect()->route('batch-setup.index')->with($response['status'], $response['message']);
    }

    public function fileDelete($id)
    {
        $response = $this->commonManager->file_delete($id);
        return response()->json(['response_code'=>'1','response_msg'=>$response['message']]);
    }

    public function dataList()
    {
        $data = $this->batchManager->getAllBatch();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('course', function ($data) {
                return isset($data->course) ? $data->course->course_name_en : '';
            })
            ->editColumn('batch_start_date', function ($data) {
                return HelperClass::dateConvert($data->batch_start_date);
            })
            ->editColumn('batch_end_date', function ($data) {
                return HelperClass::dateConvert($data->batch_end_date);
            })
            ->editColumn('status', function ($data) {
                return ($data->active_yn == 'Y') ? 'Active': 'Deactive';
            })

            ->editColumn('action', function ($data) {
                return '<div class="row"><a class="btn btn-sm btn-info col-md-4"
                                           href="' . route("batch-setup.edit", ["id" => $data->batch_id]) . '"><i
                                                    class="bx bx-edit"></i></a><div class="col-md-8">
       
                <form class="removeBatch" style="display: inline"
                                                  action="' . route("batch-setup.delete", ["id" => $data->batch_id]) . '"
                                                  method="POST">' . method_field("DELETE") . csrf_field() . '
                                                
                                                <input type="hidden" class="Batchtrans" value="'.$data->transactions->count().'"/>
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="bx bx-trash"></i>
                                                </button>
                                            </form></div></div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}