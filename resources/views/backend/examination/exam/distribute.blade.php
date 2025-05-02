@extends('backend.layouts.default')
@section("title") @endsection

@section("header-style") @endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <h4>Exam Distribute</h4>
            <hr>
            <div class="row">
                <div class="col-md-8 offset-3">
                    <form class="needs-validation" id="popup-validation" name="examForm"
                          method="post"
                          @if(isset($exam))
                          action="{{route('exam.update',['id'=>$exam->exam_id])}}"
                          @else
                          action="{{route('exam.create')}}"
                            @endif
                    >
                        @isset($exam) @method("put")  @endisset
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                    <label for="course" class="form-label required">Course</label>
                                    <select class="form-control" name="course" id="course" required>
                                        <option value="">Select Course</option>
                                        @foreach($course as $c)
                                            <option value="{{ $c->course_id }}" {{ (old('course',isset($insertedData) ? $insertedData->course_id : '') == $c->course_id) ? 'selected' : '' }}>{{ $c->course_name_en }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a course.
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="make-readonly">
                                    <label for="batch" class="form-label required">Batch</label>
                                    <select readonly="" class="form-control form-control-sm" name="batch" id="batch" required>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                    <div class="invalid-feedback">
                                        Please set a batch.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-sm" id="studentList">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th><div  class="checkbox input-group">
                                                <input class="" type="checkbox" id="selectYN_" onclick="checkAll(this)"/>
                                                <label class="form-label" for="selectYN_"><strong>ALL</strong></label>
                                            </div></th>
                                        <th>Student</th>
                                        <th>Profession</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Selector</th>
                                        <th>Student</th>
                                        <th>Profession</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                        <div class="form-actions row mt-1">
                            <div class="col-md-8 d-flex justify-content-center">
                                <input type="submit" value="{{isset($exam) ? 'Update' : 'Submit' }}"
                                       class="btn btn-primary col-md-4">
                                <a href="{{route('exam.list')}}" class="btn btn-info mx-2">Back</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection

@section("footer-script")
    <script src="{{ asset('backend/assets/js/pages/exam/examDistribute.js') }}"></script>
@endsection