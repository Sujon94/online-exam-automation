<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১১:১১ AM
 */

namespace App\Http\Controllers\Backend;


use App\Contract\backend\PostCategoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostCategoryController extends Controller
{
    protected PostCategoryContract $categoryManager;
    public function __construct(PostCategoryContract $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    public function index()
    {
        $categories = $this->categoryManager->getAllCategory();
        return view("backend.post.post_category_setup",compact("categories"));
    }

    public function store(Request $request)
    {
        $response = $this->categoryManager->store($request);
        return redirect()->back()->with($response['status'], $response['message'])->withInput();

    }

    public function edit($id)
    {
        $insertedData = $this->categoryManager->getACategoryInfo($id);
        $categories = $this->categoryManager->getAllCategory();

        return view("backend.post.post_category_setup", compact('insertedData', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->categoryManager->update($request, $id);
        return redirect()->back()->with($response['status'], $response['message']);    }

    public function delete($id)
    {
        $response = $this->categoryManager->delete($id);
        return redirect()->route('post-category-setup.index')->with($response['status'], $response['message']);
    }
}