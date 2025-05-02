@extends('backend.layouts.default')

@section('title')

@endsection

@section('header-style')

@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- Table Start -->
                <div class="card-body">
                    <h4 class="card-title">Student Profile</h4><!---->
                    <hr>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="card overflow-hidden">
                                <div class="bg-primary bg-soft">
                                    <div class="row">
                                        <div class="col-7">
                                            <div class="text-primary p-3">
                                                <h5 class="text-primary">
                                                    <h5 class="font-size-15 text-truncate"></h5>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-5 align-self-end">
                                            <img src="" alt="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="avatar-md profile-user-wid mb-4">
                                                <img src="@if(isset($student->photo->doc_file))
                                                        data:{{ isset($student->photo->doc_file_type) ? $student->photo->doc_file_type : '' }};base64,{{ isset($student->photo->doc_file) ? $student->photo->doc_file : '' }}
                                                @else
                                                {{ asset('backend/assets/images/users/avatar.jpg') }}
                                                @endif" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                            <h5 class="font-size-15 text-truncate">{{$student->candidate_name}}</h5>
                                            <p class="text-muted mb-0 text-truncate">{{$student->profession_type->type_name}}</p>
                                        </div>

                                        <div class="col-sm-8">
                                            <div class="pt-4">

                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="font-size-15">0</h5>
                                                        <p class="text-muted mb-0">Courses Enrolled</p>
                                                    </div>
                                                </div>{{--
                                                <div class="mt-4">
                                                    <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Personal Information</h4>

                                    <p class="text-muted mb-4"><!-Information-></p>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap mb-0">
                                            <tbody>
                                            @if($student->profession_type_id == \App\Enums\ProfessionType::STUDENT)

                                                <tr>
                                                    <th scope="row">Father Name :</th>
                                                    <td>{{$student->father_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Mother Name :</th>
                                                    <td>{{$student->mother_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Guardian Name :</th>
                                                    <td>{{$student->guardian_name}}</td>
                                                </tr>

                                                <tr>
                                                    <th scope="row">Date Of Birth :</th>
                                                    <td>{{$student->date_of_birth}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Religion :</th>
                                                    <td>{{isset($student->religion) ? $student->religion->religion_name : ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Nationality :</th>
                                                    <td>{{$student->nationality}}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th scope="row">Mobile :</th>
                                                <td>{{$student->mobile}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">E-mail :</th>
                                                <td>{{$student->email}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Present Address :</th>
                                                <td>{{$student->present_address}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                            @if($student->profession_type_id == \App\Enums\ProfessionType::STUDENT)
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Education Qualification</h4>
                                        <p class="text-muted mb-4"><!-Information-></p>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Exam :</th>
                                                    <td>{{$student->father_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Pass Year :</th>
                                                    <td>{{$student->pass_year}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Institute Name :</th>
                                                    <td>{{$student->institute_name}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Registration No :</th>
                                                    <td>{{$student->registration_no}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Roll No :</th>
                                                    <td>{{$student->roll_no}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">GPA/Division :</th>
                                                    <td>{{$student->gpa_division}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Board :</th>
                                                    <td>{{$student->board}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Merit No :</th>
                                                    <td>{{$student->merit_no}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        <!-- end card -->
                            @if($student->profession_type_id == \App\Enums\ProfessionType::JOB_HOLDER)
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Education Qualification</h4>
                                        <p class="text-muted mb-4"><!-Information-></p>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                <tr>
                                                    <th scope="row">Academic Background :</th>
                                                    <td>{{$student->academic_background}}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-5">Professional Information</h4>
                                        <div class="">
                                            <ul class="verti-timeline list-unstyled">
                                                <li class="event-list active">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-server h4 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5 class="font-size-15"><a href="javascript: void(0);"
                                                                                            class="text-dark">{{$student->designation}}</a>
                                                                </h5>
                                                                <span class="text-primary">{{$student->organization}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-5">Document Download:</h4>
                                    <div class="">
                                        <ul class="verti-timeline list-unstyled">
                                            @isset($student->photo)

                                                <li class="event-list active">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bxs-user-rectangle h4 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5 class="font-size-15"><a class="text-primary"
                                                                                            href="{{route('student.file-download',['id'=>$student->photo->self_development_file_id])}}">Profile
                                                                        Photo</a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endisset

                                            @isset($student->student_cert)
                                                <li class="event-list active">
                                                    <div class="event-timeline-dot">
                                                        <i class="bx bx-right-arrow-circle bx-fade-right"></i>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <i class="bx bx-paperclip h4 text-primary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div>
                                                                <h5 class="font-size-15"><a class="text-primary"
                                                                                            href="{{route('student.file-download',['id'=>$student->student_cert->self_development_file_id])}}">Certificate</a>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endisset
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('footer-script')
@endsection