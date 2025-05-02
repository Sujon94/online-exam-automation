/*
* Variable
* */
let timeTicker;
let answer;
/*
* Function
* */
let startTimer;
let stopTimer;
let circleColor;

$(document).on('contextmenu',function (e) {
    e.preventDefault();
})

$(document).on('copy',function (e) {
    e.preventDefault();
})

$(document).on('paste',function (e) {
    e.preventDefault();
})

circleColor = () => {
    answer = $(".answer");
    let index;
        answer.on("change", function () {
            index = $(this).data("ind");
            let answered = $(this).val();
            if (!nullEmptyUndefinedChecked(answered)) {
                $("." + index).css("background-color", "green");
                $("." + index).css("color", "white");
            } else {
                $("." + index).css("background-color", "#FFFFFF");
                $("." + index).css("color", "rgba(0, 0, 0, 0.2)");
            }
        });

        $(".answer-text-area").on("keyup", function () {
            index = $(this).data("ind");
            if (!nullEmptyUndefinedChecked($(this).val())) {
                $("." + index).css("background-color", "green");
                $("." + index).css("color", "white");
            } else {
                $("." + index).css("background-color", "#FFFFFF");
                $("." + index).css("color", "rgba(0, 0, 0, 0.2)");
            }
        })
}

timeTicker = new Timer({
    tick: 1,
    ontick: function (sec) {
        localStorage.removeItem('timerPassed');
        localStorage.setItem('timerPassed', sec);
        const date = new Date(sec);
        $("#min").html(('0' + date.getMinutes()).slice(-2));
        //$("#secnd").slideDown();
        $("#secnd").html(('0' + date.getSeconds()).slice(-2));
        //$("#secnd").fadeOut();
        $(".pulse-animation").css("border-color", `hsl(${date * 2}, 100%, 50%)`);
    },
    onend: function () {
        localStorage.removeItem('timerPassed');
        $("form[name='skill-test']").append('<input type="hidden" name="t_out" value="Y"/>');
        $("button[type='submit']").prop('disabled', true);
        $("#timerDiv").html("Time is end..");
        $("form[name=assessment-form]").submit();
    }
});

startTimer = () => {
    let localTime = localStorage.getItem('timerPassed');
    let duration = 0;
    if (!nullEmptyUndefinedChecked(localTime)) {
        duration = localTime / 1000;
    } else {
        duration = $("#timerDiv").data("time");
    }
    //duration = $("#timerDiv").data("time");

    timeTicker.start(duration);
}

stopTimer = () => {
    timeTicker.off('all');
    localStorage.removeItem('timerPassed');
    $("#min").html('00');
    $("#secnd").html('00');
    $(".timer-content").hide();
    $("#timerDiv").html("Timer..");
}

$(document).ready(function () {
    // getContents();
    startTimer();
    circleColor();
})