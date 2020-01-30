$(function () {

    var errors = [];
    var conf = {
        onElementValidate: function (valid, $el, $form, errorMess) {
            if (!valid) {
                errors.push({el: $el, error: errorMess});
            }
        }
    };
    var lang = {};
    $("#update_notification_settings").on("click", function () {
        errors = [];
        if ($("#notification-form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#notification-form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    }
                    else {
                        $("#complete-update-err").html("");
                        showSuccessMessage("Your notification settings was updated successfully.");
                        setTimeout(function(){location.reload()}, 3000);
                    }
                }
            });
        }
    });
    
});
