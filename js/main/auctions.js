$(function () {
    var wait = false;
    var wrap = $('.module-search-listing .listing-1');
    var frm = $('#auction_search_form');
    frm.find('[name="city_zip"]').change(function (e) {
        if ($(".use_location").hasClass("selected")) {
            $(".use_location").removeClass("selected");
            $(".use_location span").text("use my location");
        }
    });
    frm.find('[name="state"]').change(function (e) {
        if ($(".use_location").hasClass("selected")) {
            $(".use_location").removeClass("selected");
            $(".use_location span").text("use my location");
        }
    });

    $('[name="keyword"]').change(function (e) {
        $('[name="mobile_keyword"]').val($(this).val());
    });
    $('[name="mobile_keyword"]').change(function (e) {
        $('[name="keyword"]').val($(this).val());
    });
    $('.apply_filters_button').click(function (e) {
        e.preventDefault();
        frm.submit();
        if ($('.t2 .sec-1').hasClass('active')) {
            $('.t2 .sec-1').removeClass('active')
        }

    });
    $('.clear_filters_button').click(function (e) {
        e.preventDefault();
        location.reload();
    });

    frm.find('[name="keyword"]').keypress(function (e) {
        if (e.which == 13) {
            frm.submit();
            return false;
        }
    });

    frm.find('[name="seller_name"]').keypress(function (e) {
        if (e.which == 13) {
            frm.submit();
            return false;
        }
    });
    $('[name="mobile_keyword"]').keypress(function (e) {
        if (e.which == 13) {
            frm.submit();
            return false;
        }
    });

    if (getMobileOperatingSystem() != "unknown") {
        document.onkeyup = function (e) {
            $('[name="keyword"]').val($('[name="mobile_keyword"]').val());
            if (e.which == 13) {
                frm.submit();
                $("input").blur();
                return false;
            }
        }
    }

    $(".module-search-listing .content .listing-1 .item").each(function () {
        if ($(".module-search-listing .content .listing-1 .item .text .buy_now_form").length != 0) {
            $('.buy-it-now-mention').hide();
        }
    });

    frm.submit(function (event) {
        event.preventDefault();
        if (wait) {
            return;
        }
        wait = true;
        $.ajax(window.location.origin + "/auctions/", {
            type: 'post',
            dataType: 'json',
            data: frm.serialize(),
            success: function (response) {
                wrap.html(response.html);
                timer();
                svgIconInject();
                $(".top-controll-panel .result-detail span").text((response.count_records > 1 ? response.count_records + ' Listings' : response.count_records + ' Listing'));
                $(".top-controll-panel .result-name").html(response.keyword_title);
                selectAfterAjax(response.filters.make, response.filters.model, response.filters.color);
            },
            complete: function () {
                wait = false;
            }
        });

    });

    $("#auction_search_form .use_location").click(function (e) {
        e.preventDefault();
        if ($(this).hasClass("selected")) {
            clearLocation();
        } else {
            autoloadLocation();
        }
    });

    rangeYear();
    rangePrice();
    rangeMiles();
    timer();
    select();
    selectizeColor();
    filterAuctionsByStatus();
    // loadMore();
});

function filterAuctionsByStatus() {
    var auctionsStatusesFilter = $('#auctions-statuses-filter');
    if (auctionsStatusesFilter.length) {
        $('[data-auction-status-filter]', auctionsStatusesFilter).on('click', function () {
            var fLink = $(this);
            var fs = fLink.data('auction-status-filter');
            $('[data-auction-status-filter]', auctionsStatusesFilter).removeClass('bold');
            fLink.addClass('bold');
            $('[data-auction-status]').hide().filter('[data-auction-status="' + fs + '"]').show();
        });
        var activeStatusFilter = $('[data-auction-status-filter="Active"]');
        if (activeStatusFilter.length) activeStatusFilter.click();
    }
}

function selectizeColor() {
    $('#color-selectize').selectize({
        valueField: 'url',
        labelField: 'name',
        searchField: 'name',
        create: false,
        render: {
            item: function (item, escape) {
                return '<div>' +

                    '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' + item.url + '"></i>' + '</span>' +
                    '<span class="by">' + item.name + '</span>' +

                    '</div>';
            },
            option: function (item, escape) {
                return '<div>' +

                    '<span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' + item.url + '"></i>' + '</span>' +
                    '<span class="by">' + item.name + '</span>' +

                    '</div>';
            }
        }
    });
}

function selectAfterAjax(makeData, modelData, colorData) {
    select_make = $('#auction_search_form .select-3.make')[0].selectize;
    select_make.destroy();
    var html = "<option value=''></option>";
    if (makeData) {
        $.each(makeData, function (key, item) {
            html += "<option value='" + key + "' " + (item.selected ? 'selected' : '') + ">" + item.name + "(" + item.count + ")" + "</option>";
        });
    }
    $('#auction_search_form .select-3.make').html(html).selectize({
        onChange: function (value) {
            if (!value.length) return;
            select_model = $('#auction_search_form .select-3.model')[0].selectize;
            select_model.disable();
            select_model.clearOptions();
            if (modelData) {
                $.each(modelData, function (key, item) {
                    if (value == item.make) {
                        select_model.addOption({value: key, text: item.name + "(" + item.count + ")"});
                    }
                });
            }
            select_model.refreshOptions();
            select_model.enable();
        }
    });

    select_model = $('#auction_search_form .select-3.model')[0].selectize;
    select_model.destroy();
    var html = "<option value=''></option>";
    if (modelData) {
        $.each(modelData, function (key, item) {
            html += "<option value='" + key + "' " + (item.selected ? 'selected' : '') + ">" + item.name + " (" + item.count + ")" + "</option>";
        });
    }
    $('#auction_search_form .select-3.model').html(html).selectize();

    select_color = $('#auction_search_form #color-selectize')[0].selectize;
    select_color.destroy();
    var html = "<option value=''></option>";
    if (colorData) {
        $.each(colorData, function (key, item) {
            html += "<option value='" + key + "' " + (item.selected ? 'selected' : '') + ">" + item.name + " (" + item.count + ")" + "</option>";
        });
    }
    $('#auction_search_form #color-selectize').html(html);
    selectizeColor();
}

function select() {
    var select_make, $select_make;
    var select_model, $select_model;
    $select_make = $('#auction_search_form .select-3.make').selectize({
        onChange: function (value) {
            if (!value.length) return;
            select_model.disable();
            select_model.clearOptions();
            if (models) {
                $.each(models, function (key, item) {
                    if (value == item.make) {
                        select_model.addOption({value: key, text: item.name + "(" + item.count + ")"});
                    }
                });
            }
            select_model.refreshOptions();
            select_model.enable();
        }
    });

    $select_model = $('#auction_search_form .select-3.model').selectize({});
    select_model = $select_model[0].selectize;
    select_make = $select_make[0].selectize;
    select_model.disable();
}

function clearLocation() {
    $("#auction_search_form input[name='city_zip']").val("");
    $("#auction_search_form select[name='state']").val("");
    select = $("#auction_search_form select[name='state']")[0].selectize;
    select.setValue("");
    select.setTextboxValue("");
    $(".use_location").removeClass("selected");
    $(".use_location span").text("use my location");
}

function autoloadLocation() {
    var geocoder;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successFunction, errorFunction, {timeout: 10000});
    }

    //Get the latitude and the longitude;
    function successFunction(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        codeLatLng(lat, lng)
    }

    function errorFunction(err) {
        console.log("Geocoder failed", err);
        alert("An error occurred while getting location.");
    }

    function initialize() {
        geocoder = new google.maps.Geocoder();
    }

    initialize();

    function codeLatLng(lat, lng) {
        var latlng = new google.maps.LatLng(lat, lng);
        geocoder.geocode({'latLng': latlng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                city = "";
                state = "";
                if (results[1]) {
                    //formatted address
                    //find country name
                    for (var i = 0; i < results[0].address_components.length; i++) {
                        for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                            if (results[0].address_components[i].types[b] == "locality") {
                                //this is the object you are looking for
                                city = results[0].address_components[i];
                                break;
                            }
                        }
                    }
                    for (var i = 0; i < results[0].address_components.length; i++) {
                        for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                            if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                                //this is the object you are looking for
                                state = results[0].address_components[i];
                                break;
                            }
                        }
                    }
                    //city data
                    if (city) {
                        $("#auction_search_form input[name='city_zip']").val(city.long_name);
                    }
                    //state data
                    if (state) {
                        $("#auction_search_form select[name='state']").val(state.short_name);
                        select = $("#auction_search_form select[name='state']")[0].selectize;
                        select.setValue(state.short_name);
                        select.setTextboxValue(state.short_name);
                    }
                    if (city || state) {
                        $(".use_location").addClass("selected");
                        $(".use_location span").text("clear my location");
                    }
                } else {
                    console("No results found");
                    alert("An error occurred while getting location.");
                }
            } else {
                console("Geocoder failed due to: " + status);
                alert("An error occurred while getting location.");
            }
        });
    }
}

function rangeYear() {
    if ($('#yearrange').length) {
        var from = $('#yearrange').data("from");
        var to = $('#yearrange').data("to");
        var html5Slider = document.getElementById('yearrange');
        noUiSlider.create(html5Slider, {
            start: [from, to],
            connect: true,
            range: {
                'min': from,
                'max': to
            }
        });
        var inputNumber3 = document.getElementById('input-number3');
        var inputNumber4 = document.getElementById('input-number4');
        var inputNumber3Hidden = document.getElementById('input-number3-hidden');
        var inputNumber4Hidden = document.getElementById('input-number4-hidden');
        inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
        inputNumber4.style.width = ((inputNumber4.value.length + 1) * 9) + 'px';
        html5Slider.noUiSlider.on('update', function (values, handle) {
            var value = values[handle];
            if (handle) {
                inputNumber4.value = Math.round(value);
            } else {
                inputNumber3.value = Math.round(value);
            }
            inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
            inputNumber4.style.width = ((inputNumber4.value.length + 1) * 9) + 'px';
        });
        html5Slider.noUiSlider.on('end', function (values, handle) {
            var value = Math.round(values[handle]);
            if (handle) {
                value = (to != value ? value : "");
                inputNumber4Hidden.value = value;
            } else {
                value = (from != value ? value : "");
                inputNumber3Hidden.value = value;
            }
        });
        $(inputNumber3).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([this.value, null]);
            var value = Math.round(this.value);
            value = (from != value ? value : "");
            inputNumber3Hidden.value = value;
        }).on('keypress', function () {
            inputNumber3.style.width = ((inputNumber3.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
        $(inputNumber4).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([null, this.value]);
            var value = Math.round(this.value);
            value = (to != value ? value : "");
            inputNumber4Hidden.value = value;
        }).on('keypress', function () {
            inputNumber4.style.width = ((inputNumber4.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
        $('.fake-input').on('click', function (e) {
            var inputNumber1 = $(this).find('.class1');
            var inputNumber2 = $(this).find('.class2');
            var senderElementName = event.target.className.toLowerCase();
            if (senderElementName.indexOf("class1") >= 0) {
                $(this).find(inputNumber1).focus();
            } else if (senderElementName.indexOf("class2") >= 0) {
                $(this).find(inputNumber2).focus();
            } else {
                $(this).find(inputNumber1).focus();
            }
        });
        $('.form').on("keypress", function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                return false;
            }
        });
    }
}

function rangePrice() {
    if ($('#pricerange').length) {
        var from = $('#pricerange').data("from");
        var to = $('#pricerange').data("to");
        var html5Slider = document.getElementById('pricerange');
        noUiSlider.create(html5Slider, {
            start: [from, to],
            connect: true,
            range: {
                'min': from,
                'max': to
            }
        });
        var inputNumber1 = document.getElementById('input-number1');
        var inputNumber2 = document.getElementById('input-number2');
        var inputNumber1Hidden = document.getElementById('input-number1-hidden');
        var inputNumber2Hidden = document.getElementById('input-number2-hidden');
        inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
        inputNumber2.style.width = ((inputNumber2.value.length + 1) * 9) + 'px';
        html5Slider.noUiSlider.on('update', function (values, handle) {
            var value = values[handle];
            if (handle) {
                inputNumber2.value = Math.round(value);
            } else {
                inputNumber1.value = Math.round(value);
            }
            inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
            inputNumber2.style.width = ((inputNumber2.value.length + 1) * 9) + 'px';
        });
        html5Slider.noUiSlider.on('end', function (values, handle) {
            var value = Math.round(values[handle]);
            if (handle) {
                value = (to != value ? value : "");
                inputNumber2Hidden.value = value;
            } else {
                value = (from != value ? value : "");
                inputNumber1Hidden.value = value;
            }
        });
        $(inputNumber1).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([this.value, null]);
            var value = Math.round(this.value);
            value = (from != value ? value : "");
            inputNumber1Hidden.value = value;
        }).on('keypress', function () {
            inputNumber1.style.width = ((inputNumber1.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
        $(inputNumber2).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([null, this.value]);
            var value = Math.round(this.value);
            value = (to != value ? value : "");
            inputNumber2Hidden.value = value;
        }).on('keypress', function () {
            inputNumber2.style.width = ((inputNumber2.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
    }
}

function rangeMiles() {
    if ($('#milesrange').length) {
        var from = $('#milesrange').data("from");
        var to = $('#milesrange').data("to");
        var html5Slider = document.getElementById('milesrange');
        noUiSlider.create(html5Slider, {
            start: [from, to],
            connect: true,
            range: {
                'min': from,
                'max': to
            }
        });
        var inputNumber5 = document.getElementById('input-number5');
        var inputNumber6 = document.getElementById('input-number6');
        var inputNumber5Hidden = document.getElementById('input-number5-hidden');
        var inputNumber6Hidden = document.getElementById('input-number6-hidden');
        inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
        inputNumber6.style.width = ((inputNumber6.value.length + 1) * 9) + 'px';
        html5Slider.noUiSlider.on('update', function (values, handle) {
            var value = values[handle];
            if (handle) {
                inputNumber6.value = Math.round(value);
            } else {
                inputNumber5.value = Math.round(value);
            }
            inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
            inputNumber6.style.width = ((inputNumber6.value.length + 1) * 9) + 'px';
        });
        html5Slider.noUiSlider.on('end', function (values, handle) {
            var value = Math.round(values[handle]);
            if (handle) {
                value = (to != value ? value : "");
                inputNumber6Hidden.value = value;
            } else {
                value = (from != value ? value : "");
                inputNumber5Hidden.value = value;
            }
        });
        $(inputNumber5).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([this.value, null]);
            var value = Math.round(this.value);
            value = (from != value ? value : "");
            inputNumber5Hidden.value = value;
        }).on('keypress', function () {
            inputNumber5.style.width = ((inputNumber5.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
        $(inputNumber6).on('change', function (e) {
            e.preventDefault();
            html5Slider.noUiSlider.set([null, this.value]);
            var value = Math.round(this.value);
            value = (to != value ? value : "");
            inputNumber6Hidden.value = value;
        }).on('keypress', function () {
            inputNumber6.style.width = ((inputNumber6.value.length + 1) * 8) + 'px';
        }).on('focus', function () {
            $(this).closest('.fake-input').addClass('active');
        }).on('blur', function () {
            $(this).closest('.fake-input').removeClass('active');
        });
    }
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
    });
    $('.timer').backward_timer('start')
}

function getMobileOperatingSystem() {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    // Windows Phone must come first because its UA also contains "Android"
    if (/windows phone/i.test(userAgent)) {
        return "Windows Phone";
    }

    if (/android/i.test(userAgent)) {
        return "Android";
    }

    // iOS detection from: http://stackoverflow.com/a/9039885/177710
    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "unknown";
}

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
            var data = $('#auction_search_form').serialize() + "&page=" + (page + 1) + "&action=load_more";
            if (container.offset().top + container.height() > win.scrollTop() + win.height()) return;
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
