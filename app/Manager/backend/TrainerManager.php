<?php


namespace App\Manager\backend;

use App\Contract\backend\TrainerContract;
use App\Entities\backend\Trainer;
use App\Enums\YesNoFlag;
use App\Helpers\HelperClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerManager implements TrainerContract
{
    protected Trainer $trainer;

    public function __construct()
    {
        $this->trainer = new Trainer();
    }

    public function getAllTrainer()
    {
        return $this->trainer->get();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $this->trainer->name = $request->post('name');
            $this->trainer->dob = HelperClass::dateFormatForDB(htmlspecialchars($request->post('dob')));
            $this->trainer->nid = $request->post('nid');
            $this->trainer->email = $request->post('email');
            $this->trainer->contact_no = $request->post('contact_no');
            $this->trainer->alt_contact_no = $request->post('alt_contact_no');
            $this->trainer->nationality = $request->post('nationality');
            $this->trainer->religion_id = $request->post('religion_id');
            $this->trainer->gender_id = $request->post('gender_id');
            $this->trainer->about_trainer = $request->post('about_trainer');
            $this->trainer->present_address = $request->post('present_address');
            $this->trainer->permanent_address = $request->post('permanent_address');
            $this->trainer->academic_background = $request->post('academic_background');
            $this->trainer->experiences = $request->post('experiences');
            $this->trainer->current_position = $request->post('current_position');
            $this->trainer->active_yn = $request->post('active_yn');
            $this->trainer->circular_yn = YesNoFlag::NO;
            $this->trainer->created_by = Auth::id();

            $this->trainer->save();

            DB::commit();
            return ["status" => 'success', "message" => 'Trainer Created Successfully'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }

    public function getTrainerInfo($id)
    {
        return $this->trainer->where('trainer_id','=',$id)->first();
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $trainer = $this->trainer->find($id);

            $trainer->name = $request->post('name');
            $trainer->dob = HelperClass::dateFormatForDB(htmlspecialchars($request->post('dob')));
            $trainer->nid = $request->post('nid');
            $trainer->email = $request->post('email');
            $trainer->contact_no = $request->post('contact_no');
            $trainer->alt_contact_no = $request->post('alt_contact_no');
            $trainer->nationality = $request->post('nationality');
            $trainer->religion_id = $request->post('religion_id');
            $trainer->gender_id = $request->post('gender_id');
            $trainer->about_trainer = $request->post('about_trainer');
            $trainer->present_address = $request->post('present_address');
            $trainer->permanent_address = $request->post('permanent_address');
            $trainer->academic_background = $request->post('academic_background');
            $trainer->experiences = $request->post('experiences');
            $trainer->current_position = $request->post('current_position');
            $trainer->active_yn = $request->post('active_yn');
            $trainer->circular_yn = YesNoFlag::NO;
            $trainer->created_by = Auth::id();

            $trainer->save();

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
            $this->trainer->where('trainer_id', '=', htmlspecialchars($id))->delete();
            DB::commit();
            return ["status" => 'success', "message" => 'Circular Removed'];
        }catch (\Exception $e){
            DB::rollBack();
            return ["status" => 'error', "message" => 'Exception Occurred'];
        }
    }
}