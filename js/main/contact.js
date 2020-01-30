$(function () {

    var wait = false;
    var wrap = $('#contact-form-wrap');
    var frm = $('#contact-form');
    var thank = $('#contact-form-thank');

    function val(name) {
        return $('[name="' + name + '"]', frm).val();
    }

    frm.submit(function (event) {
        var is_errors = false;

        event.preventDefault();

        if (wait) {
            return;
        }

        if (!val("name")) {
            is_errors = true;
            $('.block-2-name').addClass("error-c");
        }
        else if (val("name") != "") {
            is_errors = false;
            $('.block-2-name').addClass("pass");
            $('.block-2-name').removeClass("error-c");
        }
        if (!val("email")) {
            is_errors = true;
            $('.block-2-email').addClass("error-c");
        } else if (!val("email").match(/^.+\@.+\..{2,}$/)) {
            is_errors = true;
            $('.block-2-email').addClass("error-c");
        }
        else if (val("email") != "") {
            is_errors = false;
            $('.block-2-email').addClass("pass");
            $('.block-2-email').removeClass("error-c");
        }

        if (!val("message")) {
            is_errors = true;
            $('.block-1-message').addClass("error-c");
        }
        else if (val("message") != "") {
            is_errors = false;
            $('.block-1-message').addClass("pass");
            $('.block-1-message').removeClass("error-c");
        }

        if (is_errors) {
            return false;
        }
        else {
            wrap.hide();
            thank.show();
        }

        //wait = true;

        $.ajax(window.location.href, {
            type: 'post',
            dataType: 'json',
            data: frm.serialize(),
            success: function () {
                wrap.hide();
                thank.show();
            },
            complete: function () {
                wait = false;
            }
        });

    });
});