let examType = $("#examType");
let subjects = $("#subject");
const PROFESSIONAL = 1;
const SKILL_TEST = 2;
const EVENT = 3;
const YES = 'Y';
const NO = 'N';

let course = $("#course");
course.select2();

$(document).ready(function () {
    $("#examType").trigger('change');
});

examType.on('change', function () {
    if ($(this).find(":selected").data('presetdate') === YES) {
        $(".examDateArea").show(1000);
        $($.find('label[for=examDate]')).addClass("required");
        $("#examDate").attr('required', true);
    } else {
        $(".examDateArea").hide(1000);
        $($.find('label[for=examDate]')).removeClass("required");
        $("#examDate").removeAttr('required');
    }

    if ($(this).find(":selected").data('payment') === YES) {
        $(".priceArea").show(1000);
        $($.find('label[for=price]')).addClass("required");
        $("#price").attr('required', true);
    } else {
        $(".priceArea").hide(1000);
        $($.find('label[for=price]')).removeClass("required");
        $("#price").attr('required', false);
    }

    if ($(this).find(":selected").data('course') === YES) {
        $(".courseArea").show(1000);
        $($.find('label[for=course]')).addClass("required");
        course.attr('required', true);
    } else {
        $(".courseArea").hide(1000);
        $($.find('label[for=course]')).removeClass("required");
        course.removeAttr('required');
        resetField(["#course"]);
    }

    if ($(this).find(":selected").data('event') === YES || $(this).find(":selected").data('thumbnail') === YES) {
        $(".eventImage").show(1000);
        $($.find('label[for=event_image]')).addClass("required");
        if ($("#event_image").data('preset') == 'N') {
            $("#event_image").attr('required', true);
        }
    } else {
        $(".eventImage").hide(1000);
        $($.find('label[for=event_image]')).removeClass("required");
        $("#event_image").attr('required', false);
    }

    if ($(this).find(":selected").data('thumbnail') === YES) {
        $($.find('label[for=event_image]')).html("Thumbnail Image (Allowed dimension: 250x200)");
    } else {
        $($.find('label[for=event_image]')).html("Event Detail Image (Allowed dimension: width:400; height:600)");
    }

    if ($("#certAllowChecked").is(":checked")) {
        $(".certificate").show(1000);
        $($.find('label[for=cert_image]')).addClass("required");
        if ($("#cert_image").data('preset') == 'N') {
            $("#cert_image").attr('required', true);
        }
    } else {
        $(".certificate").hide(1000);
        $($.find('label[for=cert_image]')).removeClass("required");
        $("#cert_image").attr('required', false);
    }
});

$("#certAllowChecked").on('click', function () {
    if ($(this).is(":checked")) {
        $(".certificate").show(1000);
        $($.find('label[for=cert_image]')).addClass("required");
        if ($("#cert_image").data('preset') == 'N') {
            $("#cert_image").attr('required', true);
        }
    } else {
        $(".certificate").hide(1000);
        $($.find('label[for=cert_image]')).removeClass("required");
        $("#cert_image").attr('required', false);
    }
})

subjects.select2({
    placeholder: "Select Subject"
});


function calculateTime() {
    let startTimeObj = $("#exam_start_time");
    let endTimeObj = $("#exam_end_time");

    if (!nullEmptyUndefinedChecked(startTimeObj.val())) {
        if (!nullEmptyUndefinedChecked(endTimeObj.val())) {
            let startTime = moment(startTimeObj.val(), 'HH:mm:ss a');
            let endTime = moment(endTimeObj.val(), 'HH:mm:ss a');
            if (startTime > endTime) {
                startTimeObj.notify('Start time can\'t be greater then end time.');
                resetField(["#exam_start_time","#exam_end_time"]);
                $("#duration").html("");
            } else {
                let duration = moment.duration(endTime.diff(startTime));
                $("#duration").html("(" + parseInt(duration.asHours()) + " Hours " + parseInt(duration.asMinutes()) % 60 + " Minutes)");
            }
        }
    } else {
        resetField(["#exam_end_time"]);
        startTimeObj.notify('Start time mention first.');
        $("#duration").html("");
    }
}


ClassicEditor
    .create(document.querySelector('#instruction'))
    .catch(error => {
        console.error(error);
    });

$("#certProcess").on('click', function () {
    certificatePreview();
});

const fileInput = document.getElementById('cert_image');
const previewButton = document.getElementById('certPreview');

function certificatePreview() {

    const file = fileInput.files[0];
    if (!nullEmptyUndefinedChecked(file)) {

        let form = new FormData();
        form.append('cert_image', file);
        form.append('exam_type', $("#examType :selected").val());
        form.append('exam', $("#exam").val());
        form.append('exam_date', $("#exam_date").val());
        form.append('course', $("#course :selected").text());

        let request = $.ajax({
            url: APP_URL + '/backend/ajax/cert-preview-process',
            method: 'POST',
            processData: false,
            contentType: false,
            dataType: 'JSON',
            headers: {
                'x-csrf-token': tk
            },
            data: form
        });

        request.done(function (res) {
            if (res.response_code != "99") {
                $("#certPreview").removeClass("d-none");
                $("#certPreview").attr('href', res.response_url);
                Swal.fire({text: res.response_msg, icon: 'success'});
            } else {
                Swal.fire({text: res.response_msg, icon: 'error'});
            }
        });

        request.fail(function (jqXHR, textStatus) {
            Swal.fire({text: jqXHR, icon: 'error'});
        });
    }else{
        Swal.fire({text: 'No file found to process.', icon: 'error'});
    }
}

submit();

function submit() {
    $("form[name=examForm]").submit(function (e) {
        e.preventDefault();

        swal.fire({
            text: 'Confirm Submit?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.value == true) {
                let request = $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    header: {'x-csrf-token': tk},
                    data: new FormData($(this)[0])
                });

                request.done(function (res) {
                    if (res.response_code != "99") {
                        Swal.fire({
                            icon: 'success',
                            text: res.response_msg,
                            showConfirmButton: false,
                            timer: 2000,
                            allowOutsideClick: false
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        Swal.fire({text: res.response_msg, icon: 'error'});
                    }
                });

                request.fail(function (jqXHR, textStatus) {
                    Swal.fire({text: jqXHR, icon: 'error'});
                });
            }
        })
    })
}