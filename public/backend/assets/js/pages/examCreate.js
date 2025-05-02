let examType = $("#examType");
let subjects = $("#subject");
const PROFESSIONAL = 1;
const SKILL_TEST = 2;

examType.on('change', function () {
    if ($(this).val() == PROFESSIONAL){
        $($.find('label[for=examDate]')).addClass("required");
        $("#examDate").attr('required',true);

        $($.find('label[for=price]')).addClass("required");
        $("#price").attr('required',true);

    }else{
        $($.find('label[for=examDate]')).removeClass("required");
        $("#examDate").removeAttr('required');

        $($.find('label[for=price]')).removeClass("required");
        $("#price").removeAttr('required');
    }
});

subjects.select2({
    placeholder:"Select Subject"
});


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