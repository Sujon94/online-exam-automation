@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Course Type Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate
                  @if(isset($insertedData))
                  action="{{ route('course-type-setup.update',['id'=>$insertedData->id]) }}">
                @method('PUT')
                @else
                    action="{{route('course-type-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type_name_en" class="form-label required">Type Name (En)</label>
                            <input type="text" class="form-control" id="type_name_en" name="type_name_en" value="{{ old('type_name_en',isset($insertedData) ? $insertedData->type_name_en : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a english type name.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type_name_bn" class="form-label required">Type Name (Bn)</label>
                            <input type="text" class="form-control" id="type_name_bn" name="type_name_bn" value="{{ old('type_name_bn',isset($insertedData) ? $insertedData->type_name_bn : '') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a bangla type name.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type_name_bn" class="form-label">Course Code</label>
                            <input type="text" class="form-control" id="course_code" name="course_code" value="{{ old('course_code',isset($insertedData) ? $insertedData->type_code : '') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Active</label>
                        <div class="mb-3">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" value="Y" name="active_yn" id="active_y" {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'Y') ? 'Checked' : '' }}
                                autocomplete="off"
                                       checked>
                                <label class="btn btn-outline-success" for="active_y">Yes</label>

                                <input type="radio" class="btn-check" value="N" name="active_yn" id="active_n" {{ (old('active_yn',isset($insertedData) ? $insertedData->active_yn : '') == 'N') ? 'Checked' : '' }}
                                autocomplete="off">
                                <label class="btn btn-outline-danger" for="active_n">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary my-4 mx-2" type="submit">@isset($insertedData)  Update @else Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('course-type-setup.index')}}" class="btn btn-info my-4">Cancel</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Course Type List</h4>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-sm dataTable"
                       id="course_type_table" {{--style="display: none"--}}>
                    <thead class="thead-dark">
                    <tr>
                        <th width="11%">SL</th>
                        <th width="11%">Course Type English</th>
                        <th width="55%">Course Type Bangla</th>
                        <th width="19%">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($courseTypes as $key=>$type)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $type->type_name_en }}</td>
                            <td>{{ $type->type_name_bn }}</td>
                            <td>
                                <div class="row mx-0 px-0">
                                    <div class="col-md-12 mx-0 px-0">
                                        <a class="btn btn-sm btn-info"
                                           href="{{route('course-type-setup.edit',['id'=>$type->id])}}"><i
                                                    class="bx bx-edit"></i>Edit</a>
                                        @isset($insertedData)
                                            @if ($insertedData->id != $type->id)

                                            @endif
                                        @else
                                            <form class="isConfirmOnSubmit" style="display: inline"
                                                  action="{{route('course-type-setup.delete',['id'=>$type->id])}}"
                                                  method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit"><i
                                                            class="bx bx-trash"></i>Remove
                                                </button>
                                            </form>
                                        @endisset
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Data Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer-script')

    $(document).ready(function () {

    });
@endsection
