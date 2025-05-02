/* Function
* */
/*let getContents;*/
let pushAnswer;
/*getContents = () => {
    let response = $.ajax({
        url: APP_URL + "/assessment/assessment-next-content",
        type: 'POST',
        data: {e: $("#t").val(), i: $("#i").val(), q: $("#q").val()},
        dataType: 'json',
        headers: {
            'x-csrf-token': tk
        }
    });
    response.done(function (res) {
        if (res.response_code == '1') {
            if (res.e_c == '0') {
                stopTimer();
            } else {
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
}*/



$("#finish").on('click',function () {
    swal.fire({
        text: 'Confirm Submit?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        /*showLoaderOnConfirm: true,
        preConfirm: (data) => {
            try {
                return $.ajax({
                    url: APP_URL + "/assessment/assessment-push-content",
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    headers: {
                        'x-csrf-token': tk
                    }
                }).done(res => {
                    return res;
                })
            } catch (e) {
                return Swal.showValidationMessage(`Request failed: ${e}`);
            }
        },*/
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            $(".btn-finish").prop("disabled",true);
            $("form[name=assessment-form]").submit();
        }
    })
})

$("form[name=assessment-form]").on('submit', function (e) {
    e.preventDefault();
    stopTimer();

    swal.fire({
        text: 'Paper is submitting',
        icon: 'warning',
        showConfirmButton: false,
        allowOutsideClick: false,
        didOpen: ()=>{
            swal.showLoading();
        }
    })

    let request = $.ajax({
        url: APP_URL + "/skills/push-content",
        method: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'JSON',
        headers: {
            'x-csrf-token': tk
        }
    });
    request.done(function (res) {
        swal.close();
        if (res.response_code == 1) {
            swal.fire({
                title: "Your result is generating.",
                icon: 'success',
                text: res.response_msg,
                showConfirmButton: false,
                timer: 2000,
                allowOutsideClick: false
            }).then(function () {
                localStorage.removeItem('timerPassed');
                $("#content").html(res.c);
            });
        } else {
            swal.fire({
                text: res.response_msg,
                icon: 'warning',
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 9000
            }).then(function () {
                window.location.href = res.redirect;
            })
        }
    });
    request.fail(function (xhr) {
        swal.hideLoading();
        swal.fire({
            text: xhr,
            icon: 'warning',
            showConfirmButton: false,
            allowOutsideClick: false,
            timer: 9000
        }).then(function () {
            window.location.href = res.redirect;
        })
    });
})