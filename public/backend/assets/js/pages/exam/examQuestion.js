let updateExamQuestions;
let updateCheckBox;

$(".question").on("change", function () {
    let dataArray = $(this).data('question').split('#');
    let exam = dataArray[0];
    let sub = dataArray[1];
    let ques = dataArray[2];

    if ($(this).is(":checked")) {
        updateExamQuestions($(this), exam, sub, ques, 'a', updateCheckBox);
    } else {
        updateExamQuestions($(this), exam, sub, ques, 'u', updateCheckBox);
    }
});
updateCheckBox = (selector,examId, subId, status, res) => {
    if (res.response_code != '1') {
        if (status == 'a') {
            selector.prop("checked", false);
        } else {
            selector.prop("checked", true);
        }
        $.notify(res.response_msg,'error');
    } else {
        $("#"+examId+"q"+subId).html(res.extra_data.subTotalQuestion);
        $("#"+examId+"m"+subId).html(res.extra_data.subTotalMark);

        $("#"+examId+"tq").html(res.extra_data.totalQuestion);
        $("#"+examId+"tm").html(res.extra_data.totalMark);

        $.notify(res.response_msg,'success');
    }
};

updateExamQuestions = (selector, examId, subId, questionId, status, callback) => {
    let response = $.ajax({
        url: APP_URL + "/backend/question-tag",
        type: 'POST',
        data: {exam: examId, subject: subId, question: questionId, status},
        headers: {
            'x-csrf-token': tk
        }
    });
    response.done(function (res) {
        return callback(selector,examId, subId, status, res);
    });

    response.fail(function (xhqr, t) {
        return $.notify(xhqr, 'error');
    })
}