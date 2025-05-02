<?php

namespace App\Http\Controllers\Backend;

use App\Contract\backend\CommonContract;
use App\Contract\backend\CourseContract;
use App\Contract\backend\CourseTypeContract;
use App\Contract\backend\PostCategoryContract;
use App\Contract\backend\PostContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceUiController extends Controller
{
    private PostContract $serviceManager;

    protected PostCategoryContract $categoryManger;
    protected CommonContract $commonManager;

    public function __construct(PostContract $serviceManager, CommonContract $commonManager, PostCategoryContract $categoryManger)
    {
        $this->serviceManager = $serviceManager;
        $this->categoryManger = $categoryManger;
        $this->commonManager = $commonManager;
    }

    public function index()
    {
        $services = $this->serviceManager->getAllServices();
        return view('backend.post.service_ui_setup',compact('services'));
    }

    public function dataList()
    {
        $data = $this->serviceManager->getAllServices();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('category', function ($data) {
                return $data->category->name;
            })
            ->editColumn('action', function ($data) {
                return '<div class="form-check form-check-inline d-flex justify-content-center">
                             <input data-id="'.$data->post_id.'" class="form-check-input serviceCheck" '.(($data->master_yn == 'Y') ? "checked" : "").' type="checkbox">
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function checkUnCheck(Request $request)
    {
        return response()->json($this->serviceManager->updateMasterYN($request->post('serviceId'),$request->post('status')));
    }

}