@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Subject Setup</h3>
            <hr>
            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate
                  @if(isset($insertedData))
                  action="{{ route('setup.subject-update',['id'=>$insertedData->id]) }}">
                @method('PUT')
                @else
                    action="{{route('setup.subject-store')}}">
                @endif
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="form-label" for="subject_name">Subject Name</label>
                        <input type="text" required class="form-control" id="subject_name" name="subject_name"
                               value="{{ old('subject_name',isset($insertedData) ? $insertedData->name : '') }}">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please write title.
                        </div>

                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="form-label" for="subject_name">Topic/Chapter Name</label>
                        <select class="form-control" id="topics" name="topic[]" multiple>
                            @foreach($topics as $topic)
                                <option value="{{$topic->id}}" {{isset($topic->selected) ?'selected' : ''}}>{{$topic->name}}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please write title.
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <input name="in_active" value="N"
                               {{ old('in_active',isset($insertedData) ? ($insertedData->active_yn == 'N' ? 'checked' : '') : '') }}  type="checkbox"
                               class="checkbox" aria-label="Checkbox for following text input">In-Active
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 d-flex justify-content-end pt-1">
                        <button type="submit"
                                class="btn btn-success m-1">{{isset($insertedData) ? 'Update' : 'Save'}}</button>
                        @if(isset($insertedData))
                            <a href="{{route("setup.subject-index")}}" class="btn btn-info p-2 m-1">Cancel</a>
                        @endif

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Subject Lists</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Subject</th>
                        <th>Topics</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $key=>$subject)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$subject->name}}</td>
                            <td>
                                @php $topics=[] @endphp
                                @foreach($subject->topics as $sTopic)
                                    @if(isset($sTopic->topic))
                                        @php $topics[] = $sTopic->topic->name; @endphp
                                    @endif
                                @endforeach
                                @php echo implode(',',$topics) @endphp
                            </td>
                            <td>{{($subject->active_yn == 'Y') ? 'Active' : 'In-Active'}}</td>
                            <td><a href="{{route("setup.subject-edit",["id"=>$subject->id])}}"><i
                                            class="fa fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('footer-script')
    <script>
        $("#topics").select2({
            placeholder: "Select Topic"
        });
    </script>
@endsection
