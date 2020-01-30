$(function () {
    var frm = $('#reset-pass-form');
    var errorBox = $('#reset-err-box');
    var successBox = $('#reset_password_success');
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
        var val, val2, errors = "";

        val = value('password');
        val2 = value('confirm_password');
        if (!val && !val2) {
            errors += "Password is missing.<br />";
        } else if (val && val.length < 6) {
            errors += 'Password must contain at least 6 characters.<br />';
        } else if (val != val2) {
            errors += 'Your passwords don\'t match.<br />';
        }

        if (!$.isEmptyObject(errors)) {
            showErrors(errors);
        } else {
            $.post(window.location.href, frm.serialize(), function (response) {
                console.log(response);
                if (response.errors) {
                    showErrors(response.errors);
                } else {
                    successBox.show();
                    $('#reset-pass').hide();
                }
            }, 'json');
        }
    });
});