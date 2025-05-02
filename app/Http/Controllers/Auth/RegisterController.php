<?php

namespace App\Http\Controllers\Auth;

use App\Contract\backend\StudentContract;
use App\Entities\backend\Students;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $studentManager;
    /**
     * Create a new controller instance.
     * @param StudentContract $studentManager
     * @return void
     */
    public function __construct(StudentContract $studentManager)
    {
        $this->middleware('guest');
        $this->studentManager = $studentManager;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'profession' => ['required'],
            'mobile' => ['required', 'max:13', 'unique:students'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        try {
            $response = $this->studentManager->studentCreate($data);
            //dd($response);
            if ($response['code'] == '1'){
                return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'user_role' => Role::STUDENT,
                    'parent_table_id' => $response['id']
                ]);
            }else{
                echo "500: Internal server error.";
                exit;
                return false;
            }
        }catch (\Exception $e){
            echo "500: Internal server error.";
        }

    }
}
