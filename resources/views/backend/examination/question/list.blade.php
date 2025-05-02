@extends("backend.layouts.default")
@section("title")
@endsection

@section("header-style")
@endsection

@section("content")
    <div class="card">
        <div class="card-body">
            <h3>
                <i class="fa fa-table"></i> List of questions
            </h3>
<!--            <fieldset class="border p-2 mb-3">
                <legend class="w-25">Filters</legend>
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label for="subject" class="col-form-label">Subject</label>
                        <select name="subject" id="subject" class="validate[required] form-control select2">
                            <option value="">Select a Subject</option>
                            @foreach ($subjects as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="topic" class="col-form-label">Topics</label>
                        <select name="topic" id="topic" class="validate[required] form-control select2">
                            <option value="">Select a topic</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="type" class="col-form-label">Type</label>
                        <select name="questionType" id="type"
                                class="validate[required] form-control select2">
                            <option value="">Select a type</option>
                            @foreach ($types as $t)
                                <option value="{{$t->id}}">{{$t->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label  class="col-form-label">&nbsp;</label>
                        <button class="btn btn-success form-control">Search</button>
                    </div>
                </div>

            </fieldset>-->
            <div class="row">
                <div class="col-12">
                    <table class="table table-stripped table-bordered" id="questionList">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Subject</th>
                            <th>Topic</th>
                            <th>Question Type</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Subject</th>
                            <th>Topic</th>
                            <th>Question Type</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        @foreach ($questions as $key=>$q)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>
                                    @if($q->format_id == \App\Enums\Exam\LEQuestionFormat::IMAGE)
                                        <img width="100" height="100"
                                             src="{{ 'data:'.$q->file->doc_file_type.';base64,'.$q->file->doc_file}}" alt=""
                                             class="">
                                    @else
                                        {{htmlspecialchars($q->question)}}
                                    @endif
                                </td>
                                <td>{{$q->subject->name}}</td>
                                <td>{{$q->topic->name}}</td>
                                <td>{{$q->type->type}}</td>
                                <td>
                                    <a href="{{route('question.edit',['id'=>$q->id])}}" class="edit cursor-pointer" data-toggle="tooltip" data-placement="top"
                                            title="edit" id="questionPreview"
                                    ><i class="fa fa-edit text-warning"></i></a>
<!--                                    <span class="edit cursor-pointer" data-toggle="tooltip" data-placement="top"
                                            title="View" id="questionPreview"
                                    ><i class="fa fa-eye text-warning"></i></span>-->
                                    &nbsp; &nbsp;
                                    <a href="{{route('question.remove',['id'=>$q->id])}}"
                                       class="delete" data-toggle="tooltip" data-placement="top"
                                       title="Delete"><i class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("footer-script")
    <script type="text/javascript">

        $("#questionList").dataTable();

        submit();
        function submit() {
            $("form[name=questionForm]").submit(function (e) {
                e.preventDefault();

                swal.fire({
                    text: 'Create Confirm?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.value == true) {
                        let request = $.ajax({
                            url: '{{route("question.store")}}',
                            type: 'POST',
                            processData: false,
                            contentType: false,

                            header: {'x-csrf-token': '{{csrf_token()}}'},
                            data: new FormData($(this)[0])
                        });

                        request.done(function (res) {
                            if (res.response_code != "99") {
                                Swal.fire({
                                    icon: 'success',
                                    text: res.response_msg,
                                    showConfirmButton: false,
                                    timer: 2000,
                                    allowOutsideClick: false
                                }).then(function () {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({text: res.response_msg, icon: 'error'});
                            }
                        });

                        request.fail(function (jqXHR, textStatus) {
                            console.log(jqXHR);
                        });
                    }
                })
            })

        }



        $("#subject").on('change', function () {
            let response = $.ajax({
                url: '{{route('ajax.topics-of-subject')}}',
                data: {'subject-id': $(this).find(':selected').val()}
            });
            response.done(function (d) {
                $("#topic").html(d.options);
            });

            response.fail(function (d) {
                console.log(d);
            });
        })
        
        function questionPreview() {

        }

    </script>
@endsection
