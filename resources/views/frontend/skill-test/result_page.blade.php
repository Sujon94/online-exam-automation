<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-12 text-white text-center">
                <h6>{{$examName}}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
<!--                <div class="col-md-5">
                    <table class="table-responsive mt-5">
                        <tr>
                            <td>Total question: <span>{{$totalQuestion}}</span></td>
                        </tr>
                        <tr>
                            <td>Total mark: <span>{{$totalMark}}</span></td>
                        </tr>
                        <tr>
                            <td>Secured mark: <span>{{$securedMark}}</span></td>
                        </tr>
                    </table>
                </div>-->
                <div class="col-md-12 d-flex justify-content-center">
                    <div>
                        <img src="{{$emojiPath}}" class="image responsive" alt=""/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h6>
                        {{$resultMsg}}                    <a class="btn btn-sm btn-info" href="{{route('skills.test-participate',['e'=>encrypt($examId)])}}">Try again..</a>

                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
