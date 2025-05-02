<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\CourseTypeContract;
use App\Contract\backend\PageSetupContract;
use App\Entities\backend\Contact;
use App\Entities\backend\LCourseType;
use App\Entities\backend\lookup\LPageContent;
use App\Entities\backend\lookup\LSetupPage;
use App\Entities\backend\PageSetup;
use App\Entities\backend\PageSetupMaster;
use App\Entities\backend\SelfDevelopmentFile;
use App\Enums\DocFileCode;
use App\Enums\PageContentStatus;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageSetupController extends Controller
{
    private PageSetupContract $pageSetupManager;
    private SelfDevelopmentFile $selfDevelopmentFile;

    public function __construct(PageSetupContract $pageSetupManager)
    {
        $this->pageSetupManager = $pageSetupManager;
        $this->selfDevelopmentFile = new SelfDevelopmentFile();
    }

    public function index()
    {
        $setupPages = LSetupPage::all();
        $pageContent = LPageContent::all();
        return view("backend.page-setup.index", compact('setupPages','pageContent'));
    }

    public function dataList(Request $request)
    {
        //$page_id = $request->post('page_id');
        $data = PageSetupMaster::select('*')
            ->Join('l_setup_page', 'l_setup_page.page_id', '=', 'page_setup.page_id')
            ->Join('l_page_content', 'l_page_content.content_id', '=', 'page_setup.content_id')
            ->orderBy('id', 'desc')
            /*->when($page_id, function ($query, $page_id) {
                return $query->where('page_setup.page_id', $page_id);
            })*/
            ->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('created_at',function ($data){
                return HelperClass::dateConvert($data->created_at);
            })
            ->editColumn('active_status',function ($data){
                if($data->active_status = PageContentStatus::ACTIVE){
                    return 'ACTIVE';
                }else{
                    return 'INACTIVE';
                }

            })
            ->editColumn('action', function ($query) {
                return '<a href="' . route('page-setup.edit', [$query->id]) . '"><i class="bx bx-edit cursor-pointer"></i></a>';
            })
            ->make(true);
    }

    function getContent(Request $request)
    {
        $pageId = $request->input('page_id');
        $contentList = LPageContent::where('page_id', '=', $pageId)->get();

        $msg = '<option value="">Select Content</option>';
        foreach ($contentList as $data){
            $msg .= '<option value="'.$data->content_id.'">'.$data->content_name.'</option>';
        }
        return $msg;
    }

    public function store(Request $request)
    {
        $response = $this->pageSetupManager->store($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        $insertedData = PageSetup::where('id',$id)->first();
        $setupPages = LSetupPage::all();
        $pageContent = LPageContent::all();
        $file = SelfDevelopmentFile::where('parent_id',$id)->where('parent_table','page_setup')->first();
        if($file){
            $insertedData->doc_file_name = $file->doc_file_name;
            $insertedData->self_development_file_id = $file->self_development_file_id;
        }


        return view("backend.page-setup.index", compact('insertedData', 'setupPages','pageContent'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->pageSetupManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);    }

    public function delete($id)
    {
        $response = $this->courseTypeManager->delete($id);
        return redirect()->route('course-type-setup.index')->with($response['status'], $response['message']);
    }

    public function download($id,$fileCode)
    {
        $file = $this->selfDevelopmentFile->find($id);
        $filepath =  asset('assets/frontend/assets/image/'.$file->social_file_name);

        return response()->make($filepath, 200, [
            'Content-Type' => $file->social_file_type,
            'Content-Disposition' => 'attachment;filename="'.$file->social_file_name.'"'
        ]);

    }

    public function fileDelete($id)
    {
        $response = $this->file_delete($id);
        return response()->json(['response_code'=>'1','response_msg'=>$response['message']]);
    }

    public function file_delete(int $id)
    {
        try {
            DB::beginTransaction();
            $file = $this->selfDevelopmentFile->where('self_development_file_id', '=', htmlspecialchars($id))->first();
            /*if (Storage::disk('public_root')->exists(asset('assets/frontend/assets/image/'.$file->social_file_name))){
                Storage::disk('public_root')->delete(asset('assets/frontend/assets/image/'.$file->social_file_name));
            }*/

            if($file){
                try {
                    $path = asset('frontend/'.$file->social_file_name);
                    $a = Storage::disk('public')->delete($path);
                }catch (\Exception $e){
                    return false;
                }
            }

            $querys = "DELETE FROM self_development_file WHERE self_development_file_id = $id";
            $execute = db::select($querys);
            //$this->selfDevelopmentFile->where('self_development_file_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'File Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    function getDimension(Request $request)
    {
        $width = $request->input('width');
        $height = $request->input('height');
        $page_id = $request->input('page_id');
        $content_id = $request->input('content_id');

        $querys = "SELECT height, width FROM l_img_dimension WHERE page_id = $page_id AND content_id = $content_id";
        $execute = db::selectOne($querys);

        if($execute->height == $height && $execute->width == $width){
            $msg = '1+ok';
        }else{
            $msg = '0+Please Upload Image of Height: '.$execute->height.' px and Width: '.$execute->width.' px.';
        }

        return $msg;
    }

    function getDimensionMsg(Request $request)
    {
        $page_id = $request->input('page_id');
        $content_id = $request->input('content_id');

        $querys = "SELECT height, width FROM l_img_dimension WHERE page_id = $page_id AND content_id = $content_id";
        $execute = db::selectOne($querys);

        if($execute){
            $msg = '1+'.$execute->height.'*'.$execute->width.'';
        }else{
            $msg = '0+None';
        }

        return $msg;
    }

    function fieldRequired(Request $request)
    {
        $page_id = $request->input('page_id');
        $content_id = $request->input('content_id');

        $querys = "SELECT mandatory_field FROM l_mandatory_fields WHERE page_id = $page_id AND content_id = $content_id";
        $execute = db::select($querys);

        return response($execute);
    }
}