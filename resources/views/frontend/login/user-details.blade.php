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
            <div class="col-md-12 border border-success mb-5 mt-5 p-4" >


                <div class="row">
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
                            <li><i class="fa fa-angle-right"></i><a href="#">Profile</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="{{route('login.login-user-details')}}">Course List</a></li>
                            <li><i class="fa fa-angle-right"></i><a href="{{route('login.index')}}">Logout</a></li>
                        </ul>
                    </div>

                    @if (!isset($courseId))
                        <div class="col-md-10">
                            <div class="table-responsive">
                                <h4>Course List</h4>
                                @if(Session::has('message'))
                                    <div class="alert {{Session::get('m-class') ? Session::get('m-class') : 'alert-danger'}} show mt-2"
                                         role="alert">
                                        {{ Session::get('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <hr>
                                <table class="table table-bordered table-sm dataTable" id="course_table" {{--style="display: none"--}}>
                                    <thead class="thead-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Course Code</th>
                                        <th>Course Name</th>
                                        <th>Course Medium</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if (isset($courseId))
                        <div class="col-md-10">
                            <h4>Course Pay Form</h4>
                            <hr>
                            <form class="form-horizontal" @if(isset($courseId)) action="{{route('login.login-user-course-pay',[$courseId])}}" @endif method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_payment_type">Payment Type</label>
                                            <select class="form-control" id="trans_payment_type" name="trans_payment_type" >
                                                <option value="" selected>Select</option>
                                                <option value="1" >Bkash</option>
                                                <option value="2" >Bank</option>
                                                <option value="3" >Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_mobile_acc">Mobile No & Transaction Code / Acc Name & No</label>
                                            <input type="text" class="form-control" placeholder="Enter Mobile No &Transaction Code / Acc Name & No" id="trans_mobile_acc" name="trans_mobile_acc" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_amount">Amount</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Amount" id="trans_amount" name="trans_amount" >
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="font-weight-bold" for="trans_remark">Remark</label>
                                            <input type="text" class="form-control" placeholder="Enter Your Remark" id="trans_remark" name="trans_remark" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="confirm">
                                            <button type="submit" class="eduspace-btn submit" value="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif

                </div>


            </div>
        </div>
    </div>

    <!--End login-form Section-->
@endsection
@section('footer-script')
<script type="text/javascript">


    $(document).ready(function () {
        let courseTable = $('#course_table').dataTable({
            processing: true,
            serverSide: true,
            searching: true,
            ajax: {
                url: APP_URL + '/login/login-user-course-datalist',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                /*data: function (params) {
                    // Retrieve dynamic parameters
                    var dt_params = $('#course_table').data('dt_params');
                    // Add dynamic parameters to the data object sent to the server
                    if (dt_params) {
                        $.extend(params, dt_params);
                    }
                }*/
            },
            "columns": [
                {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
                {"data": "course_code"},
                {"data": "course_name_en"},
                {"data": "course_medium"},
                {"data": "action"}
            ]
        });

    });
</script>
@endsection