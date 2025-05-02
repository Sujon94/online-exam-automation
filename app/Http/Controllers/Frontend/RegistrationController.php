<?php


namespace App\Http\Controllers\Frontend;


use App\Entities\backend\Students;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RegistrationController extends Controller
{
    protected $students;

    public function __construct()
    {
        $this->students = new Students();
    }

    public function index()
    {
        return view('frontend.registration.index');
    }

    public function store(Request $request) {
        $response = $this->user_registration($request);

        $message = $response['message'];

        /*if ($response['code'] == '1') {
            return redirect()->back()->with($response['status'], $response['message']);
        } else {
            return redirect()->back()->with($response['status'], $response['message'])->withInput();
        }*/

        if($response['code']  != '1') {
            session()->flash('m-class', 'alert-danger');
            return redirect()->back()->with('message', $message)->withInput();
        }

        session()->flash('m-class', 'alert-success');
        session()->flash('message', $message);

        return redirect()->route('registration.index');

    }

    public function user_registration(Request $request)
    {
        //dd($request);
        try {
            DB::beginTransaction();

            if ( ($request->post('reg_type_id') == 1) ){
                $this->students->profession_type_id = $request->post('reg_type_id');
                $this->students->candidate_name = $request->post('p_name');
                $this->students->mobile = $request->post('p_number');
                $this->students->email = $request->post('p_email');
                $this->students->academic_background = $request->post('p_academic_background');
                $this->students->designation = $request->post('p_job_prof_des');
                $this->students->organization = $request->post('p_org_com');
                $this->students->interested_courses = $request->post('p_int_anoth_crs');
                //$this->students->dummy = $request->post('p_photo');
                $this->students->present_address = $request->post('p_own_present_address');
                $this->students->password = bcrypt($request->post('p_password')) ;

                $this->students->save();

            } else {

                $this->students->profession_type_id = $request->post('reg_type_id');
                $this->students->candidate_name = $request->post('s_name');
                $this->students->father_name = $request->post('s_father_name');
                $this->students->mother_name = $request->post('s_mother_name');
                $this->students->guardian_name = $request->post('s_guardian_name');
                $this->students->mobile = $request->post('s_guardian_mobile');
                $this->students->nationality = $request->post('s_nationality');

                $this->students->date_of_birth = $request->post('s_dob');
                $this->students->religion_id = $request->post('s_religion');
                $this->students->present_address = $request->post('s_present_address');
                $this->students->permanent_address = $request->post('s_permanent_address');
                /*$this->students->dummy = $request->post('s_address_name');
                $this->students->dummy = $request->post('s_photo');
                $this->students->dummy = $request->post('s_certificate');
                $this->students->dummy = $request->post('s_trade');*/
                $this->students->exam_id = $request->post('s_exam_type');
                $this->students->pass_year = $request->post('s_pass_year');
                $this->students->registration_no = $request->post('s_reg_no');
                $this->students->roll_no = $request->post('s_roll_no');
                $this->students->gpa_division = $request->post('s_gpa');
                $this->students->board_id = $request->post('s_board');
                $this->students->merit_no = $request->post('s_merit_no');
                $this->students->password = bcrypt($request->post('s_password'));
                //$this->students->dummy = $request->post('s_comment');

                $this->students->save();
            }


            DB::commit();
            return ["code"=>'1',"status" => 'success', "message" => 'Registration Successfully Completed'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ["code"=>'99',"status" => 'error', "message" => 'Exception Occurred'.$e->getMessage()];
        }
    }
}