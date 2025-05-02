let studentTable;

$('#exam').on('change', function () {
    //if (!nullEmptyUndefinedChecked($(this).val())) {
        studentTable.draw();
    //}
})
studentTable = $("#studentTable").DataTable({
    processing: true,
    serverSide: true,
    searching: true,
    ajax: {
        url: APP_URL + '/backend/ajax/exam-participants',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: function (d) {
            d.exam = $("#exam :selected").val()
        }
    },
    columns: [
        {"data": "DT_RowIndex", "name": "DT_RowIndex"},
        {"data": "student_name"},
        {"data": "course"},
        {"data": "batch"},
        {"data": "action", "class": "text-center"}
    ]
});


$(document).ready(function () {

    /* $(document).on('change', '.updateStatus', function () {
         let obj = $(this);
         let examId = obj.data('e');
         let status = obj.find(':selected').val();

         swal.fire({
             text: 'Change Status Confirm?',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes',
             cancelButtonText: 'No'
         }).then((result) => {
             if (result.value == true) {
                 let request = $.ajax({
                     url: '{{route('exam.status - update')}}',
                     data: {examId, status}
                 });

                 request.done(function (res) {
                     if (res.response_code == '1') {
                         Swal.fire({
                             icon: 'success',
                             text: res.response_msg,
                             showConfirmButton: false,
                             timer: 2000,
                             allowOutsideClick: false
                         });
                         examTable.draw();
                     } else {
                         Swal.fire({text: res.response_msg, icon: 'info'});
                         obj.val(obj.data('d'));
                     }
                 });

                 request.fail(function (jqXHR, textStatus) {
                     console.log(jqXHR);
                 });
             } else {
                 obj.val(obj.data('d'));
             }
         })
     })*/
})
