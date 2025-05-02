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
                        <h2>User Login</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('/home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Login</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--End Eduspace banner Section-->

    <!--Start login-form Section-->

    <div class="container">
        <div class="row">

            <div class="col-md-12 border border-success mt-5 mb-5">
                <div class="row cus-bg-color text-center text-white">
                    <h3 class="col-md-12">User Information</h3>
                </div>

                <div class="row p-2 mt-4 mb-4">
                    <div class="widget-categories widget-bottom col-md-2">
                        {{--<div class="widget-title">
                            <h4>categories</h4>
                        </div>--}}
                        <ul>
                            {{--<li><i class="fa fa-angle-right"></i><a href="#">creative</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="#">English Learning</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="#">web design</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="#">Graphics design</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="#">Photography</a></li>--}}
                            {{--<li><i class="fa fa-angle-right"></i><a href="{{route('login.login-user-payable-courses')}}">Payment List</a></li>--}}
                            {{--<li><i class="fa fa-angle-right"></i><a href="{{route('login.index')}}">Logout</a></li>--}}
                            <li><i class="fa fa-angle-right"></i><a href="{{route('user-home')}}">Profile</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="{{route('login-user.login-user-courses')}}">Course
                                    List</a></li>
                            <li><i class="fa fa-angle-right"></i><a
                                        href="{{route('login-user.login-user-payable-courses')}}">Payment List</a></li>
                            <li>
                                <i class="fa fa-angle-right"></i><a
                                        href="{{route('login-user.login-user-exams')}}">Exam/Evaluation
                                    Test{!! isset($upcoming) ? count($upcoming) > 0 ? '<span class="badge badge-danger ml-2">'.count($upcoming).'</span>' : '' : '' !!}</a>

                            </li>
                            <li>
                                <i class="fa fa-angle-right"></i>
                                <a href="{{route('login-user.login-user-events')}}">
                                    Event/Competition{!! isset($upcomingEvent) ? count($upcomingEvent) > 0 ? '<span class="badge badge-danger ml-2">'.count($upcomingEvent).'</span>' : '' : '' !!}
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-angle-right"></i>
                                <a href="{{route('login-user.login-user-skills')}}">
                                    Skills{!! isset($skill) ? count($skill) > 0 ? '<span class="badge badge-danger ml-2">'.count($skill).'</span>' : '' : '' !!}
                                </a>
                            </li>
                            <li>
                                <i class="fa fa-angle-right"></i><a href="{{ route('logout') }}"
                                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            </li>
                        </ul>

                    </div>

                    @if (isset($userInfoView))
                        <div class="col-md-10">
                            <h4>User Profile</h4>
                            <hr>
                            <div class="comment-area">
                                <div class="single-comment">
                                    <div class="comment-img">
                                        @if (isset($userInfoView->student_details->student_photo))
                                            <img src="data:{{isset($userInfoView->student_details->student_photo) ? $userInfoView->student_details->student_photo->doc_file_type :''}}; base64, {{isset($userInfoView->student_details->student_photo)? $userInfoView->student_details->student_photo->doc_file : ''}}"
                                                 alt="{{isset($userInfoView->student_details->student_photo) ? $userInfoView->student_details->student_photo->doc_file_name : ''}}"/>
                                        @else
                                            <img src="{{asset('/frontend/assets/img/user-profile.jpg')}}"
                                                 alt="Profile Image">
                                        @endif
                                    </div>
                                    <div class="comment-details">
                                        <ul>
                                            <li><h4>
                                                    <strong>{{(isset($userInfoView->student_details->candidate_name) ? $userInfoView->student_details->candidate_name : '')}}</strong>
                                                </h4></li>
                                        </ul>
                                        <p>
                                            <span class="font-weight-bold">Email: </span>{{(isset($userInfoView->student_details->email) ? $userInfoView->student_details->email : '')}}
                                        </p>
                                        <p>
                                            <span class="font-weight-bold">Phone: </span>{{(isset($userInfoView->student_details->mobile) ? $userInfoView->student_details->mobile : '')}}
                                        </p>
                                        <p>
                                            <span class="font-weight-bold">Date Of Birth: </span>{{(isset($userInfoView->student_details->date_of_birth) ? date("d-m-Y", strtotime(($userInfoView->student_details->date_of_birth))) : 'No Data')}}
                                        </p>
                                        <p>
                                            <span class="font-weight-bold">Religion: </span>{{(isset($userInfoView->student_details->religion_info) ? $userInfoView->student_details->religion_info->religion_name : 'No Data')}}
                                        </p>
                                        <p>
                                            <span class="font-weight-bold">Profession Type: </span>{{(isset($userInfoView->student_details->profession_type->type_name) ? $userInfoView->student_details->profession_type->type_name : '')}}
                                        </p>
                                        <a class="btn btn-success mt-1"
                                           href="{{route('login-user.login-user-profile')}}" role="button">Update
                                            Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif (isset($userInfo))
                        <div class="col-md-10">
                            <h4>Update Profile</h4>
                            <hr>
                            @if(Session::has('message'))
                                <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show mt-2"
                                     role="alert">
                                    {{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form class="form-horizontal"
                                  @if(isset($userInfo->student_details->student_id)) action="{{route('login-user.login-user-profile-update',[$userInfo->student_details->student_id])}}"
                                  @endif enctype="multipart/form-data" method="post">
                                @csrf
                                @if (isset($userInfo->student_details->student_id))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="name">Name</label>
                                            <input type="text" class="form-control" placeholder="" id="name" name="name"
                                                   value="{{old('name',(isset($userInfo->student_details->candidate_name) ? $userInfo->student_details->candidate_name : ''))}}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="profession_type">Profession
                                                Type</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Transaction Code / Acc No" id="trans_code_acc_no"
                                                   name="trans_code_acc_no"
                                                   value="{{old('profession_type',(isset($userInfo->student_details->profession_type->type_name) ? $userInfo->student_details->profession_type->type_name : ''))}}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="mobile_no">Mobile No</label>
                                            <input type="text" class="form-control" placeholder="" id="mobile_no"
                                                   name="mobile_no"
                                                   value="{{old('mobile_no',(isset($userInfo->student_details->mobile) ? $userInfo->student_details->mobile : ''))}}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="email">Email</label>
                                            <input type="text" class="form-control" placeholder="" id="email"
                                                   name="email"
                                                   value="{{old('email',(isset($userInfo->student_details->email) ? $userInfo->student_details->email : ''))}}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="father_name">Father Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Father Name"
                                                   id="father_name" name="father_name" required
                                                   value="{{old('father_name',(isset($userInfo->student_details->father_name) ? $userInfo->student_details->father_name : ''))}}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="mother_name">Mother Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Mother Name"
                                                   id="mother_name" name="mother_name" required
                                                   value="{{old('mother_name',(isset($userInfo->student_details->mother_name) ? $userInfo->student_details->mother_name : ''))}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="date_of_birth">Date Of Birth</label>
                                            <input type="date" class="form-control"
                                                   placeholder="Enter Your Date Of Birth" id="date_of_birth"
                                                   name="date_of_birth" required
                                                   value="{{old('date_of_birth',(isset($userInfo->student_details->date_of_birth) ? strftime('%Y-%m-%d', strtotime($userInfo->student_details->date_of_birth)) : ''))}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="nationality">Nationality</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Nationality"
                                                   id="nationality" name="nationality" required
                                                   value="{{old('nationality',(isset($userInfo->student_details->nationality) ? $userInfo->student_details->nationality : ''))}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="religion">Religion</label>
                                            <select class="form-control" id="religion" name="religion" required>
                                                <option value="">Select</option>
                                                @foreach($lReligion as $value)
                                                    <option value="{{$value->religion_id}}"
                                                            {{old('religion',isset($userInfo->student_details->religion_id) && $userInfo->student_details->religion_id == $value->religion_id ? 'selected' : '')}} >{{$value->religion_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="gender">Gender</label>
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="">Select</option>
                                                @foreach($lGender as $value)
                                                    <option value="{{$value->gender_id}}"
                                                            {{old('gender',isset($userInfo->student_details->gender_id) && $userInfo->student_details->gender_id == $value->gender_id  ? 'selected' : '')}} >{{$value->gender_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    @if ($userInfo->student_details->profession_type_id == \App\Enums\ProfessionType::JOB_HOLDER)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="academic_background">Academic
                                                    Background</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter Your Academic Background"
                                                       id="academic_background" name="academic_background"
                                                       value="{{old('academic_background',(isset($userInfo->student_details->academic_background) ? $userInfo->student_details->academic_background : ''))}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="job_prof_des">Job/Profession/Designation</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter Your Job/Profession/Designation"
                                                       id="job_prof_des" name="job_prof_des"
                                                       value="{{old('job_prof_des',(isset($userInfo->student_details->designation) ? $userInfo->student_details->designation : ''))}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="org_com">Organization/Company
                                                    Name</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter Your Organization/Company Name" id="org_com"
                                                       name="org_com"
                                                       value="{{old('org_com',(isset($userInfo->student_details->organization) ? $userInfo->student_details->organization : ''))}}">
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="guardian_name">Guardian Name
                                                    (Absence Father)</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter Your Guardian Name" id="guardian_name"
                                                       name="guardian_name"
                                                       value="{{old('guardian_name',(isset($userInfo->student_details->guardian_name) ? $userInfo->student_details->guardian_name : ''))}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="guardian_mobile">Guardian
                                                    Mobile</label>
                                                <input type="number" class="form-control"
                                                       placeholder="Enter Your Guardian Mobile" id="guardian_mobile"
                                                       name="guardian_mobile"
                                                       value="{{old('guardian_mobile',(isset($userInfo->student_details->guardian_mobile) ? $userInfo->student_details->guardian_mobile : ''))}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="institute_name">School/Madrasha/College/University
                                                    Name & Address </label>
                                                <textarea class="form-control h-auto" rows="2"
                                                          placeholder="School/Madrasha/College/University Name & Address"
                                                          id="institute_name" name="institute_name"
                                                          required>{{old('institute_name',(isset($userInfo->student_details->institute_name) ? $userInfo->student_details->institute_name : ''))}}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="interest_another_course">Interest
                                                Another Course</label>
                                            {{--<input type="text" class="form-control" placeholder="Enter Your Interest Another Course" id="interest_another_course" name="interest_another_course"
                                                   value="{{old('interest_another_course',(isset($userInfo->student_details->interested_courses) ? $userInfo->student_details->interested_courses : ''))}}">--}}
                                            <select class="form-control" id="interest_another_course"
                                                    name="interest_another_course" required>
                                                <option value="">Select</option>
                                                @foreach($courseList as $value)
                                                    <option value="{{$value->course_id }}"
                                                            {{old('religion',isset($userInfo->student_details->interested_courses) && $userInfo->student_details->interested_courses == $value->course_id ? 'selected' : '')}} >{{$value->course_name_en}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="present_address">Present
                                                Address</label>
                                            <textarea class="form-control h-auto" rows="3" placeholder="Present Address"
                                                      id="present_address" name="present_address"
                                                      required>{{old('present_address',(isset($userInfo->student_details->present_address) ? $userInfo->student_details->present_address : ''))}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{-- <label class="font-weight-bold" for="permanent_address">Permanent Address</label>--}}
                                            <label class="font-weight-bold custom-control custom-checkbox"
                                                   for="permanent_address">
                                                <input type="checkbox" class="custom-control-input"
                                                       name="permanent_address_same_present"
                                                       id="permanent_address_same_present"
                                                       value="{{\App\Enums\YesNoFlag::YES}}" {{isset($userInfo->student_details->same_address_yn) && ($userInfo->student_details->same_address_yn == \App\Enums\YesNoFlag::YES) ? 'checked' : ''}} >
                                                <label class="custom-control-label font-weight-bold"
                                                       for="permanent_address_same_present">Same As Present</label>
                                            </label>
                                            <textarea class="form-control h-auto" rows="3"
                                                      placeholder="Permanent Address" id="permanent_address"
                                                      name="permanent_address" required
                                                      @if (isset($userInfo->student_details->same_address_yn) && ($userInfo->student_details->same_address_yn == \App\Enums\YesNoFlag::YES)) readonly @endif >{{old('permanent_address',(isset($userInfo->student_details->permanent_address) ? $userInfo->student_details->permanent_address : ''))}}</textarea>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"  class="custom-control-input bg-dark border border-dark" name="permanent_address_same_present" id="permanent_address_same_present"  value="{{\App\Enums\YesNoFlag::YES}}"
                                                        {{isset($userInfo->student_details->same_address_yn) && ($userInfo->student_details->same_address_yn == \App\Enums\YesNoFlag::YES) ? 'checked' : ''}} >
                                                <label class="custom-control-label font-weight-bold" for="permanent_address_same_present">Permanent Address Same AS Present</label>
                                            </div>
                                        </div>
                                    </div>--}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="profile_image"
                                                       class="font-weight-bold @if(!$userInfo->student_details->student_photo || !$userInfo->student_details->student_photo->doc_file_name) required @endif">Upload
                                                    Profile Image </label>
                                                <input type="file" class="form-control" id="profile_image"
                                                       @if(!$userInfo->student_details->student_photo || !$userInfo->student_details->student_photo->doc_file_name) required
                                                       @endif name="profile_image" placeholder="Upload Profile Image"/>
                                                <span class="form-text ">Image upload must be Height:120px Width:120px.&nbsp;
                                                    @if ($errors->has('profile_image'))
                                                        <div class="badge badge-danger"> {{$errors->first('profile_image')}} </div>
                                                    @endif
                                                    @if($userInfo->student_details->student_photo && $userInfo->student_details->student_photo->doc_file_name)
                                                        <a class="btn btn-success btn-sm"
                                                           href="{{ route('login-user.profile-picture-download', [$userInfo->student_details->student_photo->self_development_file_id]) }}"
                                                           target="_blank">{{$userInfo->student_details->student_photo->doc_file_name}} <i
                                                                    class="fa fa-download cursor-pointer"></i></a>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($userInfo->student_details->profession_type_id != \App\Enums\ProfessionType::JOB_HOLDER)
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="certificate_file"
                                                           class="font-weight-bold @if(!$userInfo->student_details->student_cert || !$userInfo->student_details->student_cert->doc_file_name) required @endif">Upload
                                                        Certificate </label>
                                                    <input type="file" class="form-control" id="certificate_file"
                                                           @if(!$userInfo->student_details->student_cert || !$userInfo->student_details->student_cert->doc_file_name) required
                                                           @endif  name="certificate_file"
                                                           placeholder="Upload Certificate"/>
                                                    {{--<small class="text-muted form-text"> </small>--}}
                                                    <span class="form-text ">Image upload must be 200KB.&nbsp;
                                                        @if ($errors->has('certificate_file'))
                                                            <div class="badge badge-danger"> {{$errors->first('certificate_file')}} </div>
                                                        @endif
                                                        @if($userInfo->student_details->student_cert && $userInfo->student_details->student_cert->doc_file_name)
                                                            <a class="btn btn-success btn-sm"
                                                               href="{{ route('login-user.certificate-download', [$userInfo->student_details->student_cert->self_development_file_id]) }}"
                                                               target="_blank">{{$userInfo->student_details->student_cert->doc_file_name}} <i
                                                                        class="fa fa-download cursor-pointer"></i></a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 table-responsive mt-2">
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
                                                    {{-- <th scope="col">Comment</th>--}}
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    {{--<th scope="row">1</th>--}}
                                                    <td>
                                                        <select class="form-control" id="exam_type" name="exam_type">
                                                            <option value="">Select</option>
                                                            {{--<option value="1" {{old('exam_type',isset($userInfo->student_details->exam_id) && $userInfo->student_details->exam_id == '1' ? 'selected' : '')}} >JSC</option>
                                                            <option value="2" {{old('exam_type',isset($userInfo->student_details->exam_id) && $userInfo->student_details->exam_id == '2' ? 'selected' : '')}}>SSC</option>--}}
                                                            @foreach($lExam as $value)
                                                                <option value="{{$value->exam_id}}"
                                                                        {{old('exam_type',isset($userInfo->student_details->exam_id) && $userInfo->student_details->exam_id == $value->exam_id ? 'selected' : '')}}>
                                                                    {{$value->exam_name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" placeholder=""
                                                               id="pass_year" name="pass_year"
                                                               value="{{old('pass_year',(isset($userInfo->student_details->pass_year) ? $userInfo->student_details->pass_year : ''))}}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" placeholder=""
                                                               id="reg_no" name="reg_no"
                                                               value="{{old('reg_no',(isset($userInfo->student_details->registration_no) ? $userInfo->student_details->registration_no : ''))}}">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" placeholder=""
                                                               id="roll_no" name="roll_no"
                                                               value="{{old('roll_no',(isset($userInfo->student_details->roll_no) ? $userInfo->student_details->roll_no : ''))}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder=""
                                                               id="gpa_division" name="gpa_division"
                                                               value="{{old('gpa_division',(isset($userInfo->student_details->gpa_division) ? $userInfo->student_details->gpa_division : ''))}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder=""
                                                               id="board" name="board"
                                                               value="{{old('board',(isset($userInfo->student_details->board) ? $userInfo->student_details->board : ''))}}">
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder=""
                                                               id="merit_no" name="merit_no"
                                                               value="{{old('merit_no',(isset($userInfo->student_details->merit_no) ? $userInfo->student_details->merit_no : ''))}}">
                                                    </td>
                                                    {{--<td>
                                                        <input type="text" class="form-control" placeholder="" id="s_comment" name="s_comment" >
                                                    </td>--}}
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="confirm">
                                            <button type="submit" class="eduspace-btn submit" value="submit">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    @elseif ($viewFor == \App\Enums\LViewFor::COURSE_PAGE)
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <h4>Course List</h4>
                                <hr>
                                <table class="table table-bordered table-sm dataTable" id="course_table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Batch</th>
                                        <th>Course Medium</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    @elseif ($viewFor == \App\Enums\LViewFor::EXAM_PAGE)
                        <div class="col-md-10">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upComing-tab" data-toggle="tab"
                                            data-target="#upComing"
                                            type="button" role="tab" aria-controls="home" aria-selected="true">Up-Coming
                                        {!! isset($upcoming) ? count($upcoming) > 0 ? '<span class="badge badge-danger ml-2">'.count($upcoming).'</span>' : '' : '' !!}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="oldExam-tab" data-toggle="tab" data-target="#oldExams"
                                            type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        Your Exams
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="upComing" role="tabpanel"
                                     aria-labelledby="upComing-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Exam Name</th>
                                                <th>Exam Date</th>
                                                <th>Exam Start At</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($upcoming as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>{{$exam->exam_date}}</td>
                                                    <td>{{$exam->exam_start_at}}</td>
                                                    <td><a class="btn btn-info btn-sm"
                                                           href="{{route('assessment.assessment-participate',['exam'=>encrypt($exam->exam_id),'trans'=>encrypt($exam->trans_id)])}}">Participate</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No upcoming exam found for
                                                        you.
                                                    </td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Exam Name</th>
                                                <th>Exam Date</th>
                                                <th>Exam Start At</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="oldExams" role="tabpanel" aria-labelledby="oldExam-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Exam Name</th>
                                                <th>Participation Date</th>
                                                <th>Result</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($old as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>{{$exam->exam_date}}</td>
                                                    <td>{!! ($exam->status == \App\Enums\Exam\LExamStatus::RESULT_PUBLISHED) ? '<span class="badge badge-success">Published</span>': '<span class="badge badge-info">Pending</span>'!!}</td>
                                                    <td>{!!  ($exam->status == \App\Enums\Exam\LExamStatus::RESULT_PUBLISHED) ? '<button class="btn btn-info btn-sm" onClick="resultView('.$exam->exam_id.','.$exam->trans_id.')">Result</button>' : '<button class="btn btn-sm btn-default">Result</button>' !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Participate in an exam to see
                                                        the exam list.
                                                    </td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Exam Name</th>
                                                <th>Participation Date</th>
                                                <th>Result</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($viewFor == \App\Enums\LViewFor::EVENT_PAGE)
                        <div class="col-md-10">
                            @include('backend.layouts.partial.flash-message')
                            <ul class="nav nav-tabs" id="eventTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upComingEvent-tab" data-toggle="tab"
                                            data-target="#upComingEvent"
                                            type="button" role="tab" aria-controls="home" aria-selected="true">Up-Coming
                                        Event/Competition
                                        {!! isset($upcoming) ? count($upcoming) > 0 ? '<span class="badge badge-danger ml-2">'.count($upcoming).'</span>' : '' : '' !!}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="oldExam-tab" data-toggle="tab" data-target="#oldExams"
                                            type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        Your Events/Competition
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="eventTabContent">
                                <div class="tab-pane fade show active" id="upComingEvent" role="tabpanel"
                                     aria-labelledby="upComingEvent-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Event/Competition</th>
                                                <th>Payment Status</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($upcomingEvent as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>{!! $exam->trans_status !!}</td>
                                                    <td>{{$exam->exam_date}}</td>
                                                    <td>{{$exam->exam_start_at}}</td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info"
                                                           href="{{route('event.event-detail', ['event'=>encrypt($exam->exam_id)])}}"
                                                           data-toggle="tooltip" data-placement="top" title="View"><i
                                                                    class="fa fa-eye"></i></a>
                                                        @if($exam->transaction_status_id == \App\Enums\LTransactionStatus::PENDING || $exam->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED )
                                                            @if($exam->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED)
                                                                |<a class="btn btn-info btn-sm" target="_blank"
                                                                    href="{{route('assessment.assessment-participate',['exam'=>encrypt($exam->exam_id),'trans'=>encrypt($exam->trans_id)])}}">Participate</a>
                                                            @endif
                                                        @else
                                                            |<a class="btn btn-sm btn-info"
                                                                href="{{route('login-user.pay-for-event', ['event'=>encrypt($exam->exam_id)])}}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Pay Now"><i class="fa fa-money"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No event found for you.</td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Event/Competition</th>
                                                <th>Payment Status</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="oldExams" role="tabpanel" aria-labelledby="oldExam-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Event/Competition Name</th>
                                                <th>Event Date</th>
                                                <th>Result Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($oldEvents as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>{{$exam->exam_date}}</td>
                                                    <td>{!! ($exam->exam_status) !!}</td>
                                                    <td>{!!  ($exam->status == \App\Enums\Exam\LExamStatus::RESULT_PUBLISHED) ? '<button class="btn btn-info btn-sm" onClick="resultView('.$exam->exam_id.','.$exam->trans_id.')">Result</button>' : '<button class="btn btn-sm btn-default">Result</button>' !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Participate in an event to see
                                                        the event list.
                                                    </td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Event/Competition Name</th>
                                                <th>Participation Date</th>
                                                <th>Result</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($viewFor == \App\Enums\LViewFor::SKILL_PAGE)
                        <div class="col-md-10">
                            @include('backend.layouts.partial.flash-message')
                            <ul class="nav nav-tabs" id="eventTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="upComingEvent-tab" data-toggle="tab"
                                            data-target="#upComingEvent"
                                            type="button" role="tab" aria-controls="home" aria-selected="true">Pending
                                        Skill Test
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="oldExam-tab" data-toggle="tab" data-target="#oldExams"
                                            type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        Participated Skill Tests
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="eventTabContent">
                                <div class="tab-pane fade show active" id="upComingEvent" role="tabpanel"
                                     aria-labelledby="upComingEvent-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Test Name</th>
                                                <th>Payment Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($pendingTests as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>@switch($exam->transaction_status_id)
                                                            @case(\App\Enums\LTransactionStatus::PENDING)
                                                            Pending
                                                            @break
                                                            @case(\App\Enums\LTransactionStatus::APPROVED)
                                                            Approved
                                                            @break
                                                            @default
                                                            Rejected
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info"
                                                           href="{{route('event.event-detail', ['event'=>encrypt($exam->exam_id)])}}"
                                                           data-toggle="tooltip" data-placement="top" title="View"><i
                                                                    class="fa fa-eye"></i></a>
                                                        @if($exam->transaction_status_id == \App\Enums\LTransactionStatus::PENDING || $exam->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED )
                                                            @if($exam->transaction_status_id == \App\Enums\LTransactionStatus::APPROVED)
                                                                |<a class="btn btn-info btn-sm" target="_blank"
                                                                    href="{{route('assessment.assessment-participate',['exam'=>encrypt($exam->exam_id),'trans'=>encrypt($exam->student_transaction_id)])}}">Participate</a>
                                                            @endif
                                                        @else
                                                            |<a class="btn btn-sm btn-info"
                                                                href="{{route('login-user.pay-for-event', ['event'=>encrypt($exam->exam_id)])}}"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Pay Now"><i class="fa fa-money"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No event found for you.</td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Test Name</th>
                                                <th>Payment Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="oldExams" role="tabpanel" aria-labelledby="oldExam-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm dataTable">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Test Name</th>
                                                <th>Participated On</th>
{{--                                                <th>Result Status</th>--}}
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($oldTests as $key=>$exam)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$exam->exam_name}}</td>
                                                    <td>{{$exam->participation_date}}</td>
{{--                                                    <td>{!! ($exam->exam_status) !!}</td>--}}
                                                    <td>{!! '<button class="btn btn-info btn-sm" onClick="resultView('.$exam->exam_id.','.$exam->student_transaction_id.')">Result</button>' !!}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">Participate in an event to see
                                                        the event list.
                                                    </td>
                                                </tr>

                                            @endforelse
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th>SL</th>
                                                <th>Test Name</th>
                                                <th>Participated On</th>
{{--                                                <th>Result</th>--}}
                                                <th>Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif ($viewFor == \App\Enums\LViewFor::COURSE_PAYMENT)
                        <div class="col-md-10">
                            <h4>Course Pay Form</h4>
                            <hr>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Payment Process Note</h4>
                                <p><b>Bank Acc:</b> DBBL A/C Name: abadhut-it, &nbsp;<b>A/C Number:</b>
                                    137.103.25306, &nbsp;<b>Branch:</b> Savar Bazar Branch, Dhaka.</p>
                                <p class="mb-0"><b>Bkash/Nagad No:</b> 01727-546514 &nbsp;<b>Roket No:</b> 01917-024110
                                </p>
                            </div>
                            {{--<form class="form-horizontal" @if(isset($courseId)) action="{{route('login.login-user-course-pay',[$courseId])}}" @endif method="post">--}}
                            <form class="form-horizontal"
                                  @if(isset($batchInfo->batch_id)) action="{{route('login-user.login-user-course-pay',[$batchInfo->batch_id])}}"
                                  @endif method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="pay_course_name">Course Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="pay_course_name" name="pay_course_name"
                                                   value="{{old('pay_course_name',(isset($batchInfo->course) ? $batchInfo->course->course_name_en : ''))}}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_amount">Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="trans_amount" name="trans_amount"
                                                   value="{{old('trans_amount',(isset($batchInfo->fee_amount) ? $batchInfo->fee_amount : ''))}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_payment_type">Payment
                                                Type</label>
                                            <select class="form-control" id="trans_payment_type"
                                                    name="trans_payment_type" required>
                                                <option value="" selected>Select</option>
                                                @foreach($LPayProcess as $value)
                                                    <option value="{{$value->payment_type_id}}">{{$value->process_name}}</option>
                                                @endforeach
                                                {{--<option value="1" >Bkash</option>
                                                <option value="2" >Nagad</option>
                                                <option value="3" >Rocket</option>
                                                <option value="4" >Bank</option>
                                                <option value="5" >Other</option>--}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_mobile_acc_name">Mobile No / Acc
                                                Name </label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Mobile No / Acc Name " id="trans_mobile_acc_name"
                                                   name="trans_mobile_acc_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_code_acc_no">Transaction Code /
                                                Acc No</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Transaction Code / Acc No" id="trans_code_acc_no"
                                                   name="trans_code_acc_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_date_time">Transaction Date &
                                                Time</label>
                                            <input type="datetime-local" class="form-control"
                                                   placeholder="Enter Transaction Date" id="trans_date_time"
                                                   name="trans_date_time" required>
                                            <span class="form-text badge badge-info">Please Click Icon & Select DateTime</span>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_remark">Remark</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Remark" id="trans_remark" name="trans_remark" >
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="confirm">
                                            <button type="submit" class="eduspace-btn submit" value="submit">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif ($viewFor == \App\Enums\LViewFor::EVENT_PAYMENT)
                        <div class="col-md-10">
                            @include('backend.layouts.partial.flash-message')
                            <h4>Make Payment</h4>
                            <hr>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Payment Process Note</h4>
                                <p><b>Bank Acc:</b> DBBL A/C Name: abadhut-it, &nbsp;<b>A/C Number:</b>
                                    137.103.25306, &nbsp;<b>Branch:</b> Savar Bazar Branch, Dhaka.</p>
                                <p class="mb-0"><b>Bkash/Nagad No:</b> 01727-546514 &nbsp;<b>Roket No:</b> 01917-024110
                                </p>
                            </div>
                            {{--<form class="form-horizontal" @if(isset($courseId)) action="{{route('login.login-user-course-pay',[$courseId])}}" @endif method="post">--}}
                            <form class="form-horizontal"
                                  @if(isset($eventInfo)) action="{{route('login-user.make-payment')}}"
                                  @endif method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="pay_course_name">Event/Competition
                                                Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="event_name" name="event_name"
                                                   value="{{old('event_name',(isset($eventInfo) ? $eventInfo->exam_name : ''))}}"
                                                   disabled>
                                            <input type="hidden" name="pay_for"
                                                   value="{{\App\Enums\Exam\LPayFor::EVENT_COMPETITION}}"/>
                                            <input type="hidden" name="exam" value="{{encrypt($eventInfo->exam_id)}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_amount">Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="trans_amount" name="trans_amount"
                                                   value="{{old('trans_amount',(isset($eventInfo) ? $eventInfo->price : ''))}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_payment_type">Payment
                                                Type</label>
                                            <select class="form-control" id="trans_payment_type"
                                                    name="trans_payment_type" required>
                                                <option value="" selected>Select</option>
                                                @foreach($LPayProcess as $value)
                                                    <option value="{{$value->payment_type_id}}">{{$value->process_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_mobile_acc_name">Mobile No / Acc
                                                Name </label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Mobile No / Acc Name " id="trans_mobile_acc_name"
                                                   name="trans_mobile_acc_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_code_acc_no">Transaction Code /
                                                Acc No</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Transaction Code / Acc No" id="trans_code_acc_no"
                                                   name="trans_code_acc_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_date_time">Transaction Date &
                                                Time</label>
                                            <input type="datetime-local" class="form-control"
                                                   placeholder="Enter Transaction Date" id="trans_date_time"
                                                   name="trans_date_time" required>
                                            <span class="form-text badge badge-info">Please Click Icon & Select DateTime</span>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_remark">Remark</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Remark" id="trans_remark" name="trans_remark" >
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="confirm">
                                            <button type="submit" class="eduspace-btn submit" value="submit">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @elseif ($viewFor == \App\Enums\LViewFor::SKILL_PAYMENT)
                        <div class="col-md-10">
                            @include('backend.layouts.partial.flash-message')
                            <h4>Make Payment</h4>
                            <hr>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">Payment Process Note</h4>
                                <p><b>Bank Acc:</b> DBBL A/C Name: abadhut-it, &nbsp;<b>A/C Number:</b>
                                    137.103.25306, &nbsp;<b>Branch:</b> Savar Bazar Branch, Dhaka.</p>
                                <p class="mb-0"><b>Bkash/Nagad No:</b> 01727-546514 &nbsp;<b>Roket No:</b> 01917-024110
                                </p>
                            </div>
                            {{--<form class="form-horizontal" @if(isset($courseId)) action="{{route('login.login-user-course-pay',[$courseId])}}" @endif method="post">--}}
                            <form class="form-horizontal"
                                  @if(isset($eventInfo)) action="{{route('login-user.make-payment')}}"
                                  @endif method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="pay_course_name">Skill Test
                                                Name</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="event_name" name="event_name"
                                                   value="{{old('event_name',(isset($eventInfo) ? $eventInfo->exam_name : ''))}}"
                                                   disabled>
                                            <input type="hidden" name="pay_for"
                                                   value="{{\App\Enums\Exam\LPayFor::SKILL_TEST}}"/>
                                            <input type="hidden" name="exam" value="{{encrypt($eventInfo->exam_id)}}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_amount">Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount"
                                                   id="trans_amount" name="trans_amount"
                                                   value="{{old('trans_amount',(isset($eventInfo) ? $eventInfo->price : ''))}}"
                                                   readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_payment_type">Payment
                                                Type</label>
                                            <select class="form-control" id="trans_payment_type"
                                                    name="trans_payment_type" required>
                                                <option value="" selected>Select</option>
                                                @foreach($LPayProcess as $value)
                                                    <option value="{{$value->payment_type_id}}">{{$value->process_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_mobile_acc_name">Mobile No / Acc
                                                Name </label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Mobile No / Acc Name " id="trans_mobile_acc_name"
                                                   name="trans_mobile_acc_name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_code_acc_no">Transaction Code /
                                                Acc No</label>
                                            <input type="text" class="form-control"
                                                   placeholder="Enter Transaction Code / Acc No" id="trans_code_acc_no"
                                                   name="trans_code_acc_no" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_date_time">Transaction Date &
                                                Time</label>
                                            <input type="datetime-local" class="form-control"
                                                   placeholder="Enter Transaction Date" id="trans_date_time"
                                                   name="trans_date_time" required>
                                            <span class="form-text badge badge-info">Please Click Icon & Select DateTime</span>
                                        </div>
                                    </div>
                                    {{--<div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_remark">Remark</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Remark" id="trans_remark" name="trans_remark" >
                                        </div>
                                    </div>--}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="confirm">
                                            <button type="submit" class="eduspace-btn submit" value="submit">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <h4>Payment List</h4>
                                @if(Session::has('message'))
                                    {{--<div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show mt-2" role="alert">
                                        <h4 class="alert-heading">{{ (Session::get('code') == '1') ? __('Congratulation!') : __('Oops!!') }}</h4>
                                        <p>{{ Session::get('message') }}</p>
                                        @if(Session::get('code') == '1')
                                            <hr>
                                            <p class="mb-0">Whenever we validate your payment you will be notified. Keep eyes on
                                                <a href="{{route('login-user.login-user-payable-courses')}}">Payment List</a>.
                                            </p>
                                        @endif
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>--}}
                                    <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} alert-dismissible fade show mt-2"
                                         role="alert">
                                        <h4 class="alert-heading">{{ (Session::get('code') == '1') ? __('Congratulation!') : __('Oops!!') }}</h4>
                                        <p>{{ Session::get('message') }}</p>
                                        @if(Session::get('code') == '1')
                                            <hr>
                                            <p class="mb-0">Whenever we validate your payment you will be notified. Keep
                                                eyes on
                                                <a href="{{route('login-user.login-user-payable-courses')}}">Payment
                                                    List</a>.
                                            </p>
                                        @endif
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <hr>
                                <table class="table table-bordered table-sm dataTable"
                                       id="payable_course_table" {{--style="display: none"--}}>
                                    <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Batch</th>
                                        <th>Course Medium</th>
                                        <th>Remarks</th>
                                        <th>Payment Status</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="resultModal" role="dialog" aria-labelledby="resultModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header <!--cus-bg-color-->">
                                        <h5 class="modal-title text-center" id="resultModalTitle">Exam Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="rContent"></div>
                </div>
                <!--                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>-->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header <!--cus-bg-color-->">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <!-- Your share FB button code -->
                        <div class="fb-share-button" data-href="" data-layout="button_count"></div>
                        <!-- Your share LinkedIn button code -->
                        <script type="IN/Share" class="social-hare" data-url=""></script>
                    </div>
                    <span>Copy and share!</span>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control cert-copy" aria-label="Share Certificate"
                               aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-info input-group-text" id="copy">click</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--End login-form Section-->
@endsection
@section('footer-script')
    <script async
            src={{"https://platform.twitter.com/widgets.js"}} charset="utf-8"></script> {{-- Block this section Pavel-31-12-22 / Open-13-05-23 --}}
    <script src={{"https://platform.linkedin.com/in.js"}} type="text/javascript"></script>
    <script type="text/javascript">

        function sameAddressCheckYn() {
            $("#permanent_address_same_present").on("click", function () {
                //e.preventDefault();

                if (this.checked) {
                    $("#permanent_address").val($("#present_address").val());
                    $("#permanent_address").attr("readonly", true);
                } else {
                    $("#permanent_address").removeAttr("readonly", false);
                    $("#permanent_address").val('');
                }
            });
        }

        function courseDatalist() {
            let courseTable = $('#course_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/login-user-course-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course.course_code"},
                    {"data": "course.course_name_en"},
                    {"data": "batch_name_en"},
                    {"data": "course_medium"},
                    {"data": "action"}
                ]
            });
        }

        function payableCourseDatalist() {
            let payableCourseTable = $('#payable_course_table').dataTable({
                processing: true,
                serverSide: true,
                searching: true,
                ajax: {
                    url: APP_URL + '/login-user-payable-course-datalist',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                "columns": [
                    {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                    {"data": "course_code"},
                    {"data": "course_name"},
                    {"data": "batch"},
                    {"data": "course_medium"},
                    {"data": "note"},
                    {"data": "action"}
                ]
            });
        }

        $(document).on("click", '.user-status', function (e) {
            e.preventDefault();
            let action_url = this;
            let student_status_id = $(this).data('user-status');
            let student_trans = $(this).data('tran-status');

            //alert(student_status_id+'==='+student_trans);

            if (student_status_id == '0') {
                swal.fire({
                    title: 'Sorry...',
                    text: 'Your profile is not updated please update your profile.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Update it!'
                }).then(function (isConfirm) {
                    //console.log(isConfirm);
                    if (isConfirm.value == true) {
                        //form.submit();
                        let url = '{{ route('login-user.login-user-profile') }}';
                        window.location.href = url;
                    } else if (isConfirm.dismiss == "cancel") {
                        //return false;
                        e.preventDefault();
                    }
                })
            } else if ((student_trans == '{{\App\Enums\LTransactionStatus::PENDING}}') || (student_trans == '{{\App\Enums\LTransactionStatus::APPROVED}}')) {
                swal.fire({
                    title: 'Sorry...',
                    text: 'Your are already payment this course.',
                    icon: 'warning',
                });
            } else {
                window.location.href = action_url;
            }

        });

        $(document).ready(function () {
            sameAddressCheckYn();
            courseDatalist();
            payableCourseDatalist();
        });
    </script>
    <script type="text/javascript">

        function resultView(exam, tran) {
            let request = $.ajax({
                url: APP_URL + "/assessment-result",
                method: 'GET',
                data: {exam, tran},
                dataType: 'JSON',
                headers: {
                    'x-csrf-token': tk
                }
            });
            request.done(function (res) {
                if (res.response_code == 1) {
                    $("#rContent").html(res.content);
                    $("#resultModal").modal("show");
                } else {
                    swal.fire({
                        text: res.response_msg,
                        icon: 'warning',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        timer: 9000
                    })
                }
            });
            request.fail(function (xhr) {
                swal.fire({
                    text: xhr,
                    icon: 'warning',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 9000
                })
            });
        }

        $(document).on('click', '#shareCert', function () {
            let cert = $(this).data('cert');
            $(".cert-copy").val(cert);
            $(".fb-share-button").attr('data-href', cert);
            $(".social-share").attr('data-url', cert);
            $("#shareModal").modal("show");
            copyClipboard();
        })

        function copyClipboard() {
            $("#copy").on('click', function () {
                $(".cert-copy").select();
                document.execCommand("copy");
                $(this).text("copied!");
                setTimeout(function () {
                    $("#copy").text("click");
                }, 3000);
            })
        }
    </script>
@endsection