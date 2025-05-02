@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Topic Setup</h3>
            <hr>
            <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate
                  @if(isset($insertedData))
                  action="{{ route('setup.topic-update',['id'=>$insertedData->id]) }}">
                @method('PUT')
                @else
                    action="{{route('setup.topic-store')}}">
                @endif
                @csrf
                <div class="row d-flex justify-centent-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <label class="form-label" for="topic_name">Topic Name</label>
                        <input type="text" required class="form-control" id="topic_name" name="topic_name"
                               value="{{ old('topic_name',isset($insertedData) ? $insertedData->name : '') }}">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please write topic name.
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
                        <button type="submit" class="btn btn-success">{{isset($insertedData) ? 'Update' : 'Save'}}</button>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Topic Lists</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th>SL</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topics as $key=>$topic)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$topic->name}}</td>
                            <td>{{($topic->active_yn == 'Y') ? 'Active' : 'In-Active'}}</td>
                            <td><a href="{{route("setup.topic-edit",["id"=>$topic->id])}}"><i
                                            class="fa fa-edit"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
