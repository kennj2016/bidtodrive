$(function () {

    if ($(".timer").length) {
        /*$(".timer").each(function (index) {
            $(this).countdown($(this).attr("data-exp-date"), {elapse: true}).on("update.countdown", function (event) {
                if (event.offset.totalHours < 24) {
                    $(this).text(event.strftime('%H, %M'));
                } else {
                    $(this).text(event.strftime('%D days %H:%M:%S').replace(/^0+/, ''));
                }
                if (event.offset.totalHours < 1) {
                    $(this).addClass("red");
                }
            });
        });*/
        
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

});