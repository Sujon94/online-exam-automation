<?php


namespace App\Manager\backend;


use App\Contract\backend\CircularContract;
use App\Entities\backend\Circular;
use App\Entities\backend\lookup\LCircularPayType;
use App\Entities\backend\lookup\LCircularType;
use App\Helpers\HelperClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CircularManager implements CircularContract
{
    protected Circular $circular;
    protected LCircularType $circularType;
    protected LCircularPayType $circularPayType;

    public function __construct()
    {
        $this->circular = new Circular();
        $this->circularType = new LCircularType();
        $this->circularPayType = new LCircularPayType();
    }

    public function getAllCircularTypes()
    {
        return $this->circularType->get();
    }

    public function getAllCircularPayTypes()
    {
        return $this->circularPayType->get();
    }

    public function getAllCircular()
    {
        return $this->circular->get();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->circular->title = $request->post('title');
            $this->circular->description = $request->post('description');
            $this->circular->circular_role = $request->post('circular_role');
            $this->circular->circular_type_id = $request->post('circular_type_id');
            $this->circular->circular_pay_type_id = $request->post('circular_pay_type_id');
            $this->circular->location_id = $request->post('location_id');
            $this->circular->no_of_post = $request->post('no_of_post');
            $this->circular->salary = $request->post('salary');
            $this->circular->published_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('published_date')));
            $this->circular->application_deadline = HelperClass::dateFormatForDB(htmlspecialchars($request->post('application_deadline')));
            $this->circular->responsibilities = $request->post('responsibilities');
            $this->circular->qualifications = $request->post('qualifications');
            $this->circular->active_yn = $request->post('active_yn');
            $this->circular->save();

            DB::commit();
            return ["status" => 'success', "message" => 'Circular Created Successfully'];
        } catch (\Exception $e) {
            DB::rollBack();
            
            dd( $e);
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getCircularInfo($id)
    {
        return $this->circular->where('circular_id','=',$id)->first();
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $circular = $this->circular->find($id);

            $circular->title = $request->post('title');
            $circular->description = $request->post('description');
            $circular->circular_role = $request->post('circular_role');
            $circular->circular_type_id = $request->post('circular_type_id');
            $circular->circular_pay_type_id = $request->post('circular_pay_type_id');
            $circular->location_id = $request->post('location_id');
            $circular->no_of_post = $request->post('no_of_post');
            $circular->salary = $request->post('salary');
            $circular->published_date = HelperClass::dateFormatForDB(htmlspecialchars($request->post('published_date')));
            $circular->application_deadline = HelperClass::dateFormatForDB(htmlspecialchars($request->post('application_deadline')));
            $circular->responsibilities = $request->post('responsibilities');
            $circular->qualifications = $request->post('qualifications');
            $circular->active_yn = $request->post('active_yn');

            $circular->save();
            DB::commit();
            return ["status" => 'success', "message" => 'Circular Updated Successfully'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }

    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->circular->where('circular_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Circular Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }
}