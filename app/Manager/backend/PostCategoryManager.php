<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১১:১৮ AM
 */

namespace App\Manager\backend;


use App\Contract\backend\PostCategoryContract;
use App\Entities\backend\lookup\LPostCategory;
use App\Enums\PostCategoryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostCategoryManager implements PostCategoryContract
{
    protected LPostCategory $postCategory;

    public function __construct()
    {
        $this->postCategory = new LPostCategory();
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->postCategory->name = $request->post('name');
            $this->postCategory->name_bn = "";
            $this->postCategory->category_for = $request->post('category_for');
            $this->postCategory->status = $request->post('active_yn');
            $this->postCategory->created_by = Auth::id();
            $this->postCategory->save();

            DB::commit();
            return ["status" => 'success', "message" => 'Category Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getAllCategory()
    {
        return $this->postCategory->get();
    }

    public function getActiveCategories()
    {
        return $this->postCategory->where('status','=',PostCategoryStatus::ACTIVE)->get();
    }

    public function getACategoryInfo(int $id)
    {
        return $this->postCategory->where('post_category_id','=',$id)->first();
    }

    public function update(Request $request, int $id)
    {
        try {
            DB::beginTransaction();
            $postCategory = $this->postCategory->find($id);

            $postCategory->name = $request->post('name');
            $postCategory->name_bn = "";
            $postCategory->category_for = $request->post('category_for');
            $postCategory->status = $request->post('active_yn');
            $postCategory->created_by = Auth::id();

            $postCategory->save();
            DB::commit();
            return ["status" => 'success', "message" => 'Category Updated'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function delete(int $id)
    {
        try {
            DB::beginTransaction();
            $this->postCategory->where('post_category_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Category Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getCategoriesOnPostType(string $postFor)
    {
        return $this->postCategory->where('category_for','=',$postFor)->get();
    }
}