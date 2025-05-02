<?php
/**
 *Created by PhpStorm
 *Created at ৬/১/২২ ১০:৫৩ AM
 */
?>
@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Category Setup</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate
                  @if(isset($insertedData))
                  action="{{ route('post-category-setup.update',['id'=>$insertedData->post_category_id]) }}">
                @method('PUT')
                @else
                    action="{{route('post-category-setup.store')}}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="name" class="form-label required">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name',isset($insertedData) ? $insertedData->name : '') }}" required>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                        <div class="invalid-feedback">
                            Please give a english type name.
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="category_for" class="form-label required">Category For</label>
                        <select class="form-control" name="category_for" required>
                            <option {{ (old('category_for',isset($insertedData) ? $insertedData->category_for : '') == 'B') ? 'selected' : '' }} value="B">Blog</option>
                            <option {{ (old('category_for',isset($insertedData) ? $insertedData->category_for : '') == 'S') ? 'selected' : '' }} value="S">Service</option>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Active</label>
                        <div class="mb-3">
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" value="{{\App\Enums\PostCategoryStatus::ACTIVE}}"
                                       name="active_yn" id="active_y"
                                       {{ (old('active_yn',isset($insertedData) ? $insertedData->status : '') == \App\Enums\PostCategoryStatus::ACTIVE) ? 'Checked' : '' }}
                                       autocomplete="off"
                                       checked >
                                <label class="btn btn-outline-success" for="active_y">Yes</label>

                                <input type="radio" class="btn-check"
                                       value="{{\App\Enums\PostCategoryStatus::INACTIVE}}" name="active_yn"
                                       id="active_n"
                                       {{ (old('active_yn',isset($insertedData) ? $insertedData->status : '') == \App\Enums\PostCategoryStatus::INACTIVE) ? 'Checked' : '' }}
                                       autocomplete="off">
                                <label class="btn btn-outline-danger" for="active_n">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary my-4 mx-2" type="submit">@isset($insertedData)  Update @else
                                    Save @endisset</button>
                            @isset($insertedData)
                                <a href="{{route('post-category-setup.index')}}" class="btn btn-info my-4">Cancel</a>
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
                        <th>SL</th>
                        <th>Name</th>
                        <th>Category For</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $index=>$key)
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td>{{ $key->name }}</td>
                            <td>{{ ($key->category_for == 'B') ? 'Blog' : 'Service' }}</td>
                            <td>{{ ($key->status == \App\Enums\PostCategoryStatus::ACTIVE) ? "Active" : "Inactive" }}</td>
                            <td>
                                <div class="row mx-0 px-0">
                                    <div class="col-md-12 mx-0 px-0">
                                        <a class="btn btn-sm btn-info"
                                           href="{{route('post-category-setup.edit',['id'=>$key->post_category_id])}}"><i
                                                    class="bx bx-edit"></i>Edit</a>
                                        @isset($insertedData)
                                            @if ($insertedData->post_category_id != $key->post_category_id)
                                                <form class="isConfirmOnSubmit" style="display: inline"
                                                      action="{{route('post-category-setup.delete',['id'=>$key->post_category_id])}}"
                                                      method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" type="submit"><i
                                                                class="bx bx-trash"></i>Remove
                                                    </button>
                                                </form>
                                            @else
                                            @endif
                                        @else
                                            <form class="isConfirmOnSubmit" style="display: inline"
                                                  action="{{route('post-category-setup.delete',['id'=>$key->post_category_id])}}"
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

