$(function () {

    $('input.custom-number').keyup(function(event) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    $('.date_mask').mask("99.99.9999", {
        insertMode: false,
        showMaskOnHover: true,
        placeholder: "mm.dd.yyyy"
    });
    $('.phone_mask').mask("(999) 999-9999", {
        insertMode: false,
        showMaskOnHover: true
    });

    var errors = [];
    var lang = {};
    var conf = {
        onElementValidate: function (valid, $el, $form, errorMess) {
            if (!valid) {
                errors.push({el: $el, error: errorMess});
            }
        }
    };

    $("#step-1-submit").on("click", function () {
        $(".loadding_").attr("style","display:flex");
        var value = $("input[name='vin_number']").val();
        $.ajax({
            url:'https://vindecoder.p.rapidapi.com/decode_vin?vin='+value,
            headers: {
                "X-RapidAPI-Host":"vindecoder.p.rapidapi.com",
                "X-RapidAPI-Key":"be3fc1904cmsh5ac0c087269a986p114d59jsn57d26b1310a3",
                "Content-Type":"application/x-www-form-urlencoded"
            },
            success: function(res){
                $(".loadding_").attr("style","display:none");
                $("p#vin_number_message").remove();
                errors = [];
                if ($("#step-1").valid(lang, conf, true)) {
                    $.ajax({
                        type: "POST",
                        url: window.location.href,
                        data: $("#step-1").serialize(),
                        success: function (response) {
                            if (response.has_error) {
                                if ($('iao-alert[type="error"]').length) {
                                    $('iao-alert > iao-alert-close').trigger('click');
                                }
                                showErrorMessage(response.status);
                            } else {
                                $("#step-2-tab").show();
                                $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                                $("#step-1-tab").hide();
                                $(".module-steps .first-item").removeClass("active");
                                $(".module-steps .second-item").addClass("active");
                                $(".module-steps .first-item").addClass("done");
                                $(".module-steps .first-item .ico-step").hide();
                                $(".module-steps .first-item .ico-done").show();
                                $("iao-alert-close").trigger("click");

                                $("input[name=s2_vin_number]").val($("input[name=vin_number]").val());
                                if (response.car_info != null) {
                                    $("#s2-make").val(response.car_info.Make);
                                    $("#s2-model").val(response.car_info.Model);
                                    $("#s2-year").val(response.car_info.ModelYear);
                                    if(typeof(response.car_info.DisplacementL) != "undefined" && typeof(response.car_info.EngineConfiguration) != "undefined" && typeof(response.car_info.EngineCylinders) != "undefined"){
                                        $("#s2-engine").val(Math.round( response.car_info.DisplacementL * 10 ) / 10 + "L " + response.car_info.EngineConfiguration + " " + response.car_info.EngineCylinders);
                                    }else{
                                        $("#s2-engine").val("");
                                    }
                                    $("#s2-cylinders").val(response.car_info.EngineCylinders);
                                    $("#s2-number_of_doors").val(response.car_info.Doors);
                                    $("#s2-trim").val(response.car_info.Trim);
                                    $("#s2-trim2").val(response.car_info.Trim2);
                                    $("#s2-fuel_type").val(response.car_info.FuelTypePrimary);
                                }
                            }
                        }
                    });
                }
            },
            error: function(err){
              $.ajax({
                  type: "POST",
                  url: window.location.href,
                  data: $("#step-1").serialize(),
                  success: function (response) {
                      if (response.has_error) {
                          if ($('iao-alert[type="error"]').length) {
                              $('iao-alert > iao-alert-close').trigger('click');
                          }
                          showErrorMessage(response.status);
                      } else {
                          $("#step-2-tab").show();
                          $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                          $("#step-1-tab").hide();
                          $(".module-steps .first-item").removeClass("active");
                          $(".module-steps .second-item").addClass("active");
                          $(".module-steps .first-item").addClass("done");
                          $(".module-steps .first-item .ico-step").hide();
                          $(".module-steps .first-item .ico-done").show();
                          $("iao-alert-close").trigger("click");

                          $("input[name=s2_vin_number]").val($("input[name=vin_number]").val());
                          if (response.car_info != null) {
                              $("#s2-make").val(response.car_info.Make);
                              $("#s2-model").val(response.car_info.Model);
                              $("#s2-year").val(response.car_info.ModelYear);
                              if(typeof(response.car_info.DisplacementL) != "undefined" && typeof(response.car_info.EngineConfiguration) != "undefined" && typeof(response.car_info.EngineCylinders) != "undefined"){
                                  $("#s2-engine").val(Math.round( response.car_info.DisplacementL * 10 ) / 10 + "L " + response.car_info.EngineConfiguration + " " + response.car_info.EngineCylinders);
                              }else{
                                  $("#s2-engine").val("");
                              }
                              $("#s2-cylinders").val(response.car_info.EngineCylinders);
                              $("#s2-number_of_doors").val(response.car_info.Doors);
                              $("#s2-trim").val(response.car_info.Trim);
                              $("#s2-trim2").val(response.car_info.Trim2);
                              $("#s2-fuel_type").val(response.car_info.FuelTypePrimary);
                          }
                      }
                  }
              });
                $(".loadding_").attr("style","display:none");
                var message = '<p style="color:red" id="vin_number_message">Your Vin Number is not exists</p>';
                $("p#vin_number_message").remove();
                $("input[name='vin_number']").after(message);
            }
        });


    });

    $('#first-preview').on('click', function () {
        $(".module-steps .first-item .ico-step").show();
        $(".module-steps .first-item .ico-done").hide();
        $(".module-steps .second-item").removeClass("done");
        $(".module-steps .third-item").removeClass("done");
        $(".module-steps .fourth-item").removeClass("done");
        $(".module-steps .fifth-item").removeClass("done");
    });
    $("#step-2-submit").on("click", function () {
        errors = [];
        if ($("#step-2").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#step-2").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    } else {
                        $("#step-3-tab").show();
                        $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                        $("#step-2-tab").hide();
                        $(".module-steps .first-item").removeClass("active");
                        $(".module-steps .second-item").removeClass("active");
                        $(".module-steps .second-item").addClass("done");
                        $(".module-steps .third-item").addClass("active");
                        $(".module-steps .second-item .ico-step").hide();
                        $(".module-steps .second-item .ico-done").show();
                        $(".module-steps .third-item .ico-step").show();
                        $(".module-steps .third-item .ico-done").hide();
                        $("iao-alert-close").trigger("click");
                    }
                }
            });
        }
    });

    $('#second-preview').on('click', function () {
        $(".module-steps .second-item .ico-step").show();
        $(".module-steps .second-item .ico-done").hide();
        $(".module-steps .third-item").removeClass("done");
        $(".module-steps .fourth-item").removeClass("done");
        $(".module-steps .fifth-item").removeClass("done");
    });
    $("#step-3-submit").on("click", function () {
        errors = [];
        if ($("#step-3").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#step-3").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    } else {
                        $("#step-4-tab").show();
                        $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                        $("#step-3-tab").hide();
                        $(".module-steps .first-item").removeClass("active");
                        $(".module-steps .second-item").removeClass("active");
                        $(".module-steps .third-item").removeClass("active");
                        $(".module-steps .third-item").addClass("done");
                        $(".module-steps .fourth-item").addClass("active");
                        $(".module-steps .third-item .ico-step").hide();
                        $(".module-steps .third-item .ico-done").show();
                        $(".module-steps .fourth-item .ico-step").show();
                        $(".module-steps .fourth-item .ico-done").hide();
                        $("iao-alert-close").trigger("click");
                    }
                }
            });
        }
    });

    $('#third-preview').on('click', function () {
        $(".module-steps .third-item .ico-step").show();
        $(".module-steps .third-item .ico-done").hide();
        $(".module-steps .fourth-item").removeClass("done");
        $(".module-steps .fifth-item").removeClass("done");
    });
    $("#step-4-submit").on("click", function () {
        errors = [];
        if ($("#step-4").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#step-4").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    } else {
                        $("#step-5-tab").show();
                        $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                        $("#step-4-tab").hide();
                        $(".module-steps .first-item").removeClass("active");
                        $(".module-steps .second-item").removeClass("active");
                        $(".module-steps .third-item").removeClass("active");
                        $(".module-steps .fourth-item").addClass("done");
                        $(".module-steps .fourth-item").removeClass("active");
                        $(".module-steps .fifth-item").addClass("active");
                        $(".module-steps .fourth-item .ico-step").hide();
                        $(".module-steps .fourth-item .ico-done").show();
                        $(".module-steps .fifth-item .ico-step").show();
                        $(".module-steps .fifth-item .ico-done").hide();
                        $("iao-alert-close").trigger("click");
                    }
                }
            });
        }
    });

    $('#fourth-preview').on('click', function () {
        $(".module-steps .fourth-item .ico-step").show();
        $(".module-steps .fourth-item .ico-done").hide();
        $(".module-steps .fifth-item").removeClass("done");
        $(".module-steps .sixth-item").removeClass("done");
    });
    $("#step-5-submit").on("click", function () {
        errors = [];
        if ($("#step-5").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#step-5").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    } else {
                        $("#step-6-tab").show();
                        $('.account-right-box .page.active').closest('.baron__scroller').stop().animate({scrollTop: 0}, 500);
                        $("#step-5-tab").hide();
                        $(".module-steps .first-item").removeClass("active");
                        $(".module-steps .second-item").removeClass("active");
                        $(".module-steps .third-item").removeClass("active");
                        $(".module-steps .fourth-item").removeClass("active");
                        $(".module-steps .fifth-item").removeClass("active");
                        $(".module-steps .fifth-item").addClass("done");
                        $(".module-steps .sixth-item").addClass("active");
                        $(".module-steps .fifth-item .ico-step").hide();
                        $(".module-steps .fifth-item .ico-done").show();
                        $(".module-steps .sixth-item .ico-step").show();
                        $(".module-steps .sixth-item .ico-done").hide();
                        $("iao-alert-close").trigger("click");

                        if(typeof response.auction_info.reserve_price_formatted != 'undefined'){
                            $("#s5_reserve_price").val("$" + response.auction_info.reserve_price_formatted);
                        }else{
                            $("#s5_reserve_price").val("$0");
                        }
                        $("#s5_starting_bid_price").val("$" + response.auction_info.starting_bid_price_formatted);
                        $("#s5_buy_now_price").val("$" + response.auction_info.buy_now_price_formatted);
                        if (response.auction_info.auctions_length == 60){
                            $("#s5_auction_length").val("1 hour");
                        } else {
                            $("#s5_auction_length").val(response.auction_info.auctions_length);
                        }
                        $("#s5_vin_number").val(response.auction_info.vin_number);
                        $("#s5_make").val(response.auction_info.make);
                        $("#s5_model").val(response.auction_info.model);
                        $("#s5_year").val(response.auction_info.year);
                        $("#s5_engine").val(response.auction_info.engine);
                        $("#s5_number_of_cylinders").val(response.auction_info.number_of_cylinders);
                        $("#s5_number_of_doors").val(response.auction_info.number_of_doors);
                        $("#s5_transmission").val(response.auction_info.transmission);

                        var tmpIntColors = "";
                        var tmpIntColors = response.auction_info.interior_color;
                        if (tmpIntColors == "") {
                            tmpIntColors = "";
                        } else {
                            tmpIntColors = interiorColors[tmpIntColors];
                        }

                        var tmpExtColors = "";
                        var tmpExtColors = response.auction_info.color;

                        if (tmpExtColors == "") {
                            tmpExtColors = "";
                        } else {
                            tmpExtColors = exteriorColors[tmpExtColors];
                        }

                        if (tmpExtColors == "") {
                            $("#s5_color").html('<span></span>');
                        } else {
                            $("#s5_color").html('<span class="color-show-box ' + response.auction_info.color.toLowerCase() + '" style="background-color: ' + response.auction_info.color.toLowerCase() + ';"></span><span>' + tmpExtColors + '</span>');
                        }
                        if (tmpIntColors == "") {
                            $("#s5_interior_color").html('<span></span>');
                        } else {
                            $("#s5_interior_color").html('<span class="color-show-box ' + response.auction_info.interior_color.toLowerCase() + '" style="background-color: ' + response.auction_info.interior_color.toLowerCase() + ';"></span><span>' + tmpIntColors + '</span>');
                        }

                        $("#s5_auction_condition").val(response.auction_info.auction_condition);
                        $("#s5_mileage").val(response.auction_info.mileage_formatted);
                        $("#s5_fuel_type").val(response.auction_info.fuel_type);
                        $("#s5_title_status").val(response.auction_info.title_status);
                        $("#s5_title_wait_time").val(response.auction_info.title_wait_time);
                        if (response.auction_info.sell_to == 1) {
                            var sellTo = "Dealers Only";
                        } else if (response.auction_info.sell_to == 2) {
                            var sellTo = "Anyone";
                        } else {
                            var sellTo = "";
                        }
                        $("#s5_sell_to").val(sellTo);
                        $("#s5_description").html(response.auction_info.description.replace(/\r\n|\n\r|\r|\n/g, "<br>"));
                        $("#s5_terms_conditions").html(response.auction_info.terms_condition.replace(/(\r\n|\n\r|\r|\n)/g, "<br>"));
                        $("#s5_additional_fees").html(response.auction_info.additional_fees.replace(/(\r\n|\n\r|\r|\n)/g, "<br>"));
                        $("#s5_pickup_window").val(response.auction_info.pickup_window);
                        if(response.auction_info.pickup_note != ""){
                            $("#s5_pickup_note").html(response.auction_info.pickup_note.replace(/(\r\n|\n\r|\r|\n)/g, "<br>"));
                        }else{
                            $("#s5_pickup_note").html("");
                        }
                        $("#s5_drive_type").val(response.auction_info.drive_type);

                        if($.type(response.auction_info.payment_method) === "string"){
                            $("#s5_payment_method").val(response.auction_info.payment_method);
                        }else if(typeof(response.auction_info.payment_method) != "undefined" && response.auction_info.payment_method !== null){
                            $("#s5_payment_method").val(response.auction_info.payment_method.join(", "));
                        }else{
                            $("#s5_payment_method").val("");
                        }
                    }
                }
            });
        }
    });

    $('#fifth-preview').on('click', function () {
        $(".module-steps .fifth-item .ico-step").show();
        $(".module-steps .fifth-item .ico-done").hide();
        $(".module-steps .sixth-item").removeClass("done");
        $(".module-steps .fourth-item").removeClass("done");
        $(".module-steps .fifth-item").removeClass("done");
    });
    $("#step-6-submit").on("click", function () {
        errors = [];
        if ($("#step-6").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: $("#step-6").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    } else {
                        $("#auction_steps").hide();
                        showSuccessMessage(response.status);
                        console.log(response);
                        window.location.href = "/auctions/" + response.record_id + "/";
                    }
                }
            });
        }
    });

    if ($("#dropzoneMulty").length) {
        $("#dropzoneMulty").dropzone({
            url: window.location.href + "?action=upload_auction_images",
            timeout: 180000,
            maxFiles: 1000,
            accept: function (file, done) {
                done();
                var images = $(".dz-preview");
                if (images.parent().is("#preview-wrapper")) {
                    images.unwrap("#preview-wrapper");
                    images.wrapAll("<div id='preview-wrapper'></div>");
                } else {
                    $('#preview-wrapper').remove();
                    images.wrapAll("<div id='preview-wrapper'></div>");
                }
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    var fileName = file.name.substr(0,9) + "..";
                    if ($(".dz-preview-image_info").length) $(".dz-preview-image_info").remove();
                    $(file.previewElement).find(".dz-success-mark, .dz-error-mark").hide();
                    $(file.previewElement).find('[data-dz-name]').text(fileName);
                });
                this.on("uploadprogress", function (file, progress, bytesSent) {
                    if (file.previewElement) {
                        var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                        progressElement.style.width = progress + "%";
                        progressElement.textContent = Math.round(progress) + "%";
                        denyLeave("license photo");
                    }
                }),
                    this.on("maxfilesexceeded", function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                this.on("success", function (file, response) {
                    var block = $(file.previewElement);
                    if (!response.error && response.file && response.file.photo != "0") {
                        var html = "<input type='hidden' name='photos[" + response.file.photo + "]' value='" + response.file.title + "'>";
                        block.append(html);
                        block.find(".popup").attr("data-file_id", response.file.photo);
                        block.find(".dz-filename span").text(file.name);
                        block.find(".dz-success-mark, .dz-error-mark").show();
                        block.find(".dz-progress").hide();
                        allowLeave();
                    } else {
                        var count = $(".dz-preview").length;
                        if (count <= 1) block.parent().hide();
                        block.remove();
                        allowLeave();
                    }
                });
            }
        });
        $(document).on('click', '.dz-error-mark', function () {
          $(this).closest('.dz-preview').remove();
          if (!$("#dropzoneMulty #preview-wrapper").children().length) {
            $("#dropzoneMulty #preview-wrapper").hide();
          }
        });
    }

    $(document).on('click', '.popup', function () {
        var $this = $(this);
        var file_id = $this.data("file_id");
        if (!$('.popup-box').hasClass('active')) {
            if (file_id != "" && typeof file_id !== "undefined") {
                $('.popup-box .uploaded-img-holder img').attr("src", "/site_media/" + file_id + "/");
                $(".popup-box .uploaded-img-holder img").on("load", function () {
                    setTimeout(function () {
                        $('.popup-box').addClass('active');
                    }, 500);
                });
            } else {
                var imgSrc = $this.closest(".dz-preview").find(".dz-image img").attr("src");
                $('.popup-box .uploaded-img-holder img').attr("src", imgSrc);
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
    });

    $('.payment-select-custom-2').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });

    if ($('.trumbowyg').length){
        $('.trumbowyg').trumbowyg({
            btns: ['strong', 'em', '|', 'unorderedList', 'orderedList'],
            autogrow: true
        });
    }


    // clickable boxes at the top
    var stepOneTab = $("#step-1-tab");
    var stepTwoTab = $("#step-2-tab");
    var stepThreeTab = $("#step-3-tab");
    var stepFourTab = $("#step-4-tab");
    var stepFiveTab = $("#step-5-tab");
    var stepSixTab = $("#step-6-tab");

    var firstItem = $("#auction_steps .module-steps .first-item");
    var secondItem = $("#auction_steps .module-steps .second-item");
    var thirdItem = $("#auction_steps .module-steps .third-item");
    var fourthItem = $("#auction_steps .module-steps .fourth-item");
    var fifthItem = $("#auction_steps .module-steps .fifth-item");
    var sixthItem = $("#auction_steps .module-steps .sixth-item");

    var firstItemIcoStep = $("#auction_steps .module-steps .first-item .ico-step");
    var secondItemIcoStep = $("#auction_steps .module-steps .second-item .ico-step");
    var thirdItemIcoStep = $("#auction_steps .module-steps .third-item .ico-step");
    var fourthItemIcoStep = $("#auction_steps .module-steps .fourth-item .ico-step");
    var fifthItemIcoStep = $("#auction_steps .module-steps .fifth-item .ico-step");
    var sixthItemIcoStep = $("#auction_steps .module-steps .sixth-item .ico-step");

    // first step: Price
    $(document).on('click','#auction_steps .module-steps .first-item.done',function(e) {
        firstItem.removeClass("done").addClass("active");
        secondItem.removeClass("done").removeClass("active");
        thirdItem.removeClass("done").removeClass("active");
        fourthItem.removeClass("done").removeClass("active");
        fifthItem.removeClass("done").removeClass("active");
        sixthItem.removeClass("done").removeClass("active");

        firstItemIcoStep.show();
        secondItemIcoStep.show();
        thirdItemIcoStep.show();
        fourthItemIcoStep.show();
        fifthItemIcoStep.show();
        sixthItemIcoStep.show();

        stepOneTab.show();
        stepTwoTab.hide();
        stepThreeTab.hide();
        stepFourTab.hide();
        stepFiveTab.hide();
        stepSixTab.hide();
    });

    // second step: VIN Specs
    $(document).on('click','#auction_steps .module-steps .second-item.done',function(e) {
        secondItem.removeClass("done").addClass("active");
        thirdItem.removeClass("done").removeClass("active");
        fourthItem.removeClass("done").removeClass("active");
        fifthItem.removeClass("active").removeClass("done");
        sixthItem.removeClass("done").removeClass("active");

        secondItemIcoStep.show();
        thirdItemIcoStep.show();
        fourthItemIcoStep.show();
        fifthItemIcoStep.show();
        sixthItemIcoStep.show();

        stepOneTab.hide();
        stepTwoTab.show();
        stepThreeTab.hide();
        stepFourTab.hide();
        stepFiveTab.hide();
        stepSixTab.hide();
    });

    // third step: More Specs
    $(document).on('click','#auction_steps .module-steps .third-item.done',function(e) {
        thirdItem.removeClass("done").addClass("active");
        fourthItem.removeClass("done").removeClass("active");
        fifthItem.removeClass("active").removeClass("done");
        sixthItem.removeClass("done").removeClass("active");

        thirdItemIcoStep.show();
        fourthItemIcoStep.show();
        fifthItemIcoStep.show();
        sixthItemIcoStep.show();

        stepOneTab.hide();
        stepTwoTab.hide();
        stepThreeTab.show();
        stepFourTab.hide();
        stepFiveTab.hide();
        stepSixTab.hide();
    });

    // fourth step: Terms
    $(document).on('click','#auction_steps .module-steps .fourth-item.done',function(e) {
        fourthItem.removeClass("done").addClass("active");
        fifthItem.removeClass("done").removeClass("active");
        sixthItem.removeClass("done").removeClass("active");

        fourthItemIcoStep.show();
        fifthItemIcoStep.show();
        sixthItemIcoStep.show();

        stepOneTab.hide();
        stepTwoTab.hide();
        stepThreeTab.show();
        stepFourTab.hide();
        stepFiveTab.hide();
        stepSixTab.hide();
    });

    // fourth step: Photos
    $(document).on('click','#auction_steps .module-steps .fifth-item.done',function(e) {
        fifthItem.removeClass("done").addClass("active");
        sixthItem.removeClass("done").removeClass("active");

        fifthItemIcoStep.show();
        sixthItemIcoStep.show();

        stepOneTab.hide();
        stepTwoTab.hide();
        stepThreeTab.show();
        stepFourTab.hide();
        stepFiveTab.hide();
        stepSixTab.hide();

        $("#auction_steps .module-steps .fifth-item .ico-done").hide();
    });

    let termsCondition = $("#terms-conditions"), condition = false, conditionVal = (termsCondition.trumbowyg('html') !== "");

    let $condition = $('#terms_condition-select').selectize({
      onChange: function(value) {
        let text = $('.terms_condition-box-write'), btn = $(".remove-selection.term");
        if (value == 0 || value == -1) {
          btn.hide();
          text.show();
        } else {
          btn.show();
          text.hide();
        }
      }
    });

    termsCondition.on('tbwchange', function() {
      if ($(this).val() !== "") {
        $condition[0].selectize.addOption({value:-1,text:'Custom option'});
        $condition[0].selectize.setValue(-1);
        condition = true;
      } else {
        $condition[0].selectize.setValue(0);
        $condition[0].selectize.removeOption(-1);
        condition = false;
      }
    });

    if (conditionVal) {
      condition = true;
      $condition[0].selectize.addOption({value:-1,text:'Custom option'});
      $condition[0].selectize.setValue(-1);
    }

    let additionalFees = $("#additional-fees"), fees = false, feesValue = (additionalFees.trumbowyg('html') !== "");

    let $fees = $('#additional-fees-select').selectize({
      onChange: function(value) {
        let text = $('.additional-fees-box-write');
        let btn = $(".remove-selection.fees");
        if (value == 0 || value == -1) {
          btn.hide();
          text.show();
        } else {
          btn.show();
          text.hide();
        }
      }
    });

    additionalFees.on('tbwchange', function() {
      if ($(this).val() !== "") {
        $fees[0].selectize.addOption({value:-1,text:'Custom option'});
        $fees[0].selectize.setValue(-1);
        fees = true;
      } else {
        $fees[0].selectize.setValue(0);
        $fees[0].selectize.removeOption(-1);
        fees = false;
      }
    });

    if (feesValue) {
      fees = true;
      $fees[0].selectize.addOption({value:-1,text:'Custom option'});
      $fees[0].selectize.setValue(-1);
    }

    let $pickup = $('#payment-pickup-select').selectize({
    onChange: function(value) {
      let text = $('.payment-pickup-box-write');
      let btn = $(".remove-selection.pickup");
      if (value == 0) {
        btn.hide();
        text.show();
      } else {
        btn.show();
        text.hide();
      }
    }
    });

    $(".remove-selection.term").click(function (e){
    e.preventDefault();
    $condition[0].selectize.setValue(0);
    });

    $(".remove-selection.fees").click(function (e){
    e.preventDefault();
    $fees[0].selectize.setValue(0);
    });

    $(".remove-selection.pickup").click(function (e){
    e.preventDefault();
    $pickup[0].selectize.setValue(0);
    });



});
