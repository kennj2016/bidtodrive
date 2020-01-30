$(function () {
    $('.date_mask').mask("99.99.9999", {
        insertMode: false,
        showMaskOnHover: true,
        placeholder: "mm.dd.yyyy"
    });

    $('.phone_mask').mask("(999) 999-9999", {
        insertMode: false,
        showMaskOnHover: true
    });
    
    $(".buyer-dealer-name").hide();

    $("#seller-tab-btn").click(function () {
        $("#seller-tab").show();
        $("#buyer-tab").hide();
        $("#seller-tab-btn").addClass("active");
        $("#buyer-tab-btn").removeClass("active");
        $("#seller-individual-tab").hide();
        $("#credit-card-information-tab").hide();
    });

    $("#buyer-tab-btn").click(function () {
        $("#seller-tab").hide();
        $("#seller-tab-2").hide();
        $("#seller-individual-tab").hide();
        $("#credit-card-information-tab").hide();
        $("#buyer-tab").show();
        $("#seller-tab-btn").removeClass("active");
        $("#buyer-tab-btn").addClass("active");
    });

    $("#buyer-dealer-btn").click(function () {
        $('#chk13').attr('checked', false);
        $('#chk14').attr('checked', true);
        $(".buyer-individual-name").hide();
        $(".buyer-dealer-name").show();
    });

    $("#buyer-individual-btn").click(function () {
        $('#chk13').attr('checked', true);
        $('#chk14').attr('checked', false);
        $(".buyer-individual-name").show();
        $(".buyer-dealer-name").hide();
    });
    
    $(".block-2-dealer").click(function () {
        $(".block-2-dealer").addClass("dealer-custom");
    });
    
    $(".block-2-individual").click(function () {
        $(".block-2-dealer").removeClass("dealer-custom");
    });
    
    

    var errors = [];
    var conf = {
        onElementValidate: function (valid, $el, $form, errorMess) {
            if (!valid) {
                errors.push({el: $el, error: errorMess});
            }
        }
    };
    var lang = {};

    var sellerRegistrationSuccess = $("#seller-ragistration-form-thank").text();
    var buyerRegistrationSuccess = $("#buyer-ragistration-form-thank").text();

    // SELLER TAB #1
    $("#seller-tab-2-btn").on("click", function () {
        errors = [];
        if ($("#seller-registration-form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/register/",
                data: $("#seller-registration-form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        if(response.status.indexOf("Email is missing.") != -1 || response.status.indexOf("Invalid Email format.") != -1){
                            $("input[name=seller_email]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=seller_email]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Name is missing.") != -1){
                            $("input[name=seller_name]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=seller_name]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Contact Name is missing.") != -1){
                            $("input[name=seller_name]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=seller_name]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Zip Code is missing.") != -1){
                            $("input[name=zip]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=zip]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Password is missing.") != -1 || response.status.indexOf("Password must include at least one letter.") != -1 || response.status.indexOf("Password must contain at least 8 characters.") != -1){
                            $("input[name=seller_password]").css("border-color", "#ff0000");
                        }else{
                             $("input[name=seller_password]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Your passwords don't match.") != -1){
                            $("input[name=seller_verify_password]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=seller_verify_password]").css("border-color", "#ffffff");
                        }
                        
                        $("#seller-registration-form-err-msg").show();
                        $("#seller-registration-form-err-msg").html(response.status);
                    }
                    else {
                        $("#seller-registration-form-err-msg").hide();
                        $("#seller-registration-form-err-msg").html("");
                        $("#seller-tab").hide();
                        $("#seller-tab-2").show();
                        $("#seller-dealer-tab").show();
                    }
                }
            });
        }
    });
    // SELLER TAB #2
    $(document).on("click", "#seller-registration-form-submit", function () {
        errors = [];
        if ($("#veifying-type").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/register/",
                data: $("#veifying-type").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#veifying-type-form-err-msg").html(response.status);
                        
                        if(response.status.indexOf("Dealers License Issued To is missing.") != -1){
                            $("input[name=dealers_license_issued_to]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_issued_to]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License State is missing.") != -1){
                            $(".block-1 .selectize-control .selectize-input").css("border-color", "#ff0000");
                        }else{
                            $(".block-1 .selectize-control .selectize-input").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License Number is missing.") != -1){
                            $("input[name=dealers_license_number]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_number]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers Issue Date is missing.") != -1 || response.status.indexOf("'Dealers Issue Date' invalid date format.") != -1){
                            $("input[name=dealers_license_issue_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_issue_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers Expiration Date is missing.") != -1 || response.status.indexOf("'Dealers Expiration Date' invalid date format.") != -1 || response.status.indexOf("Dealers Expiration Date must be in the future.") != -1){
                            $("input[name=dealers_license_expiration_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_expiration_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License is missing.") != -1){
                            $(".module-uploader .fileUploadSeller").css("border", "1px solid #ff0000");
                        }else{
                            $(".module-uploader .fileUploadSeller").css("border-color", "1px solid #000000");
                        }
                        
                        if(response.status.indexOf("You must agree to the terms & conditions in order to complete registration.") != -1){
                            $(".check-label-agree").addClass("terms-err");
                        }else{
                            $(".check-label-agree").removeClass("terms-err");
                        }
                    }
                    else {
                        $("#veifying-type-form-err-msg").html("");
                        $("#registration-wrap").hide();
                        $("#seller-ragistration-form-thank").show();
                    }
                }
            });
        }
    });

    // BUYER TAB #1
    $("#buyer-tab-2-btn").on("click", function () {
        errors = [];
        if ($("#buyer-registration-form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/register/",
                data: $("#buyer-registration-form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#buyer-registration-form-err-msg").show();
                        $("#buyer-registration-form-err-msg").html(response.status);
                        
                        if(response.status.indexOf("Email is missing.") != -1 || response.status.indexOf("Invalid Email format.") != -1){
                            $("input[name=buyer_email]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=buyer_email]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealership Name is missing.") != -1){
                            $("input[name=company_name]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=company_name]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Name is missing.") != -1){
                            $("input[name=buyer_name]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=buyer_name]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Zip Code is missing.") != -1){
                            $("input[name=zip]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=zip]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Password is missing.") != -1 || response.status.indexOf("Password must include at least one letter.") != -1 || response.status.indexOf("Password must contain at least 8 characters.") != -1){
                            $("input[name=buyer_password]").css("border-color", "#ff0000");
                        }else{
                             $("input[name=buyer_password]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Your passwords don't match.") != -1){
                            $("input[name=buyer_verify_password]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=buyer_verify_password]").css("border-color", "#ffffff");
                        }
                    }
                    else {
                        $("#buyer-registration-form-err-msg").hide();
                        $("#buyer-registration-form-err-msg").html("");
                        $("#buyer-tab").hide();
                        $("#buyer-tab-2").show();
                        if (response.buyer_type_value == "individual"){
                            $("#buyer-individual-tab").show();
                            $("#buyer-dealer-tab").hide();
                        } else {
                            $("#buyer-individual-tab").hide();
                            $("#buyer-dealer-tab").show();
                        }
                    }
                }
            });
        }
    });

    // BUYER TAB #2
    $(document).on("click", "#credit-card-information-btn", function () {
        errors = [];
        if ($("#veifying-type-buyer").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/register/",
                data: $("#veifying-type-buyer").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#veifying-type-form-err-msg-buyer").show();
                        $("#veifying-type-form-err-msg-buyer").html(response.status);
                        
                        // buyer individual errors
                        if(response.status.indexOf("State is missing.") != -1){
                            $(".block-1-individual-state .selectize-control .selectize-input").css("border-color", "#ff0000");
                        }else{
                            $(".block-1-individual-state .selectize-control .selectize-input").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("DL number is missing.") != -1){
                            $("input[name=individual_dl_number]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=individual_dl_number]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Date Of Birth is missing.") != -1 || response.status.indexOf("'Date Of Birth' invalid date format.") != -1){
                            $("input[name=individual_date_of_birth]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=individual_date_of_birth]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Issue Date is missing.") != -1 || response.status.indexOf("'Issue Date' invalid date format.") != -1 || response.status.indexOf("Issue Date must be in the past.") != -1){
                            $("input[name=individual_issure_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=individual_issure_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Expiration Date is missing.") != -1 || response.status.indexOf("'Expiration Date' invalid date format.") != -1 || response.status.indexOf("Expiration Date must be in the future.") != -1){
                            $("input[name=individual_expiration_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=individual_expiration_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Drivers License is missing.") != -1){
                            $(".module-uploader .fileUploadIndividual").css("border", "1px solid #ff0000");
                        }else{
                            $(".module-uploader .fileUploadIndividual").css("border-color", "1px solid #000000");
                        }
                        
                        // buyer dealer errors
                        if(response.status.indexOf("Dealers License Issued To is missing.") != -1){
                            $("input[name=dealers_license_issued_to]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_issued_to]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License State is missing.") != -1){
                            $(".block-1-dealers-state .selectize-control .selectize-input").css("border-color", "#ff0000");
                        }else{
                            $(".block-1-dealers-state .selectize-control .selectize-input").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License Number is missing.") != -1){
                            $("input[name=dealers_license_number]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_number]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers Issue Date is missing.") != -1 || response.status.indexOf("'Dealers Issue Date' invalid date format.") != -1 || response.status.indexOf("Issue Date must be in the past.") != -1){
                            $("input[name=dealers_license_issue_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_issue_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers Expiration Date is missing.") != -1 || response.status.indexOf("'Dealers Expiration Date' invalid date format.") != -1 || response.status.indexOf("Dealers Expiration Date must be in the future.") != -1){
                            $("input[name=dealers_license_expiration_date]").css("border-color", "#ff0000");
                        }else{
                            $("input[name=dealers_license_expiration_date]").css("border-color", "#ffffff");
                        }
                        
                        if(response.status.indexOf("Dealers License is missing.") != -1){
                            $(".module-uploader .fileUploadDealer").css("border", "1px solid #ff0000");
                        }else{
                            $(".module-uploader .fileUploadDealer").css("border-color", "1px solid #000000");
                        }
                        
                    }
                    else {
                        $("#veifying-type-form-err-msg-buyer").hide();
                        $("#veifying-type-form-err-msg-buyer").html("");
                        $("#veifying-type-buyer").hide();
                        $("#credit-card-information-tab").show();
                    }
                }
            });
        }
    });

    // BUYER TAB #3
    $("#complete-registration, #complete-registration-2").on("click", function () {
        errors = [];
        if ($("#credit-card-information-tab").valid(lang, conf, true)) {
            if ($('[name="card_name"]').val() && $('[name="card_number"]').val() && $('[name="card_cvv"]').val()) {
                Stripe.createToken({
                        name: $('[name="card_name"]').val(),
                        number: $('[name="card_number"]').val(),
                        cvc: $('[name="card_cvv"]').val(),
                        exp_month: $('[name="card_month"]').val(),
                        exp_year: $('[name="card_year"]').val()
                    },
                    function (status, response) {
                        if (response.error) {
                            alert(response.error.message);
                        }
                        else {
                            $("#credit-card-information-tab").find('[name="stripe_id"]').val(response.id);
                            $.ajax({
                                type: "POST",
                                url: "/register/",
                                data: $("#credit-card-information-tab").serialize(),
                                success: function (response) {
                                    if (response.has_error) {
                                        $("#complete-registration-err").show(); 
                                        $("#complete-registration-err").html(response.status); 
                                    }
                                    else {
                                        $("#complete-registration-err").hide(); 
                                        $("#complete-registration-err").html("");
                                        $("#registration-wrap").hide();
                                        $("#credit-card-information-tab").show();
                                        $("#buyer-ragistration-form-thank").show();
                                    }
                                }
                            });
                        }
                    });
            } else {
                $.ajax({
                    type: "POST",
                    url: "/register/",
                    data: $("#credit-card-information-tab").serialize(),
                    success: function (response) {
                        if (response.has_error) {
                            $("#complete-registration-err").show(); 
                            $("#complete-registration-err").html(response.status);
                            
                            if(response.status.indexOf("You must agree to the terms & conditions in order to complete registration.") != -1){
                                $(".check-label-agree").addClass("terms-err");
                            }else{
                                $(".check-label-agree").removeClass("terms-err");
                            }
                        }
                        else {
                            $("#complete-registration-err").hide(); 
                            $("#complete-registration-err").html("");
                            $("#registration-wrap").hide();
                            $("#credit-card-information-tab").show();
                            $("#buyer-ragistration-form-thank").show();
                        }
                    }
                });
            }

        }
    });

    fileUploader();

    function fileUploader() {

        var init = $('.module-uploader .uploadFile');
        $(document).on('change', '.module-uploader .uploadFile', function () {
            var $this = $(this);
            var moduleWrapper = $(this).closest('.module-uploader');
            var parent = $(this).parent().parent().parent(), //$(this).closest('.module-uploader')
                files = parent.find(".files"),
                error = parent.find(".fileUploadError"),
                progressTemplate = parent.find(".fileUploadProgressTemplate"),
                uploadTemplate = parent.find(".fileUploadItemTemplate");
            var formData = new FormData();

            $.each($this[0].files, function (i, file) {
                formData.append('file', file);
            });


            formData.append("action", "profile_photo");
            var oldInput = parent.find(".uploadFile");
            var newInput = document.createElement("input");
            newInput.type = "file";
            newInput.id = oldInput.id;
            newInput.name = oldInput.name;
            newInput.className = 'uploadFile';
            // copy any other relevant attributes
            var inputParent = oldInput.parent();
            oldInput.parent().find(oldInput).remove();
            inputParent.append(newInput);
            // oldInput.parentNode.replaceChild(newInput, oldInput);
            files.append(progressTemplate.tmpl());
            error.addClass("hide");


            $("#buyer-registration-form-submit").attr("id", "buyer-registration-form-submit-deny");
            $("#credit-card-information-btn").attr("id", "credit-card-information-btn-deny");
            var fileNameHolder = moduleWrapper.find(".list-group-item .holder .name span");
            if (fileNameHolder.length) {
                fileNameHolder.text("Uploading...").css("color", "white");
            } else {
                var fileNameBlock = "<div class='list-group-item'><div class='holder'><div class='name'><span style='color: white;'>Uploading...</span></div></div><div>";
                moduleWrapper.find(".list-group.files").html(fileNameBlock);
            }
            denyLeave("dealers license");
            $.ajax({
                url: '/register/',
                type: 'POST',
                data: formData,
                dataType: 'json',
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();
                    /*  if (xhr.upload) {
                          xhr.upload.addEventListener('progress', function(evt) {
                              var percent = (evt.loaded / evt.total) * 100;
                              files.find(".progress-bar").width(percent + "%");
                          }, false);
                      }*/
                    return xhr;
                },
                success: function (response) {
                    files.html("");
                    $("#buyer-registration-form-submit-deny").attr("id", "buyer-registration-form-submit");
                    $("#credit-card-information-btn-deny").attr("id", "credit-card-information-btn");
                    allowLeave();
                    if (response.error) {
                        alert(response.status);
                    } else {
                        files.children().last().remove();
                        files.append(uploadTemplate.tmpl(response));
                    }
                    // init.closest("form").trigger("reset");
                },
                error: function () {
                    $(".name span").text();
                    $("#buyer-registration-form-submit-deny").attr("id", "buyer-registration-form-submit");
                    $("#credit-card-information-btn-deny").attr("id", "credit-card-information-btn");
                    allowLeave();
                    error.removeClass("hide").text("An error occured!");
                    files.children().last().remove();
                    alert(error);
                    //  init.closest("form").trigger("reset");
                },
                cache: false,
                contentType: false,
                processData: false
            }, 'json');


            $(document).on('click', '.module-uploader .closed', function () {
                $(this).closest('.list-group-item').remove();
            });

            previewUpload();
        })
    }

    function previewUpload() {
        $(document).on('click', '.popup', function () {
            var $this = $(this);
            var file_id = $this.data("file_id");
            if (!$('.popup-box').hasClass('active')) {
                if (file_id != "") {
                    $('.popup-box .uploaded-img-holder img').attr("src", "/site_media/" + file_id + "/");
                    $(".popup-box .uploaded-img-holder img").on("load", function () {
                        setTimeout(function () {
                            $('.popup-box').addClass('active');
                        }, 500);
                    });
                }

            }
        });

        $(document).on('click', '.popup-box .close', function () {
            if ($('.popup-box').hasClass('active')) {
                $('.popup-box').removeClass('active');
            }
        })
        $(document).on('click', '.popup-box .file-upload-pop .center-buttons button.black', function () {
            if ($('.popup-box').hasClass('active')) {
                $('.popup-box').removeClass('active');
            }
        });

        $(document).on('click', '.popup-box .file-upload-pop .center-buttons button.blue', function () {
            if ($('.popup-box').hasClass('active')) {
                $('.popup-box').removeClass('active');
            }
            $("input[type='file']:visible").click();
        });
    }

});