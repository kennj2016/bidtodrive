var wait = false;
var frm = $('#seller-watched-listings-sort');
var wrap = $('#module-search-listing .listing-1');
var page = 1;

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
    if ($("#dropzone-profile").length) {
        $("#dropzone-profile").dropzone({
            url: "/account/?action=upload_photo",
            maxFiles: 1,
            accept: function (file, done) {
                done();
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    if ($(".dz-preview-profile_photo_info").length) {
                        $(".dz-preview-profile_photo_info").remove();
                    }
                });
                this.on("uploadprogress", function (file, progress, bytesSent) {
                    if (file.previewElement) {
                        var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                        progressElement.style.width = progress + "%";
                        progressElement.textContent = Math.round(progress) + "%";
                        denyLeave("profile photo");
                    }
                }),
                    this.on("maxfilesexceeded", function (file) {
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                this.on("success", function (file, response) {
                    if (response && response != "0") {
                        var html = "<input type='hidden' name='profile_photo' value='" + response + "'>";
                        $("#dropzone-profile .dz-preview .dz-image img").attr("src", "/site_media/" + response + "/m/")
                        $("#dropzone-profile .dz-preview").append(html);
                        $("#dropzone-profile .dz-preview .popup").attr("data-file_id", response);
                        $(".dz-progress").hide();
                        allowLeave();
                    } else {
                        $("#dropzone-profile .dz-progress").hide();
                        $("#dropzone-profile .dz-success-mark").hide();
                        $("#dropzone-profile .dz-error-mark").hide();
                        $("#dropzone-profile .dz-filename").text("Error: Something went wrong!");
                        allowLeave();
                    }
                });
            }
        });
        $(document).on('click', '.dz-error-mark', function () {
            $(this).closest('.dz-preview').remove()
        });
    }
    if ($("#dropzone-dealer-license").length) {
        $("#dropzone-dealer-license").dropzone({
            url: "/account/?action=upload_license",
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
                        denyLeave("license photo");
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
                        $("#dropzone-dealer-license .dz-progress").hide();
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
        });
    }
    $("#update_password_button").click(function (e) {
        e.preventDefault();
        $(".password-wrapper").css("display", "flex");
        $("[name='old_password']").removeAttr("readonly");
    });
    $(document).on('click', '.popup', function () {
        var $this = $(this);
        var file_id = $this.data("file_id");
        if (!$('.popup-box').hasClass('active')) {
            if (file_id != "" && typeof file_id !== "undefined") {
                $('.popup-box .uploaded-img-holder img').attr("src", "/license/_orig/" + file_id + "/");
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

    $('select[name="sort"]').change(function (e) {
        e.preventDefault();
        if (wait) {
            return;
        }
        wait = true;
        $.ajax("/account/", {
            type: 'post',
            dataType: 'json',
            data: frm.serialize()/* + "&action=load_more"*/,
            success: function (response) {
                wrap.html(response.html);
                timer();
                //filterAuctionsByStatus();
                $('#module-search-listing [data-link]').on('click', function () {
                    var dataLink = $(this).data('link');
                    window.location = dataLink;
                });
            },
            complete: function () {
                wait = false;
            }
        });

    });

    var auctionsStatusesFilter = $('#auctions-statuses-filter');
    if (auctionsStatusesFilter.length) {
        $('[data-auction-status-filter]', auctionsStatusesFilter).on('click', function () {
            page = 1;
            var fLink = $(this);
            var fs = fLink.data('auction-status-filter');
            var sCount = fLink.data('auction-status-count');
            $('[data-auction-status-filter]', auctionsStatusesFilter).removeClass('bold');
            fLink.addClass('bold');
            $("#auctions-statuses-filter #auction_status").val(fs);
            $("#seller-watched-listings-sort #auction_status_filter").val(fs);
            $(".title-action").html(fs);
            var data = $("#auctions-statuses-form").serialize() + "&sort=" + $("#sort-filter option:selected").val();
            $.ajax("/account/", {
                type: 'post',
                dataType: 'json',
                data: data,
                success: function (response) {
                    wrap.html(response.html);
                    timer();
                    $('#module-search-listing [data-link]').on('click', function () {
                        var dataLink = $(this).data('link');
                        window.location = dataLink;
                    });
                },
                complete: function () {
                    wait = false;
                }
            });
        });
        var activeStatusFilter = $('[data-auction-status-filter="Active"]');
        if (activeStatusFilter.length) activeStatusFilter.click();
    }

    timer();
    loadMore();
});

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
    });
    $('.timer').backward_timer('start')
}

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
            var data = "&page=" + (page + 1) + "&action=load_more" + "&sort=" + $("#sort-filter option:selected").val() + "&auction_status=" + $("#auction_status_filter").val();
            if (parseInt(container.offset().top + container.height()) > parseInt(win.scrollTop() + win.height())) return;
            $.ajax({
                url: window.location.pathname,
                data: data,
                dataType: 'json',
                type: 'post',
                success: function (response) {
                    if (response.html) {
                        svgIconInject();
                        container.append(response.html);
                        element = container.find("[data-load-more]").last();
                        page++;
                        timer();
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
