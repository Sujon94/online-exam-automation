let course = $("#course");
course.select2();

course.on('change', function () {
    let course = $("#course :selected").val();
    $("#batch").html('');
    if (course != "") {
        let request = $.ajax({
            url: APP_URL + "/backend/ajax/batch-with-students",
            type: "get",
            data:{course}
        });

        request.done(function (res) {
            if (!$.isEmptyObject(res)) {
                $('#batch').html("<option value='" + res.batch_id + "'>" + res.batch_name_en + "</option>");
            }
        });

        request.fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
        });
    }

});

function checkAll(check) {
    var id = check.id;
    if (check.checked) {
        $('input:checkbox[id^="' + id + '"]').each(function () {
            $('input:checkbox[id^="' + id + '"]').prop("checked", true);
        });

    } else {
        $('input:checkbox[id^="' + id + '"]').each(function () {
            $('input:checkbox[id^="' + id + '"]').prop("checked", false);
        });

    }
}

function checkIndividual(check, i) {
    if (check.checked) {

    } else {


    }
    getElectricityReader(".meterReader", '/electricity/ajax/substationReader', '/electricity/ajax/employee-details/', null);
}