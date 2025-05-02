@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Certificate Manager</h3>
            <hr>
            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate
              @if(isset($insertedData))
                  action="{{ route('setup.certificate-update',['id'=>$insertedData->id]) }}">
                @method('PUT')
                @else
                    action="{{route('setup.certificate-store')}}">
                @endif
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="form-label required" for="certificate_name">Certificate Identifier</label>
                        <input type="text" required class="form-control" id="certificate_name" name="certificate_name"
                               value="{{ old('certificate_name',isset($insertedData) ? $insertedData->name : '') }}">
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
                        <label class="form-label" for="cert_image">Certificate</label>
                        <input id="cert_image" name="cert_image" type="file"
                               data-preset="{{ isset($exam) ? (isset($exam->image_file) ? "Y" : "N" ) : "N"  }}"
                               class="form-control"
                               accept="image/*">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please provide note.
                        </div>
                        @if(isset($exam))
                            @if (isset($exam->image_file))
                                <p>File Name: {{$exam->image_file->doc_file_name}} (<a
                                            href="{{route('exam.event-file-download',['id'=>$exam->image_file->self_development_file_id])}}"><i
                                                class="bx bx-download"></i></a>)
                                </p>
                            @endif
                        @endisset
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
            <h4>Certificate Lists</h4>
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
                    @forelse($certificates as $key=>$subject)
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
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No certificate uploaded yet.</td>
                        </tr>
                    @endforelse
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
