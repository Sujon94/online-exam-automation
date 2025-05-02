@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-header bg-white">
            <i class="fa fa-table"></i> List of Exams
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="eStatus">Filter</label>
                        <select name="status" class="form-control" id="eStatus">
                            <option value="">Select One</option>
                            <option value="{{\App\Enums\Exam\LExamStatus::COMPLETED}}">Result Pending</option>
                            <option value="{{\App\Enums\Exam\LExamStatus::RESULT_PUBLISHED}}">Result Published</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table id="examTable" class="dataTable display table table-sm table-stripped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Exam Type</th>
                        <th>Exam Date</th>
                        <th class="text-center">Total Question</th>
                        <th class="text-center">Multiple Choice</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Written</th>
                        <th class="text-center">Participant</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Exam Name</th>
                        <th>Exam Type</th>
                        <th>Exam Date</th>
                        <th class="text-center">Total Question</th>
                        <th class="text-center">Multiple Choice</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Written</th>
                        <th class="text-center">Participant</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section("footer-script")
    <script type="text/javascript" src="{{asset('backend/assets/js/pages/exam/resultProcess.js')}}"></script>

@endsection