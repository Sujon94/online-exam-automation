@extends("backend.layouts.default")

@section('title')
@endsection

@section('header-style')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Global SEO</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate action="{{ route('web-setting.appearance-store-update') }}" >
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="meta_title" class="form-label required">Meta Title</label>
                            <input type="text" class="form-control" id="meta_title" name="meta_title" placeholder="Input Meta Title"
                                   value="{{ \App\Helpers\HelperClass::get_setting('meta_title') }}" required >
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a meta title.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="meta_key" class="form-label required">Meta Keywords</label>
                            <input type="text" class="form-control" id="meta_key" name="meta_key" placeholder="Input Meta Keywords Separate with coma Ex: keyword1, Keyword2"
                                   value="{{ \App\Helpers\HelperClass::get_setting('meta_key') }}" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a meta keywords.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="meta_description" class="form-label required">Meta Description</label>
                            <textarea class="form-control" rows="3" name="meta_description" required placeholder="Input Meta Description"
                                      id="meta_description">{{ \App\Helpers\HelperClass::get_setting('meta_description') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a meta description.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary my-4 mx-2" type="submit">Save Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h4>Custom Script</h4>
            <hr>
            <form method="post" class="needs-validation" novalidate action="{{ route('web-setting.appearance-store-update') }}" >
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="header_script" class="form-label required">{{ ('Header custom script - before </head>') }}</label>
                            <textarea class="form-control" rows="5" name="header_script" required placeholder="<script>&#10;...&#10;</script>"
                                      id="header_script">{{ \App\Helpers\HelperClass::get_setting('header_script') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a header script.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="footer_script" class="form-label required">{{ ('Footer custom script - before </body>') }}</label>
                            <textarea class="form-control" rows="5" name="footer_script" required placeholder="<script>&#10;...&#10;</script>"
                                      id="footer_script">{{ \App\Helpers\HelperClass::get_setting('footer_script') }}</textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div class="invalid-feedback">
                                Please give a footer script.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary my-4 mx-2" type="submit">Save Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
        <!--<h4>SEO Configuration</h4><hr>-->
            <form method="post" class="needs-validation" action="{{route('seo.upload-sitemap')}}" novalidate enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-2">
                        <label for="course_summary_en" class="form-label required">Sitemap Configure</label>
                    </div>
                    <div class="col-md-7">
                        <div class="mb-3">
                            <div class="input-group" id="sitemap_file">
                                <input name="sitemap_file" type="file" class="form-control" required
                                       accept="text/xml">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please upload an sitemap file.
                                </div>
                            </div>

                            @error('sitemap_file')
                            <div class="error">{{ $message }}</div>
                        @enderror

                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="sitemap" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
        <!--<h4>SEO Configuration</h4><hr>-->
            <form method="post" class="needs-validation" action="{{route('seo.upload-robots')}}" novalidate enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-2">
                        <label for="course_summary_en" class="form-label required">Robots Configure</label>
                    </div>
                    <div class="col-md-7">
                        <div class="mb-3">
                            <div class="input-group" id="robot_file">
                                <input name="robot_file" type="file" class="form-control" required
                                       accept="txt">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                                <div class="invalid-feedback">
                                    Please upload an robot file.
                                </div>
                            </div>
                            @error('robot_file')
                            <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" id="sitemap" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('footer-script')

    $(document).ready(function () {

    });
@endsection
