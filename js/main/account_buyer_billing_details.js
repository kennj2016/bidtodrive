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
    $("#update_buyer_account").on("click", function () {
        errors = [];
        if ($("#buyer-form").valid(lang, conf, true)) {
            if ($('#card_name').val() && $('#card_number').val() && $('#card_cvv').val() && $('#card_month').val() && $('#card_year').val()) {
                Stripe.createToken({
                        name: $('#card_name').val(),
                        number: $('#card_number').val(),
                        cvc: $('#card_cvv').val(),
                        exp_month: $('#card_month').val(),
                        exp_year: $('#card_year').val()
                    },
                    function (status, response) {
                        if (response.error) {
                            showErrorMessage(response.error.message);
                        }
                        else {
                            $("#buyer-form").find('#stripe_id').val(response.id);
                            $.ajax({
                                type: "POST",
                                url: window.location.href,
                                data: $("#buyer-form").serialize(),
                                success: function (response) {
                                    if (response.has_error) {
                                        showErrorMessage(response.status);
                                    }
                                    else {
                                        $("#complete-update-err").html("");
                                        showSuccessMessage("Your billing details was updated successfully.");
                                        setTimeout(function(){window.location.href = "/";}, 3000);
                                    }
                                }
                            });
                        }
                    });
            }
            if ($('iao-alert').length){
                $('iao-alert').hide();
            }
            if ($('#card_number').val()  == "") {
                showErrorMessage("Credit Card Number is missing.");
            }
            if ($('#card_month').val()  == "") {
                showErrorMessage("Credit Card Month is missing.");
            }
            if ($('#card_year').val()  == "") {
                showErrorMessage("Credit Card Year is missing.");
            }
            if ($('#card_cvv').val()  == "") {
                showErrorMessage("Credit Card CVV is missing.");
            }
            if ($('#card_name').val() == "") {
                showErrorMessage("Credit Card Name is missing.");
            }
        }
    });

});
