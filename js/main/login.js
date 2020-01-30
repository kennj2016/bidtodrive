$(function () {
    var frm = $('#login-form');
    var boxs = $('#login_error');
    var wait = false;

    function value(name) {
        return $('[name="' + name + '"]', frm).val();
    }

    function showErrors(errors) {
        boxs.html(errors).show();
    }

    frm.submit(function (e) {
        e.preventDefault();
        if (wait) return false;
        var val, errors = "";

        if (!$.isEmptyObject(errors)) {
            showErrors(errors);
        } else {
            boxs.html('').hide();
            wait = true;
            var redirectUrl = location.host;
            $.ajax(window.location.href, {
                type: 'post',
                dataType: 'json',
                data: frm.serialize(),
                success: function (response) {
                    if (response.message != "") {                        
                        if(response.message.indexOf("Email is missing.") != -1 || response.message.indexOf("Invalid Email format.") != -1){
                            $("input[name=username]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=username]").css("border-color", "#ffffff");
                        }
                        
                        if(response.message.indexOf("Password is missing.") != -1){
                            $("input[name=password]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=password]").css("border-color", "#ffffff");
                        }
                        
                        showErrors(response.message);
                    } else {
                        document.location.href = response.redirect;
                    }
                },
                complete: function () {
                    wait = false;
                }
            });
        }
    });
});