<?php


namespace App\Manager\backend;


use App\Contract\backend\CourseTypeContract;
use App\Entities\backend\lookup\LCourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseTypeManager implements CourseTypeContract
{
    protected LCourseType $courseType;

    public function __construct()
    {
        $this->courseType = new LCourseType();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->courseType->type_code = htmlspecialchars($request->post('course_code'));
            $this->courseType->type_name_en = htmlspecialchars($request->post('type_name_en'));
            $this->courseType->type_name_bn = htmlspecialchars($request->post('type_name_bn'));
            $this->courseType->active_yn = $request->post('active_yn');
            $this->courseType->save();

            DB::commit();
            return ["status" => 'success', "message" => 'Course Type Created'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getAllCourseTypes()
    {
        return $this->courseType->get();
    }

    public function getACourseTypeInfo($id)
    {
        return $this->courseType->where('id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $courseType = $this->courseType->find($id);

            $courseType->type_code = htmlspecialchars($request->post('course_code'));
            $courseType->type_name_en = htmlspecialchars($request->post('type_name_en'));
            $courseType->type_name_bn = htmlspecialchars($request->post('type_name_bn'));
            $courseType->active_yn = $request->post('active_yn');

            $courseType->save();
            DB::commit();
            return ["status" => 'success', "message" => 'Course Type Updated'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }

    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->courseType->where('id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Course Type Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }
}