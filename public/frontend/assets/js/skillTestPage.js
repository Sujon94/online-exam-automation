/*
* Variable
* */
let timeTicker;
/*
* Function
* */
let getContents;
let pushAnswer;
let startTimer;
let stopTimer;


getContents = () => {
    let response = $.ajax({
        url: APP_URL + "/skills/next-content",
        type: 'POST',
        data: {e: $("#t").val(), i: $("#i").val(), q: $("#q").val()},
        dataType: 'json',
        headers: {
            'x-csrf-token': tk
        }
    });
    response.done(function (res) {
        if (res.response_code == '1') {
            if (res.e_c == '0'){
                stopTimer();
            }else{
                startTimer();
            }
            $("#content").html(res.c);
        } else {
            Swal.fire({text: res.response_msg, icon: 'error'});
        }
    });

    response.fail(function (xhqr, text) {
        Swal.fire({text: xhqr, icon: 'error'});
    });
}

pushAnswer = () => {
    let response = $.ajax({
        url: APP_URL + "/skills/push-content",
        type: 'POST',
        data: {e: $("#t").val(), i: $("#i").val(), v: $('input[name="answer"]:checked').val(), q: $("#q").val()},
        headers: {
            'x-csrf-token': tk
        }
    });
    response.done(function (res) {
        if (res.response_code == '1') {
            if (res.f == '1'){
                $("#content").html(res.c);
            }else{
                getContents();
            }
        } else {
            Swal.fire({text: res.response_msg, icon: 'error'});
        }
    });

    response.fail(function (xhqr, text) {
        Swal.fire({text: xhqr, icon: 'error'});
    });
}

$("form[name='skill-test']").on('submit', function (e) {
    e.preventDefault();
    let answer = $('input[name="answer"]:checked').val();
    if (nullEmptyUndefinedChecked($("input[name='t_out']").val())){
        if (nullEmptyUndefinedChecked(answer)){
            $(".answer").notify("Answer is empty.");
        }else{
            pushAnswer();
        }
    }else{
        pushAnswer();
    }
})

timeTicker = new Timer({
    tick: 1,
    ontick: function (sec) {
        localStorage.removeItem('testTimerPassed');
        localStorage.setItem('testTimerPassed', sec);
        const date = new Date(sec);
        $("#min").html(('0' + date.getMinutes()).slice(-2));
        //$("#secnd").slideDown();
        $("#secnd").html(('0' + date.getSeconds()).slice(-2));
        //$("#secnd").fadeOut();
    },
    onend: function () {
        localStorage.removeItem('testTimerPassed');
        $("form[name='skill-test']").append('<input type="hidden" name="t_out" value="Y"/>');
        $("button[type='submit']").prop('disabled',true);
        $("#timerDiv").html("Time is end..");
        $("form[name='skill-test']").submit();
    }
});

startTimer = () => {
    let localTime = localStorage.getItem('testTimerPassed');
    let duration = 0;
    if (!nullEmptyUndefinedChecked(localTime)) {
        duration = localTime / 1000;
    } else {
        duration = $("#timerDiv").data("time");
        //duration *= 60;
        //duration += 60;
    }
    timeTicker.start(duration);
}

stopTimer = () => {
    timeTicker.off('all');
    localStorage.removeItem('testTimerPassed');
    $("#min").html('00');
    $("#secnd").html('00');
    $(".timer-content").hide();
    $("#timerDiv").html("Timer..");
}

$(document).ready(function () {
    getContents();
})