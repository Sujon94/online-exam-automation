@extends('frontend.layouts.default')
@section('header-style')
@endsection
@section('content')
    <!--Start Eduspace banner Section-->
    <section class="eduspace-banner">
        <div class="edu-overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="eduspace-banner-header">
                        <h2>User Registration</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Registration</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End Eduspace banner Section-->
    <!--Start registraion-form Section-->
    <section class="registraion-form section-padding ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="edu-title text-center">
                        <h2>Please Register</h2>
                        @if(Session::has('message'))
                            <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show mt-2"
                                 role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row justify-content-center reg-bg-img">
                <div class="col-lg-8  ">
                    <div class="registration-form-area">
                        <form  action="{{route('registration.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="reg_type_id">Your Profession?:</label>
                                        <select class="form-control" id="reg_type_id" name="reg_type_id">
                                            <option value="" selected >Select Type</option>
                                            <option value="1" >Professional</option>
                                            <option value="2" >Student</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="professional_section" style="display:none">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_name">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Name" id="p_name" name="p_name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_email">Email</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Email" id="p_email" name="p_email" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_number">Phone Here</label>
                                        <input type="text" class="form-control" placeholder="Enter Your phone Number" id="p_number" name="p_number" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_academic_background">Academic Background</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Academic Background" id="p_academic_background" name="p_academic_background" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_job_prof_des">Job/Profession/Designation</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Job/Profession/Designation" id="p_job_prof_des" name="p_job_prof_des" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_org_com">Organization/Company Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Organization/Company Name" id="p_org_com" name="p_org_com" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_int_anoth_crs">Interest Another Course</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Interest Another Course" id="p_int_anoth_crs" name="p_int_anoth_crs" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_password">Password</label>
                                        <input type="password" class="form-control-file" id="p_password" name="p_password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_own_present_address">Own/Present Address</label>
                                        <textarea class="form-control h-auto" rows="3" placeholder="Own/Present Address" id="p_own_present_address" name="p_own_present_address" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="p_photo">Upload Photo</label>
                                        <input type="file" class="form-control-file" id="p_photo" name="p_photo">
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="student_section" style="display:none">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_name">Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Name" id="s_name" name="s_name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_father_name">Father Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Father Name" id="s_father_name" name="s_father_name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_mother_name">Mother Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Mother Name" id="s_mother_name" name="s_mother_name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_guardian_name">Guardian Name (Absence Father)</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Guardian Name" id="s_guardian_name" name="s_guardian_name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_guardian_mobile">Guardian Mobile</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Guardian Mobile" id="s_guardian_mobile" name="s_guardian_mobile" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_nationality">Nationality</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Nationality" id="s_nationality" name="s_nationality" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_trade">Trade</label>
                                        <select class="form-control" id="s_trade" name="s_trade" >
                                            <option value="" >Select</option>
                                            <option value="1" >Computer office application</option>
                                            <option value="2" >Dress making and tailoring</option>
                                            <option value="3" >Refrigerator and air-conditioning</option>
                                            <option value="4" >Graphics design and multimedia</option>
                                            <option value="5" >Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_religion">Religion</label>
                                        <select class="form-control" id="s_religion" name="s_religion" >
                                            <option value="" selected>Select</option>
                                            <option value="1" >Hinduism</option>
                                            <option value="2" >Islam</option>
                                            <option value="3" >Christianity</option>
                                            <option value="4" >Buddhism</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_dob">DOB</label>
                                        <input type="date" class="form-control" placeholder="Enter Your Date Of Birth" id="s_dob" name="s_dob" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_password">Password</label>
                                        <input type="password" class="form-control-file" id="s_password" name="s_password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_present_address">Present Address</label>
                                        <textarea class="form-control h-auto" rows="3" placeholder="Present Address" id="s_present_address" name="s_present_address" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_permanent_address">Permanent Address</label>
                                        <textarea class="form-control h-auto" rows="3"  placeholder="Permanent Address" id="s_permanent_address" name="s_permanent_address" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_address_name">School/Madrasha/College/University Name & Address </label>
                                        <textarea class="form-control h-auto" rows="4"  placeholder="Permanent Address" id="s_address_name" name="s_address_name" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_photo">Upload Photo</label>
                                        <input type="file" class="form-control-file" id="s_photo" name="s_photo">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold" for="s_certificate">Upload Certificate</label>
                                        <input type="file" class="form-control-file" id="s_certificate" name="s_certificate">
                                    </div>
                                </div>
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-info ">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="16%">Exam</th>
                                            <th scope="col">Pass Year</th>
                                            <th scope="col">Reg No</th>
                                            <th scope="col">Roll</th>
                                            <th scope="col">Gpa</th>
                                            <th scope="col">Board</th>
                                            <th scope="col">Merit No</th>
                                            <th scope="col">Comment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            {{--<th scope="row">1</th>--}}
                                            <td>
                                                <select class="form-control" id="s_exam_type" name="s_exam_type" >
                                                    <option value="" >Select</option>
                                                    <option value="1" >JSC</option>
                                                    <option value="2" >SSC</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_pass_year" name="s_pass_year" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_reg_no" name="s_reg_no" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_roll_no" name="s_roll_no" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_gpa" name="s_gpa" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_board" name="s_board" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_merit_no" name="s_merit_no" ></td>
                                            <td><input type="text" class="form-control" placeholder="" id="s_comment" name="s_comment" ></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                           {{-- <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selectgender">Select gender:</label>
                                    <select class="form-control" id="selectgender">
                                        <option>Select Gender</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selectgender2">Select course:</label>
                                    <select class="form-control" id="selectgender2">
                                        <option>Select Course</option>
                                        <option>Web Design</option>
                                        <option>Wordpress</option>
                                        <option>PHP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputdate">Selct Date</label>
                                    <input type="text" class="form-control" id="inputdate" placeholder="select date">
                                    <div class="monthly" id="mycalendar2"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="r_postal">Postal Code</label>
                                    <input type="text" class="form-control" placeholder="Enter Your postal code" id="r_postal" name="number" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" placeholder="Write your Message here..." id="r_message" name="comment" required></textarea>
                                </div>
                            </div>--}}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="confirm">
                                        <button type="submit" class="eduspace-btn submit" value="submit">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section><!--End regustraion-form Section-->
@endsection
@section('footer-script')
<script type="text/javascript">

   /* function listBillRegister() {*/
        $('#reg_type_id').change(function (e) {
            e.preventDefault();
            let regTypeId = $(this).val();
            //alert(billSectionId);

            if (regTypeId == 1){
                $('#professional_section').show();
                $('#student_section').hide();
            } else if (regTypeId == 2) {
                $('#professional_section').hide();
                $('#student_section').show();
            } else {
                $('#professional_section').hide();
                $('#student_section').hide();
            }
        });
    /*}*/

    $(document).ready(function () {
        //Code here
    });
</script>
@endsection