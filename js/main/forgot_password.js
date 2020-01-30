$(function () {
    var frm = $('#forgot-pass-form');
    var errorBox = $('#forgot-err-box');
    var successBox = $('#forgot_password_success');
    var wait = false;

    function value(name) {
        return $('[name="' + name + '"]', frm).val();
    }

    function showErrors(errors) {
        errorBox.html(errors).show();
    }

    frm.submit(function (e) {
        e.preventDefault();
        if (wait) return false;
        var val, errors = "";

        val = value('forgot_email');
        if (!val) {
            //$('.block-1-email').addClass("error-c");
            $('.block-1-email').removeClass("pass");
            errors += "Email is missing.<br />";
        } else if (!val.match(/^.+\@.+\..{2,}$/)) {
            //$('.block-1-email').addClass("error-c");
            $('.block-1-email').removeClass("pass");
            errors += 'Invalid Email format.<br />';
        }

        if (!$.isEmptyObject(errors)) {
            showErrors(errors);
        } else {
            $.post("/forgot-password/", frm.serialize(), function (response) {
                console.log(response.errors);
                if (response.errors) {
                    showErrors(response.errors);
                } else {
                    successBox.show();
                    $('#forgot-pass').hide();
                }
            }, 'json');
        }
    });
});