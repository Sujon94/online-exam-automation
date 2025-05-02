<?php


namespace App\Http\Controllers\Backend;


use App\Contract\backend\CommonContract;
use App\Contract\backend\PostCategoryContract;
use App\Contract\backend\PostContract;
use App\Enums\PostCategoryFor;
use App\Enums\PostStatus;
use App\Helpers\HelperClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected PostContract $postManger;
    protected PostCategoryContract $categoryManger;
    protected CommonContract $commonManager;
    public function __construct(PostContract $postManger, CommonContract $commonManager, PostCategoryContract $categoryManger)
    {
        $this->postManger = $postManger;
        $this->categoryManger = $categoryManger;
        $this->commonManager = $commonManager;
    }

    public function index()
    {
        $categories = $this->categoryManger->getActiveCategories();
        return view("backend.post.post_setup",compact("categories"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_for' => 'required',
            'post_title' => 'required',
            'category_id' => 'required',
            'social_image' => ['max:1024','dimensions:min_width=1200,min_height=630, max_width=1200,max_height=630'],
            'post_image' => ['sometimes','max:1024','dimensions:min_width=1100,min_height=350, max_width=1100,max_height=350',function($input) use($request){
                if ($request->post('post_for') == PostCategoryFor::SERVICE){
                    return true;
                }
            }],
            'post_body' => 'required'
        ]);
        $response = $this->postManger->store($request);
        return redirect()->back()->with($response['status'], $response['message'], $request);
    }

    public function edit($id)
    {
        $insertedData = $this->postManger->getAPostInfo($id);
        $categories = $this->categoryManger->getActiveCategories();
        return view("backend.post.post_setup", compact('insertedData','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'post_for' => 'required',
            'post_title' => 'required',
            'category_id' => 'required',
            'social_image' => ['max:1024','dimensions:min_width=1200,min_height=630, max_width=1200,max_height=630'],
            'post_image' => ['sometimes','max:1024','dimensions:min_width=1100,min_height=350, max_width=1100,max_height=350',function($input) use($request){
                if ($request->post('post_for') == PostCategoryFor::SERVICE){
                    return true;
                }
            }],
            'post_body' => 'required'
        ]);
        $response = $this->postManger->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);
    }

    public function download($id)
    {
        $file = $this->postManger->download($id);
        $content = base64_decode($file->doc_file);
        return response()->make($content, 200, [
            'Content-Type' => $file->doc_file_type,
            'Content-Disposition' => 'attachment;filename="' . $file->doc_file_name . '"'
        ]);
    }

    public function delete($id)
    {
        $response = $this->postManger->delete($id);
        return redirect()->route('post-write.index')->with($response['status'], $response['message']);
    }

    public function fileDelete($id)
    {
        $response = $this->commonManager->file_delete($id);
        return response()->json(['response_code' => '1', 'response_msg' => $response['message']]);
    }

    public function dataList()
    {
        $data = $this->postManger->getAllPost();
        return datatables()->of($data)
            ->addIndexColumn()
            ->editColumn('post_for', function ($data) {
                if ($data->post_for == PostCategoryFor::BLOG) {
                    return '<span class="">Blog</span>';
                }else {
                    return '<span class="">Service</span>';
                }
            })
            ->editColumn('status', function ($data) {
                if ($data->status == PostStatus::PUBLISHED) {
                    return 'Published';
                } elseif ($data->status == PostStatus::PENDING) {
                    return 'Pending';
                } else {
                    return 'Draft';
                }
            })
            ->editColumn('category', function ($data) {
               return $data->category->name;
            })
            ->editColumn('action', function ($data) {
                return '<a class="btn btn-sm btn-info"
                                           href="' . route("post-write.edit", ["id" => $data->post_id]) . '"><i
                                                    class="bx bx-edit"></i>Edit</a>
       
                <form class="isConfirmOnSubmit" style="display: inline"
                                                  action="' . route("post-write.delete", ["id" => $data->post_id]) . '"
                                                  method="POST">' . method_field("DELETE") . csrf_field() . '
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="bx bx-trash"></i>Remove
                                                </button>
                                            </form>';
            })
            ->rawColumns(['action','post_for'])
            ->make(true);
    }
}