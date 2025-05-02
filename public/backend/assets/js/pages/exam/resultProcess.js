let examTable;

$('#eStatus').on('change', function () {
    //if (!nullEmptyUndefinedChecked($(this).val())) {
    examTable.draw();
    //}
});
examTable = $("#examTable").DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
        url: APP_URL + '/backend/ajax/exam-result',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: function (d) {
            d.status = $("#eStatus :selected").val();
        }
    },
    columns: [
        {"data": "DT_RowIndex", "name": "DT_RowIndex"},
        {"data": "exam_name"},
        {"data": "exam_type"},
        {"data": "exam_date"},
        {"data": "questions", "class": "text-center"},
        {"data": "multiple_choice", "class": "text-center"},
        {"data": "image", "class": "text-center"},
        {"data": "written", "class": "text-center"},
        {"data": "participants", "class": "text-center"},
        {"data": "action"}
    ]
});

function publish(selector, eid) {
    swal.fire({
        text: 'Confirm Publish?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        showLoaderOnConfirm: true,
        preConfirm: (data) => {
            return $.ajax({
                url: APP_URL+'/backend/publish-result',
                type:'POST',
                data: {exam: eid},
                dataType: 'JSON',
                headers: {
                    'x-csrf-token': tk
                }
            }).done(res => {
                return res;
            }).catch(error => {
                swal.showValidationMessage(`Request Failed: ${error}`)
            })
        },
        allowOutsideClick: () => !swal.isLoading()
    }).then((result) => {
        if (nullEmptyUndefinedChecked(result.dismiss)) {
            if (result.value.response_code == 1) {
                Swal.fire({
                    icon: 'success',
                    text: result.value.response_msg,
                    showConfirmButton: false,
                    timer: 2000,
                    allowOutsideClick: false
                }).then(function () {
                    examTable.draw();
                });
            } else {
                swal.fire({
                    text: result.value.response_msg,
                    icon: 'warning',
                })
            }
        }
    })
}
