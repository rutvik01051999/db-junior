function VerifyMobile() {
    if ($("#mobileno").val() == '') {
        $("#mobileno").css("border-color", "red");
        alert("Please enter mobileno");
        $("#mobileno").focus();
        $('#centermodal').modal('hide');
    } else {
        if ($("#mobileno").val().length == 10) {
            $("#mobileno").css("border-color", "");
            ResendCode();

        } else {
            $("#mobileno").css("border-color", "red");
            alert("Please enter a valid mobile number");
            $("#mobileno").focus();
        }
    }
}

function ResendCode() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    });
    $.ajax({

        type: "POST",
        url: "/certificate/download",
        data: {
            mobile: $('#mobileno').val()
        },
        success: function (response) {
            $response_data = $.parseJSON(response);
            if ($response_data.status == '1') {
                $('#centermodal').modal('show');
                $($("#span_mobile").html($("#mobileno").val()));
                $("#otp").val($response_data.data);
                $("#resendCode").attr("disabled", true);
                var sec = 60,
                    countDiv = document.getElementById("counter"),
                    countDown = setInterval(function () {
                        'use strict';
                        secpass();
                    }, 1000);

                function secpass() {
                    'use strict';
                    var min = Math.floor(sec / 60),
                        remSec = sec % 60;
                    if (remSec < 10) {
                        remSec = '0' + remSec;
                    }
                    if (min < 10) {
                        min = '0' + min;
                    }
                    countDiv.innerHTML = min + ":" + remSec;
                    if (sec > 0) {
                        sec = sec - 1;
                    } else {
                        clearInterval(countDown);
                        countDiv.innerHTML = '00:00';
                    }
                    if (countDiv.innerHTML === '00:00') {
                        $("#resendCode").attr("disabled", false);
                    }
                }
            } else if ($response_data.status == '0') {
                alert($response_data.message);
                $("#mobileno").focus();
            }
        }
    });
}

function restrictAlphabets(e) {
    var x = e.which || e.keycode;
    if ((x >= 48 && x <= 57) || x == 8 || (x >= 35 && x <= 40) || x == 46)
        return true;
    else
        return false;
}