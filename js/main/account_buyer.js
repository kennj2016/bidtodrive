var page = 1;

function loadMore() {
    $('[data-load-more]').each(function () {
        var element = $(this), container = $(this).parent(), win = $(window), busy = false, errors = 0, retry = 3;

        function error() {
            errors++;
            if (errors >= retry) unbind();
        }

        function unbind() {
            var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
            win.unbind('scroll resize orientationchange ' + mousewheelevt, check);
        }

        function check() {
            if (busy) return;
            var data = "page=" + (page + 1) + "&act=pagin";
            $.ajax({
                url: window.location.pathname,
                data: data,
                dataType: 'json',
                type: "post",
                success: function (response) {
                    if (response.html) {
                        svgIconInject();
                        container.append(response.html);
                        element = container.find("[data-load-more]").last();
                        page++;
                    } else error();

                    if (response.has_more) check();
                    else unbind();
                },
                error: error,
                complete: function () {
                    busy = false;
                }
            });
            busy = true;
        }

        var mousewheelevt = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel";
        win.bind('scroll resize orientationchange ' + mousewheelevt, check);
    });
}

$(function () {
    loadMore();

    $('.date_mask').mask("99.99.9999", {
        insertMode: false,
        showMaskOnHover: false
    });

    $('.phone_mask').mask("(999) 999-9999", {
        insertMode: false,
        showMaskOnHover: true
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
    $("#update_individual_buyer_account").on("click", function () {
        errors = [];
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: $("#buyer-individual-form").serialize(),
            success: function (response) {
                if (response.has_error) {
                    showErrorMessage(response.status);
                }
                else {
                    $("#complete-update-err").html("");
                    showSuccessMessage("Your account was updated successfully.");
                    setTimeout(function () {
                        location.reload()
                    }, 3000);
                }
            }
        });
    });

    $("#update_dealer_buyer_account").on("click", function () {
        errors = [];
        $.ajax({
            type: "POST",
            url: window.location.href,
            data: $("#buyer-dealer-form").serialize(),
            success: function (response) {
                if (response.has_error) {
                    showErrorMessage(response.status);
                }
                else {
                    $("#complete-update-err").html("");
                    showSuccessMessage("Your account was updated successfully.");
                    setTimeout(function () {
                        location.reload()
                    }, 3000);
                }
            }
        });
    });


    if ($("#dropzone-dealer-license").length) {
        $("#dropzone-dealer-license").dropzone({
            url: window.location.href + "?action=upload_license",
            maxFiles: 1,
            accept: function (file, done) {
                done();
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    if ($(".dz-preview-dealers_license_photo_info").length) {
                        $(".dz-preview-dealers_license_photo_info").remove();
                    }
                });
                this.on("uploadprogress", function (file, progress, bytesSent) {
                    if (file.previewElement) {
                        var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                        progressElement.style.width = progress + "%";
                        progressElement.textContent = Math.round(progress) + "%";
                        denyLeave("dealer license photo");
                    }
                }),
                    this.on("maxfilesexceeded", function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                this.on("success", function (file, response) {
                    if (response && response != "0") {
                        var html = "<input type='hidden' name='dealers_license_photo' value='" + response + "'>";
                        $("#dropzone-dealer-license .dz-preview .dz-image img").attr("src", "/site_media/" + response + "/m/");
                        $("#dropzone-dealer-license .dz-preview").append(html);
                        $("#dropzone-dealer-license .dz-preview .popup").attr("data-file_id", response);
                        $(".dz-progress").hide();
                        allowLeave();
                    } else {
                        $("#dropzone-dealer-license .dz-progress").hide();
                        $("#dropzone-dealer-license .dz-success-mark").hide();
                        $("#dropzone-dealer-license .dz-error-mark").hide();
                        $("#dropzone-dealer-license .dz-filename").text("Error: Something went wrong!");
                        allowLeave();
                    }
                });
            }
        });
        $(document).on('click', '.dz-error-mark', function () {
            $(this).closest('.dz-preview').remove()
        })
    }

    if ($("#dropzone-drivers-license").length) {
        $("#dropzone-drivers-license").dropzone({
            url: window.location.href + "?action=upload_license",
            maxFiles: 1,
            accept: function (file, done) {
                done();
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    if ($(".dz-preview-drivers_license_photo_info").length) {
                        $(".dz-preview-drivers_license_photo_info").remove();
                    }
                });
                this.on("uploadprogress", function (file, progress, bytesSent) {
                    if (file.previewElement) {
                        var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                        progressElement.style.width = progress + "%";
                        progressElement.textContent = Math.round(progress) + "%";
                        denyLeave("driver license photo");
                    }
                }),
                    this.on("maxfilesexceeded", function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                this.on("success", function (file, response) {
                    if (response && response != "0") {
                        var html = "<input type='hidden' name='drivers_license_photo' value='" + response + "'>";
                        $("#dropzone-drivers-license .dz-preview .dz-image img").attr("src", "/site_media/" + response + "/m/");
                        $("#dropzone-drivers-license .dz-preview").append(html);
                        $("#dropzone-drivers-license .dz-preview .popup").attr("data-file_id", response);
                        $(".dz-progress").hide();
                        allowLeave();
                    } else {
                        $("#dropzone-drivers-license .dz-progress").hide();
                        $("#dropzone-drivers-license .dz-success-mark").hide();
                        $("#dropzone-drivers-license .dz-error-mark").hide();
                        $("#dropzone-drivers-license .dz-filename").text("Error: Something went wrong!");
                        allowLeave();
                    }
                });
            }
        });
        $(document).on('click', '.dz-error-mark', function () {
            $(this).closest('.dz-preview').remove()
        })
    }

    var nmb;
    $('.view-switcher .button').on('click', function () {
        nmb = $(this).attr('data-number');
        var self = $(this);
        $('#request').trigger('click');
        $('#popup-account-buyer-switch').addClass('active');
        $('#popup-account-buyer-switch').show();
    });

    $('.switch-it').on('click', function () {
        var self = $('.view-switcher .button[data-number=' + nmb + ']');
        if (!self.hasClass('active')) {
            self.parent().find('.button').removeClass('active');
            self.addClass('active');
        }
        $('.subpage').css('display', 'none');
        $('.subpage-' + nmb).fadeIn();
        if ($('.popup-box').hasClass('active')) {
            $('.popup-box').removeClass('active');
        }
    });

    $(document).on('click', '.popup', function (event) {
        var $this = $(this);
        var file_id = $this.data("file_id");
        if (event.target.id == 'request' && nmb > 0 && typeof nmb !== "undefined") {
            $('.popup-switch-from-to').hide();
            $('#popup-switch-from-to-' + nmb).show();
            setTimeout(function () {
                $('#popup-account-buyer-switch.popup-box').addClass('active');
            }, 500);
        } else {
            var popup = $('.popup-box:not(#popup-account-buyer-switch)');
            if (popup.length && !popup.hasClass('active')) {
                if (file_id != "" && typeof file_id !== "undefined") {
                    popup.find('.uploaded-img-holder img').attr("src", "/license/_orig/" + file_id + "/");
                    popup.find(".uploaded-img-holder img").on("load", function () {
                        setTimeout(function () {
                            popup.addClass('active');
                        }, 500);
                    });
                } else {
                    var imgSrc = $this.closest(".dz-preview").find(".dz-image img").attr("src");
                    popup.find('.uploaded-img-holder img').attr("src", imgSrc);
                    popup.find(".uploaded-img-holder img").on("load", function () {
                        setTimeout(function () {
                            popup.addClass('active');
                        }, 500);
                    });
                }
            }
        }
        svgIconInject();
    });

    $(document).on('click', '.popup-box .close', function () {
        if ($('.popup-box').hasClass('active')) {
            $('.popup-box').removeClass('active');
        }
    })

    $(document).on('click', '.popup-box .close-it', function () {
        if ($('.popup-box').hasClass('active')) {
            $('.popup-box').removeClass('active');
        }
    })

    $(".subpage-1 #update_password_button").click(function (e) {
        e.preventDefault();
        $(".password-wrapper").css("display", "flex");
        $("[name='old_password']").removeAttr("readonly");
    });

    $(".subpage-2 #update_password_button_dealer").click(function (e) {
        e.preventDefault();
        $(".password-wrapper").css("display", "flex");
        $("[name='old_password']").removeAttr("readonly");
    });

    timer();

    $('#payment-select, #payment-select-dealer').selectize({
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

    var selectVal = $("select.select-filter-payments").val();
    var wait = false;
    var frm = $('#buyer-payments-sort');
    var frm2 = $('#buyer-payments-order');
    var wrap = $('#table-body-payments');
    $('select[name="filter"]').change(function (e) {
        e.preventDefault();
        paymentsSort(wait, frm, wrap);
    });

    $(document).on('click', '.cell[data-number="1"]', function (e) {
        if ($(this).hasClass('active')) {
            $("#order-value").val("auction_name_desc");
            $(this).removeClass('active');
            $(this).removeClass('down');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        } else {
            $("#order-value").val("auction_name_asc");
            $(this).addClass('active');
            $(this).addClass('down');
            $(this).addClass('sorted');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        }
    });

    $(document).on('click', '.cell[data-number="2"]', function (e) {
        if ($(this).hasClass('active')) {
            $("#order-value").val("datetime_desc");
            $(this).removeClass('active');
            $(this).removeClass('down');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        } else {
            $("#order-value").val("datetime_asc");
            $(this).addClass('active');
            $(this).addClass('down');
            $(this).addClass('sorted');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        }
    });

    $(document).on('click', '.cell[data-number="3"]', function (e) {
        if ($(this).hasClass('active')) {
            $("#order-value").val("buyer_fee_desc");
            $(this).removeClass('active');
            $(this).removeClass('down');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        } else {
            $("#order-value").val("buyer_fee_asc");
            $(this).addClass('active');
            $(this).addClass('down');
            $(this).addClass('sorted');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="4"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        }
    });

    $(document).on('click', '.cell[data-number="4"]', function (e) {
        if ($(this).hasClass('active')) {
            $("#order-value").val("sale_price_desc");
            $(this).removeClass('active');
            $(this).removeClass('down');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        } else {
            $("#order-value").val("sale_price_asc");
            $(this).addClass('active');
            $(this).addClass('down');
            $(this).addClass('sorted');
            $('.cell[data-number="2"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="3"]').removeClass('active').removeClass('down').removeClass('sorted');
            $('.cell[data-number="1"]').removeClass('active').removeClass('down').removeClass('sorted');
            paymentsSort(wait, frm2, wrap);
        }
    });

    $(".module-search-listing .content .listing-1 .item").each(function () {
        if ($(".module-search-listing .content .listing-1 .item .text .buy_now_form").length != 0) {
            $('.buy-it-now-mention').hide();
        }
    });

});

function paymentsSort(wait, frm, wrap) {
    if (wait) {
        return;
    }
    wait = true;
    $.ajax("/account/buyer/payments/", {
        type: 'post',
        dataType: 'json',
        data: frm.serialize(),
        success: function (response) {
            wrap.html(response.html);
            $('#table-body-payments [data-link]').on('click', function () {
                var dataLink = $(this).data('link');
                window.location = dataLink;
            });
        },
        complete: function () {
            wait = false;
        }
    });
}

function accountSwitcherPopup(callback) {
    var popup = new simplePopup();
    var conent = +'<h2 class="title">'
        + 'Popup Header Title Here'
        + '</h2>'
        + '<p class="desc">'
        + 'Are you sure you want to switch your account type from [Dealer/Individual] to [Dealer/Individual]?'
        + '</p>'
        + '<div class="center-buttons">'
        + '<button type="button" class="btn-2 black close-it">Cancel</button>'
        + '<button type="button" class="btn-2 blue switch-it">Continue</button>'
        + '</div>';
    popup.append(content);
    if (typeof callback == 'function') {
        popup.callback = callback;
    }
    popup.open();
    $(content).find('.close-it').on('click', function () {
        popup.close();
    });
    return popup;
}

function timer() {
    $('.timer').each(function () {
        if ($(this).data('started') !== 'started') {
            if ($(this).data("format") == "date") {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'd%d, h%h, m%m',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        timer.target.css('color', color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    }
                });
            } else if ($(this).data('left') > 86399) {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'd%d, h%h, m%m',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        timer.target.css('color', color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    }
                });
            } else if ($(this).data('left') < 86400 && $(this).data('left') > 3600) {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'h%h, m%m',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        timer.target.css('color', color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    }
                });
            } else {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'm%:s%',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        timer.target.css('color', color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    },
                    on_exhausted: function (timer) {
                        location.reload();
                    }
                });
            }
        }
    })
    $('.timer').backward_timer('start')
}