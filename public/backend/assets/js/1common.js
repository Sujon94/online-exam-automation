/**
 *This function is to add confirmation modal before form submit
 * Used Swal alert box
 * use isConfirmOnSubmit class in form name
 * Sujon Chondro Shil
 */
$(document).on('submit','.isConfirmOnSubmit', function (e) {
    e.preventDefault();
    let selector = this;
    swal.fire({
        text: 'Action Confirm?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.value == true) {
            selector.submit();
        }
    })
});

/**
 * Following function check a given value null/empty/undefined/checked.
 * Return True = given variable/array/object is null/Empty/Undefined.
 * Return False = Given variable/array/object not null/Empty/Undefined.
 * Sujon Chondro Shil
 */
function nullEmptyUndefinedChecked(value) {
    let trueCounter = 0;
    if (typeof (value) === 'undefined') {
        trueCounter++;  //null
    }

    if (value === undefined) {
        trueCounter++;  //null
    }

    if (value == null) {
        trueCounter++;  //null
    }

    if ($.trim(value) === "") {
        trueCounter++;  //null
    }

    if ($.trim(value) === '') {
        trueCounter++;  //null
    }

    if (value === 0) {
        trueCounter++;  //null
    }

    if (value === "0") {
        trueCounter++;  //null
    }

    /*
    * True = given variable/array/object is null/Empty/Undefined.
    * False = Given variable/array/object not null/Empty/Undefined.
    */
    return trueCounter > 0;
}

function getSlag(title, slugFor, callback) {
    let response = $.ajax({
        url: APP_URL + '/backend/ajax/get-slug/' + title,
        dataType: 'json',
        data: {slugFor},
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    });

    response.done(function (d) {
        callback(d);
    });

    response.fail(function (d) {
        console.log(d);
    });
}