<div class="card">
    <div class="card-body">
        <input type="hidden" name="ex" id="e" value="{{$examId}}"/>
        @foreach($questions as $key=>$q)
            <h5 class="card-title">Q: {!! $q->question !!}. (Mark: {{$q->question_mark}})</h5>
            <p class="card-text"><b>Given Answer:</b> {{$q->answer}}</p>
            <input type="hidden" name="q[{{$q->exam_result_id}}][id]" value="{{$q->exam_result_id}}">
            <div>
                <b>Mark Achieved:</b>
                <input required type="number" name="q[{{$q->exam_result_id}}][mark]" value="{{$q->result_mark}}">
            </div>
            <hr>
        @endforeach
        <input type="hidden" name="trans" id="t" value="{{$transId}}"/>
    </div>
</div>