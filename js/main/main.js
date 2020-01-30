document.onreadystatechange = function() {
    if ("complete" === document.readyState) {
        function t() {
            window.location = newLocation
        }

        function e() {
            if ($(".lds-ring").length) {
                ! function t(e, s) {
                    setTimeout(function() {
                        s && "infinite" == s ? t(e, s) : s && s > 1 && t(e, s - 1)
                    }, 1e3);
                    var i = $(".lds-ring");
                    $({
                        deg: 0
                    }).animate({
                        deg: e
                    }, {
                        duration: 1e3,
                        step: function(t) {
                            i.css({
                                transform: "rotate(" + t + "deg)"
                            })
                        }
                    })
                }(360, "infinite")
            }

            function e(t, e) {
                var s = Number(e) || 7.7;

                function i() {
                    t.style.width = (t.value.length + 1) * s + "px"
                }
                var o = "keyup,keypress,focus,blur,change".split(",");
                for (var n in o) t.addEventListener(o[n], i, !1);
                i()
            }
            var i;

            function n() {
                $html = $("html"), $body = $("body");
                var t = $body.outerWidth(),
                    e = $body.outerHeight(),
                    s = [self.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, self.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
                $html.data("scroll-position", s), $html.data("previous-overflow", $html.css("overflow")), $html.css("overflow", "hidden"), window.scrollTo(s[0], s[1]);
                var i = $body.outerWidth() - t,
                    o = $body.outerHeight() - e;
                $body.css({
                    "margin-right": i,
                    "margin-bottom": o
                }), console.log("scroll is locked")
            }

            function a() {
                $html = $("html"), $body = $("body"), $html.css("overflow", $html.data("previous-overflow"));
                var t = $html.data("scroll-position");
                window.scrollTo(t[0], t[1]), $body.css({
                    "margin-right": 0,
                    "margin-bottom": 0
                }), console.log("scroll is unlocked")
            }
            $(".logged .opener-el").on("click", function() {
                $(this).hasClass("active") ? $(this).removeClass("active") : ($(this).addClass("active"), $(".mobile-btn").hasClass("open") && ($("header .nav").fadeOut(), $(".mobile-btn").removeClass("open")))
            }), $(".logged .opener-el").on("clickout", function() {
                $(this).hasClass("active") && $(this).removeClass("active")
            }), $("#bidInputField").on("focus touchstart", function() {
                $(this).addClass("focused")
            }).on("blur", function() {
                $(this).removeClass("focused")
            }), $("#txt").length && (e(document.getElementById("txt"), 28), $("#txt").on("focus", function() {
                
            }).on("blur", function() {
                $(".mobile-fixed-panel > .holder").fadeIn()
            })), $("#txt2").length && (e(document.getElementById("txt2"), 28), $("#txt2").on("focus", function() {

            }).on("blur", function() {
                $(".mobile-fixed-panel > .holder").fadeIn()
            })), $(".open-mob-bid-input").on("click", function() {
                $(this).hasClass("active") ? ($(this).removeClass("active"), $(this).closest(".mobile-fixed-panel").find(".input-bid-mob-box").removeClass("active"), a(), $("body").hasClass("ios") && $("body").css("overflow", "auto")) : ($(this).addClass("active"), $(this).closest(".mobile-fixed-panel").find(".input-bid-mob-box").addClass("active"), n(), $("body").hasClass("ios") && $("body").css("overflow", "hidden"))
            }), $(".open-bid-input-custom").on("click", function() {
                $(this).hasClass("active") ? ($(this).removeClass("active"), $(this).closest(".buttons").find(".input-box").removeClass("active"), $(this).closest(".buttons").find(".buttons-box").removeClass("input-active")) : ($(this).addClass("active"), $(this).closest(".buttons").find(".input-box").addClass("active"), $(this).closest(".buttons").find(".buttons-box").addClass("input-active"))
            }), $(".top-panel-auction .opener-buttons").on("click", function() {
                if ($(this).hasClass("active")) $(this).removeClass("active"), $(this).parent().find(".buttons").removeClass("active"), a(), $("body").hasClass("ios") && ($("body").css("overflow", "auto"), $(this).closest(".top-panel-auction").removeClass("fixed"));
                else {
                    $(this).addClass("active"), $(this).parent().find(".buttons").addClass("active"), n(), $("body").css("margin-right", 0), $("body").hasClass("ios") && ($("body").css("overflow", "hidden"), $(this).closest(".top-panel-auction").addClass("fixed"));
                    var t = $(".top-panel-auction").outerHeight();
                    $(".top-panel-auction .buttons.active").css("top", t)
                }
            }), $(".filter-add-btn .open-button").on("click", function() {
                $(this).hasClass("active") ? ($(this).removeClass("active"), $(this).parent().removeClass("active")) : ($(this).addClass("active"), $(this).parent().addClass("active"))
            }), $(".filter-add-btn").on("clickout", function() {
                $(this).hasClass("active") && ($(this).removeClass("active"), $(this).find(".open-button").removeClass("active"))
            }), $("#dropzone").length && ($("#dropzone").dropzone({
                url: "/file/post",
                maxFiles: 1,
                accept: function(t, e) {
                    e()
                },
                init: function() {
                    this.on("maxfilesexceeded", function(t) {
                        this.removeAllFiles(), this.addFile(t)
                    })
                }
            }), $(document).on("click", ".dz-error-mark", function() {
                $(this).closest(".dz-preview").remove()
            })), $("#dropzone-dealer").length && ($("#dropzone-dealer").dropzone({
                url: "/file/post",
                maxFiles: 1,
                accept: function(t, e) {
                    e()
                },
                init: function() {
                    this.on("maxfilesexceeded", function(t) {
                        this.removeAllFiles(), this.addFile(t)
                    })
                }
            }), $(document).on("click", ".dz-error-mark", function() {
                $(this).closest(".dz-preview").remove()
            })), i = 0, $(".toggle_radio").each(function() {
                $(this).find('input[type="radio"]:first-of-type').attr("id", "first_toggle" + i), $(this).find('input[type="radio"]:last-of-type').attr("id", "first_toggle" + i + "_2"), $(this).find("label:first-of-type").attr("for", "first_toggle" + i), $(this).find("label:last-of-type").attr("for", "first_toggle" + i + "_2"), i++
            }), $(document).on("click", ".account-left-box .page-links-list .btn", function(t) {
                var e = $(this).parent().find(".btn"),
                    s = $(this).index(),
                    i = $(".account-right-box").find(".page"),
                    o = $(".account-right-box").find(".page").eq(s),
                    n = $(".account-right-box");
                e.removeClass("active"), $(this).addClass("active"), (new TimelineMax).to(n, .3, {
                    opacity: 0,
                    x: 0,
                    ease: Power3.easeInOut,
                    onCompleteParams: ["{self}"],
                    onComplete: function() {
                        i.removeClass("active"), o.addClass("active")
                    }
                }).to(n, .3, {
                    opacity: 1,
                    x: 0,
                    ease: Power3.easeInOut
                }), $(".left-panel-close-button").length && setTimeout(function() {
                    $(".left-panel-close-button").trigger("click")
                }, 300), $("#sticky").length && ($(this).hasClass("activate-sticky-scroll") ? $("#sticky").addClass("active") : $("#sticky").removeClass("active"))
            }), $(document).on("click", ".module-steps .item.done", function(t) {
                var e = $(this).attr("data-number"),
                    s = $(this).closest(".module-steps").parent().find(".inner-subpage-box"),
                    i = s.find(".sub-sub-page");
                $(this).closest(".module-steps").find(".item").each(function() {
                        var t = $(this);
                        t.attr("data-number") == e ? t.addClass("active") : t.removeClass("active")
                    }),
                    function() {
                        (new TimelineMax).to(s, .3, {
                            opacity: 0,
                            ease: Power3.easeInOut,
                            onCompleteParams: ["{self}"],
                            onComplete: function() {
                                i.hide().removeClass("active"), s.find(".sub-sub-page[data-number='" + e + "']").fadeIn().addClass("active")
                            }
                        }).to(s, .3, {
                            opacity: 1,
                            ease: Power3.easeInOut
                        })
                    }()
            }), $(document).on("click", ".sub-sub-page .switchSubSubPage", function(t) {
                t.preventDefault();
                var e = $(this).closest(".inner-subpage-box"),
                    s = e.find(".sub-sub-page"),
                    i = $(this).closest(".inner-subpage-box").parent().find(".module-steps .item"),
                    o = $(this).attr("data-number");
                "next" == $(this).text() ? (s.each(function() {
                    var t = $(this),
                        i = t.attr("data-number");
                    if (i > o && i - o == 1) {
                        (new TimelineMax).to(e, .3, {
                            opacity: 0,
                            ease: Power3.easeInOut,
                            onCompleteParams: ["{self}"],
                            onComplete: function() {
                                s.hide().removeClass("active"), t.fadeIn().addClass("active")
                            }
                        }).to(e, .3, {
                            opacity: 1,
                            ease: Power3.easeInOut
                        })
                    }
                }), i.each(function() {
                    var t = $(this),
                        e = t.attr("data-number");
                    e === o && t.addClass("done").removeClass("active"), e > o && t.removeClass("active"), e - o == 1 && t.addClass("active")
                })) : (s.each(function() {
                    var t = $(this),
                        i = t.attr("data-number");
                    if (i < o && o - i == 1) {
                        (new TimelineMax).to(e, .3, {
                            opacity: 0,
                            ease: Power3.easeInOut,
                            onCompleteParams: ["{self}"],
                            onComplete: function() {
                                s.hide().removeClass("active"), t.fadeIn().addClass("active")
                            }
                        }).to(e, .3, {
                            opacity: 1,
                            ease: Power3.easeInOut
                        })
                    }
                }), i.each(function() {
                    var t = $(this),
                        e = t.attr("data-number");
                    e == o && t.removeClass("active"), e > o && t.removeClass("active"), e < o && t.removeClass("active").addClass("done"), o - e == 1 && t.addClass("active")
                })), $(".account-right-box .page.active").closest(".baron__scroller").stop().animate({
                    scrollTop: 0
                }, 500), r()
            }), $(".tablet-left-panel-opener-box .left-panel-opener-button").on("click", function() {
                $(".t2 .sec-1").hasClass("active") || $(".t2 .sec-1").addClass("active"), $(".t2-top-panel .sec-1").hasClass("active") || $(".t2-top-panel .sec-1").addClass("active")
            }), $(".left-panel-close-button").on("click", function() {
                $(".t2 .sec-1").hasClass("active") && $(".t2 .sec-1").removeClass("active"), $(".t2-top-panel .sec-1").hasClass("active") && $(".t2-top-panel .sec-1").removeClass("active")
            }), $(document).on("click", ".module-tab-1 .tab-index .item", function() {
                if (!$(this).hasClass("active")) {
                    var t = $(this),
                        e = $(this).index(),
                        i = $(this).parent().children(),
                        n = ($(this).parent().parent().siblings(".tab-content"), $(this).parent().parent().siblings(".tab-content").children(".tab-item")),
                        a = $(this).parent().parent().siblings(".tab-content").children(".tab-item").eq(e);
                    i.removeClass("active"), t.addClass("active"), (new TimelineMax).to(n, .3, {
                        opacity: 0,
                        x: 0,
                        ease: Power3.easeInOut,
                        onCompleteParams: ["{self}"],
                        onComplete: (n.removeClass("active"), a.addClass("active"), o(), void s())
                    }).to(a, .3, {
                        opacity: 1,
                        x: 0,
                        ease: Power3.easeInOut
                    }), a.find(".chart-pie").length > 0 && setTimeout(function() {
                        chartPie()
                    }, 300)
                }
            }), $(".top-controll-panel .btn").on("click", function() {
                $(this).hasClass("active") || ($(".top-controll-panel .btn").removeClass("active"), $(this).addClass("active")), $(this).hasClass("gridview") ? ($(".module-search-listing .listing-1").fadeOut(400), setTimeout(function() {
                    $(".module-search-listing .listing-1").addClass("gridview"), $(".module-search-listing .listing-1").fadeIn()
                }, 400)) : ($(".module-search-listing .listing-1").fadeOut(400), setTimeout(function() {
                    $(".module-search-listing .listing-1").removeClass("gridview"), $(".module-search-listing .listing-1").fadeIn()
                }, 400))
            }), $(".fake-link").click(function() {
                var t = $(this).data("link");
                window.location = t
            }), $("a").click(function() {
                ("" == $(this).attr("target") || "_self" == $(this).attr("target") && -1 == $(this).attr("href").indexOf("#")) && (event.preventDefault(), newLocation = this.href, TweenMax.to("html", .5, {
                    opacity: 0,
                    ease: Expo.easeOut,
                    onComplete: t
                }))
            }), $(".mobile-btn").click(function(t) {
                $(this).hasClass("open") ? ($("header .nav").fadeOut(), $(this).removeClass("open")) : (console.log(t.target), $("header .nav").fadeIn(), $(this).addClass("open"), $(".logged .opener-el").length && $(".logged .opener-el").hasClass("active") && $(".logged .opener-el").removeClass("active"), $(".cpt-filter .filter-box-opener").length && $(".cpt-filter .filter-box-opener").hasClass("active") && ($(".cpt-filter .filter-box-opener").removeClass("active"), $(".cpt-filter .filter-box").removeClass("active"), a()), $(".left-panel-close-button").length && setTimeout(function() {
                    $(".left-panel-close-button").trigger("click")
                }, 300), $(".auction-detail .top-panel .opener-buttons").length && $(".auction-detail .top-panel .opener-buttons").hasClass("active") && $(".auction-detail .top-panel .opener-buttons").trigger("click"))
            }), $(".cpt-filter .filter-box-opener").click(function() {
                $(this).hasClass("active") ? ($(this).removeClass("active"), $(".cpt-filter .filter-box").removeClass("active"), $(".search-float-panel").length && $(".search-float-panel").css("height", "auto"), a()) : ($(this).addClass("active"), $(".cpt-filter .filter-box").addClass("active"), $(".search-float-panel").length && $(".search-float-panel").css("height", "100%"), n())
            }), $(".cpt-filter .filter-box .closer .close").click(function() {
                $(".cpt-filter .filter-box-opener").removeClass("active"), $(".cpt-filter .filter-box").removeClass("active"), $(".search-float-panel").length && $(".search-float-panel").css("height", "auto"), a()
            })
        }

        function s() {
            $(".container > *, .balancer > *").each(function() {
                var t, e;
                $(this).removeClass("last"), $(this).removeClass("first"), (t = Math.round($(this).offset().left + $(this).outerWidth(!1) + ($(this).outerWidth(!0) - $(this).outerWidth(!1)) / 2)) - 20 <= (e = Math.round($(this).parent().offset().left + $(this).parent().width() + ($(this).parent().outerWidth(!1) - $(this).parent().width()) / 2)) && e <= t + 20 && $(this).addClass("last"), (t = Math.round($(this).offset().left)) - 20 <= (e = Math.round($(this).parent().offset().left)) && e <= t + 20 && $(this).addClass("first")
            })
        }

        function i() {
            var t;
            t = function() {
                "use strict";

                function t(t, e) {
                    var s = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {};
                    if (!e) throw Error("maxHeight is required");
                    var i = "string" == typeof t ? document.querySelectorAll(t) : t,
                        o = s.character || "…",
                        n = s.classname || "js-shave",
                        a = s.spaces || !1,
                        l = '<span class="js-shave-char">' + o + "</span>";
                    "length" in i || (i = [i]);
                    for (var r = 0; r < i.length; r += 1) {
                        var c = i[r],
                            h = c.style,
                            d = c.querySelector("." + n),
                            _ = void 0 === c.textContent ? "innerText" : "textContent";
                        d && (c.removeChild(c.querySelector(".js-shave-char")), c[_] = c[_]);
                        var p = c[_],
                            m = a ? p.split(" ") : p;
                        if (!(m.length < 2)) {
                            var u = h.height;
                            h.height = "auto";
                            var f = h.maxHeight;
                            if (h.maxHeight = "none", c.offsetHeight <= e) h.height = u, h.maxHeight = f;
                            else {
                                for (var v = m.length - 1, $ = 0, b = void 0; $ < v;) b = $ + v + 1 >> 1, c[_] = a ? m.slice(0, b).join(" ") : m.slice(0, b), c.insertAdjacentHTML("beforeend", l), c.offsetHeight > e ? v = a ? b - 1 : b - 2 : $ = b;
                                c[_] = a ? m.slice(0, v).join(" ") : m.slice(0, v), c.insertAdjacentHTML("beforeend", l);
                                var g = a ? m.slice(v).join(" ") : m.slice(v);
                                c.insertAdjacentHTML("beforeend", '<span class="' + n + '" style="display:none;">' + g + "</span>"), h.height = u, h.maxHeight = f
                            }
                        }
                    }
                }
                if ("undefined" != typeof window) {
                    var e = window.$ || window.jQuery || window.Zepto;
                    e && (e.fn.shave = function(e, s) {
                        return t(this, e, s), this
                    })
                }
                $(".news-listing").length && $(".news-listing .listing-1 .item").each(function() {
                    var e = $(this).find(".box").outerHeight(),
                        s = $(this).find(".title").outerHeight(),
                        i = $(this).find(".stamp"),
                        o = $(this).find(".stamp p"),
                        n = e - s,
                        a = e - s - 10;
                    i.height(n), t(o, a)
                })
            }, "object" == typeof exports && "undefined" != typeof module ? t() : "function" == typeof define && define.amd ? define(t) : t()
        }

        function o() {
            var t = $(".module-tab-1 .tab-content");
            t.each(function() {
                var t = $(this).find(".tab-item.active").outerHeight();
                $(this).css("min-height", t)
            }), t.each(function() {
                $(this).find(".module-tab-1").length > 0 && $(this).addClass("top-tabs")
            })
        }

        function n() {
            var t = $(".baron").baron({
                root: ".baron",
                scroller: ".baron__scroller",
                bar: ".baron__bar",
                scrollingCls: "_scrolling",
                draggingCls: "_dragging"
            });
            $("body").hasClass("tablet") || $("body").hasClass("mobile") ? t.dispose() : t.update()
        }

        function a() {
            var t, e;
            t = $(window).width(), e = t > 1e4 ? "desktop" : t > 1008 ? "desktop" : t > 752 ? "tablet" : t > 0 ? "mobile" : "", $(document.body).removeClass("desktop tablet mobile").addClass(e)
        }

        function l() {
            $(".baron-table").baron({
                root: ".baron-table",
                scroller: ".baron__scroller",
                bar: ".baron__bar",
                direction: "h",
                scrollingCls: "_scrolling",
                draggingCls: "_dragging"
            })
        }

        function r() {
            $(".module-create-edit").length && autosize($(".module-create-edit textarea"))
        }

        function c() {
            var t = $(window).height(),
                e = $(".t2-top-panel-instance").outerHeight();
            $(".sec-holder-inner").css("height", t - e)
        }
        $(function() {
            var t, h;
            e(), s(), a(), i(), o(), $(document).on("click", ".ajaxtrigger-forgot", function(t) {
                    t.preventDefault();
                    var e = $(this).attr("href");
                    $.get(e, {}, function(t) {
                        $(".module-tab-2").fadeOut(300, function() {
                            $(".module-tab-2").html(t), $(".module-tab-2").fadeIn(300)
                        })
                    })
                }), $(document).on("click", ".ajaxtrigger-login", function(t) {
                    t.preventDefault(), $(this).hasClass("fake-tab") && !$(this).hasClass("active") && ($(".fake-tab").removeClass("active"), $(this).addClass("active"));
                    var e = $(this).attr("href");
                    $.get(e, {}, function(t) {
                        $(".module-tab-2 .content > .tab-content > .tab-item").fadeOut(300, function() {
                            $(".module-tab-2 .content > .tab-content > .tab-item").html(t), $(".module-tab-2 .content > .tab-content > .tab-item").fadeIn(300)
                        })
                    })
                }), $(document).on("click", ".ajaxtrigger-login-inner", function(t) {
                    t.preventDefault(), $(this).hasClass("fake-tab-inner") && !$(this).hasClass("active") && ($(".fake-tab-inner").removeClass("active"), $(this).addClass("active"));
                    var e = $(this).attr("href");
                    $.get(e, {}, function(t) {
                        $(".module-tab-3 .content > .tab-content > .tab-item").fadeOut(300, function() {
                            $(".module-tab-3 .content > .tab-content > .tab-item").html(t), $(".module-tab-3 .content > .tab-content > .tab-item").fadeIn(300), $("#fileuploader").length && fileUploader()
                        })
                    })
                }), n(), $(".alert-default").click(function() {
                    var t = $(this).find(".io-text").html();
                    $.iaoAlert({
                        msg: t,
                        autoHide: !1,
                        type: "notification",
                        position: "bottom-right",
                        fadeOnHover: !1,
                        mode: "dark"
                    })
                }), $(".alert-warning").click(function() {
                    var t = $(this).find(".io-text").html();
                    $.iaoAlert({
                        msg: t,
                        type: "error",
                        autoHide: !1,
                        position: "bottom-right",
                        fadeOnHover: !1,
                        mode: "dark"
                    })
                }), $(".alert-success").click(function() {
                    var t = $(this).find(".io-text").html();
                    $.iaoAlert({
                        msg: t,
                        type: "success",
                        autoHide: !1,
                        position: "bottom-right",
                        fadeOnHover: !1,
                        mode: "dark"
                    })
                }), (t = $(".account-right-box .payment-table")).length && t.each(function() {
                    var t = $(this),
                        e = t.find(".table-body .table-row");
                    $(".orderBnt", t).on("click", function() {
                        $(this).parent().find(".orderBnt").removeClass("sorted"), $(this).addClass("sorted");
                        var s = $(this).data("number");
                        if ($(this).hasClass("active")) {
                            $(this).removeClass("active"), $(this).removeClass("down");
                            var i = e.sort(function(t, e) {
                                return parseInt($(t).find(".cell[data-number='" + s + "'] .el").attr("data-sort")) > parseInt($(e).find(".cell[data-number='" + s + "'] .el").attr("data-sort"))
                            });
                            t.find(".table-body").html(i)
                        } else $(this).addClass("active"), $(this).addClass("down"), i = e.sort(function(t, e) {
                            return parseInt($(t).find(".cell[data-number='" + s + "'] .el").attr("data-sort")) < parseInt($(e).find(".cell[data-number='" + s + "'] .el").attr("data-sort"))
                        }), t.find(".table-body").html(i)
                    })
                }), $(".payment-table-holder").scroll(function() {
                    $(".topScrollVisible").scrollLeft($(".payment-table-holder").scrollLeft())
                }), $(".topScrollVisible").scroll(function() {
                    $(".payment-table-holder").scrollLeft($(".topScrollVisible").scrollLeft())
                }), $(document).on("click", ".popup", function(t) {
                    t.preventDefault(), $(".popup-box").hide();
                    var e = $(this).attr("data-number");
                    if ($(".popup-box-" + e).hasClass("active")) return !1;
                    $(".popup-box-" + e).addClass("active"), $(".popup-box-" + e).show()
                }), $(document).on("click", ".popup-box .close", function() {
                    $(".popup-box").hasClass("active") && $(".popup-box").removeClass("active")
                }), $(document).on("click", ".popup-box .close-it", function() {
                    $(".popup-box").hasClass("active") && $(".popup-box").removeClass("active")
                }), l(), $("#sticky .baron__scroller").on("scroll", function() {
                    var t = $(this).scrollLeft();
                    $(".payment-table-scroll-holder").scrollLeft(t)
                }), $(".payment-table-scroll-holder").on("scroll", function() {
                    var t = $(this).scrollLeft();
                    $("#sticky .baron__scroller").scrollLeft(t)
                }), $(".t2 .baron__scroller").on("scroll", function() {
                    var t = $("#flag1").offset().top,
                        e = $("#flag2").offset().top,
                        s = ($(".payment-table-holder").outerHeight(), $(window).height());
                    $(".abs").length, $(".payment-table-holder").visible() && t < 0 && (e - 100 < s ? $("#sticky").removeClass("active") : $("#sticky").addClass("active"))
                }), $(".content-blocks-holder").length && autosize($(".content-blocks-holder textarea")), r(), h = function() {
                    if (h.prototype._cachedResult) return h.prototype._cachedResult;
                    var t = !!window.opr && !!opr.addons || !!window.opera || navigator.userAgent.indexOf(" OPR/") >= 0,
                        e = "undefined" != typeof InstallTrigger,
                        s = /constructor/i.test(window.HTMLElement) || "[object SafariRemoteNotification]" === (!window.safari || safari.pushNotification).toString(),
                        i = !!document.documentMode,
                        o = !i && !!window.StyleMedia,
                        n = !!window.chrome && !!window.chrome.webstore,
                        a = (n || t) && !!window.CSS;
                    return h.prototype._cachedResult = t ? "opera" : e ? "firefox" : s ? "Safari" : n ? "chrome" : i ? "ie" : o ? "edge" : a ? "blink" : "unknown"
                }, $("body").addClass(h()), c(), $(".auction-detail .payment-table-holder .table-row.new").html(), $(".footer").outerHeight(), $(".auction-detail .payment-table-holder"),
                function() {
                    ! function(t, e) {
                        e.document;
                        var s = t(e);

                        function i(t, e, s) {
                            var i = t[0]["scroll" + s] / e["outer" + s]();
                            return [i, Math.floor(e["inner" + s]() / i)]
                        }

                        function o() {
                            this.init.apply(this, arguments)
                        }
                        o.prototype = {
                            name: "dragscroll",
                            isTouchDevice: void 0 !== e.ontouchstart
                        }, t.extend(o.prototype, {
                            events: {
                                M_DOWN: o.prototype.isTouchDevice ? "touchstart." + o.prototype.name : "mousedown." + o.prototype.name,
                                M_UP: o.prototype.isTouchDevice ? "touchend." + o.prototype.name : "mouseup." + o.prototype.name,
                                M_MOVE: o.prototype.isTouchDevice ? "touchmove." + o.prototype.name : "mousemove." + o.prototype.name,
                                M_ENTER: "mouseenter." + o.prototype.name,
                                M_LEAVE: "mouseleave." + o.prototype.name,
                                M_WHEEL: "mousewheel." + o.prototype.name,
                                S_STOP: "scrollstop." + o.prototype.name,
                                S_START: "scrollstart." + o.prototype.name,
                                SCROLL: "scroll." + o.prototype.name,
                                RESIZE: o.prototype.isTouchDevice ? "orientationchange." + o.prototype.name : "resize." + o.prototype.name
                            },
                            init: function(e, s) {
                                var i = "<div/>",
                                    o = this;
                                this.options = s, this.elem = e, this.innerElem = this.elem.wrapInner(i).children(0), this.scrollElem = this.innerElem.wrap(i).parent(), this.elem.addClass(this.name + "-container"), this.innerElem.addClass(this.name + "-inner"), this.scrollElem.addClass(this.name + "-scroller");
                                var n = t(i);
                                this.scrollBarContainer = t([n, n.clone()]), this.scrollBar = t([n.clone(), n.clone()]), this.scrollBarContainer.each(function(t) {
                                    var e = 0 === t ? "h" : "v",
                                        s = o.options.autoFadeBars ? " autohide" : "";
                                    o.scrollBarContainer[t].addClass(o.name + "-scrollbar-container " + e + s).append(o.scrollBar[t].addClass(o.name + "-scrollbar " + e)), o._addBars(t)
                                }), this.elem.css("overflow", "visible"), this.mx = 0, this.my = 0, this.__tmp__ = {
                                    _diff_x: 0,
                                    _diff_y: 0,
                                    _temp_x: 0,
                                    _temp_y: 0,
                                    _x: 0,
                                    _y: 0,
                                    _mx: 0,
                                    _my: 0,
                                    _deltaX: 0,
                                    _deltaY: 0,
                                    _start: {
                                        x: 0,
                                        y: 0
                                    }
                                }, this.__tmp__._scrolls = !1, this._buildIndex(), this.timer = void 0, this._bind(), this.elem.trigger(this.name + "ready")
                            },
                            reInit: function() {
                                return this._buildIndex()
                            },
                            _addBars: function(t) {
                                this.options.scrollBars && this.scrollBarContainer[t].appendTo(this.elem)
                            },
                            _buildIndex: function() {
                                this.barIndex = {
                                    X: i(this.scrollElem, this.scrollElem, "Width"),
                                    Y: i(this.scrollElem, this.scrollElem, "Height")
                                }, this._getContainerOffset(), this.scrollBar[0].css({
                                    width: this.barIndex.X[1]
                                }), this.scrollBar[1].css({
                                    height: this.barIndex.Y[1]
                                }), this.__tmp__._cdd = {
                                    x: this.options.scrollBars ? this.scrollBarContainer[0].innerWidth() : this.scrollElem.innerWidth(),
                                    y: this.options.scrollBars ? this.scrollBarContainer[1].innerHeight() : this.scrollElem.innerHeight()
                                }, 1 === this.barIndex.X[0] ? this.scrollBarContainer[0].detach() : this._addBars(0), 1 === this.barIndex.Y[0] ? this.scrollBarContainer[1].detach() : this._addBars(1)
                            },
                            _bind: function() {
                                var e = this;
                                s.bind(this.events.RESIZE, t.proxy(this._buildIndex, this)), this.elem.bind("destroyed", t.proxy(this.teardown, this)), this.elem.bind(this.name + "ready", t.proxy(this.onInitReady, this)), this.elem.delegate("." + this.name + "-scrollbar-container", this.events.M_DOWN, t.proxy(this.scrollStart, this)), !1 === this.options.ignoreMouseWheel && this.elem.bind(this.events.M_WHEEL, t.proxy(this.scrollStart, this)), this.scrollElem.bind(this.events.M_DOWN, t.proxy(this.dragScrollStart, this)), this.options.autoFadeBars && this.elem.delegate("." + this.name + "-scrollbar-container", "mouseenter", t.proxy(this.showBars, this)).delegate("." + this.name + "-scrollbar-container", "mouseleave", t.proxy(this.hideBars, this)), this.elem.bind(this.events.S_START, function() {
                                    e.options.onScrollStart.call(e.elem.addClass("scrolls")), e.options.autoFadeBars && e.showBars()
                                }).bind(this.events.S_STOP, function() {
                                    e.options.onScrollEnd.call(e.elem.removeClass("scrolls")), e.options.autoFadeBars && e.hideBars()
                                })
                            },
                            _unbind: function() {
                                this.elem.unbind(this.name + "ready").undelegate("." + this.name + "-scrollbar-container", this.events.M_DOWN).undelegate("." + this.name + "-scrollbar-container", "mouseenter").undelegate("." + this.name + "-scrollbar-container", "mouseleave").unbind(this.events.M_WHEEL).unbind(this.events.S_STOP).unbind(this.events.S_START), this.scrollElem.unbind(this.events.M_DOWN), s.unbind(this.events.M_MOVE).unbind(this.events.M_UP).unbind(this.events.RESIZE)
                            },
                            onInitReady: function() {
                                this.options.autoFadeBars ? this.showBars().hideBars() : this.showBars()
                            },
                            initMouseWheel: function(e) {
                                if (!0 === this.options.ignoreMouseWheel) return !1;
                                "rebind" === e ? this.elem.unbind(this.events.M_WHEEL).bind(this.events.M_WHEEL, t.proxy(this.scrollStart, this)) : this.elem.unbind(this.events.M_WHEEL).bind(this.events.M_WHEEL, t.proxy(this._getMousePosition, this))
                            },
                            _getContainerOffset: function() {
                                this.containerOffset = this.elem.offset()
                            },
                            _pageXY: o.prototype.isTouchDevice ? function(t) {
                                return {
                                    X: t.originalEvent.touches[0].pageX,
                                    Y: t.originalEvent.touches[0].pageY
                                }
                            } : function(t) {
                                return {
                                    X: t.pageX,
                                    Y: t.pageY
                                }
                            },
                            _getScrollOffset: function() {
                                return {
                                    x: this.scrollElem[0].scrollLeft,
                                    y: this.scrollElem[0].scrollTop
                                }
                            },
                            _getMousePosition: function(t, e, s, i) {
                                if (t.preventDefault(), e) s = void 0 !== s ? -s : e, i = void 0 !== i ? i : e, s = Math.min(5, Math.max(s, -5)), i = Math.min(5, Math.max(i, -5)), this.__tmp__._deltaX = s, this.__tmp__._deltaY = i, 0 === s && 0 === i && this.scrollStop();
                                else {
                                    var o = this._pageXY.apply(this, arguments);
                                    this.mx = this.__tmp__._scrollsX ? Math.max(0, Math.min(this.__tmp__._cdd.x, o.X - this.containerOffset.left)) : this.mx, this.my = this.__tmp__._scrollsY ? Math.max(0, Math.min(this.__tmp__._cdd.y, o.Y - this.containerOffset.top)) : this.my
                                }
                            },
                            _getWheelDelta: function() {
                                var t = this.scrollElem.innerHeight(),
                                    e = this.scrollElem.innerWidth();
                                this.mx -= this.mx <= e ? this.__tmp__._deltaX * this.options.mouseWheelVelocity : 0, this.my -= this.my <= t ? this.__tmp__._deltaY * this.options.mouseWheelVelocity : 0, this.mx = Math.min(Math.max(0, this.mx), e), this.my = Math.min(Math.max(0, this.my), t), this.__tmp__._deltaX = null, this.__tmp__._deltaY = null
                            },
                            _getDragScrollPosition: function() {
                                var t, e, s = this.options.smoothness;
                                return this.__tmp__._diff_x = this.__tmp__._diff_x > 0 ? this.__tmp__._diff_x++ - this.__tmp__._diff_x++/s:this.__tmp__._diff_x---this.__tmp__._diff_x--/s, this.__tmp__._diff_y = this.__tmp__._diff_y > 0 ? this.__tmp__._diff_y++ - this.__tmp__._diff_y++/s:this.__tmp__._diff_y---this.__tmp__._diff_y--/s, t = Math.round(Math.max(Math.min(this.scrollElem[0].scrollLeft + this.__tmp__._diff_x, this.scrollElem[0].scrollWidth), 0)), e = Math.round(Math.max(Math.min(this.scrollElem[0].scrollTop + this.__tmp__._diff_y, this.scrollElem[0].scrollHeight), 0)), this.__tmp__._x = t, this.__tmp__._y = e, [this.__tmp__._x, this.__tmp__._y]
                            },
                            _hasScrolledSince: function() {
                                var t = this.scrollElem[0].scrollLeft,
                                    e = this.scrollElem[0].scrollTop;
                                return {
                                    verify: this.__tmp__._temp_x !== t || this.__tmp__._temp_y !== e,
                                    scrollLeft: t,
                                    scrollTop: e
                                }
                            },
                            _getScrollPosition: function(t, e) {
                                var s, i;
                                return s = t * this.barIndex.X[0], i = e * this.barIndex.Y[0], this.__tmp__._x += (s - this.__tmp__._x) / this.options.smoothness, this.__tmp__._y += (i - this.__tmp__._y) / this.options.smoothness, [this.__tmp__._x, this.__tmp__._y]
                            },
                            _getDiff: function() {
                                var t = this.scrollElem[0].scrollTop,
                                    e = this.scrollElem[0].scrollLeft;
                                this.__tmp__._diff_x = e - this.__tmp__._temp_x, this.__tmp__._diff_y = t - this.__tmp__._temp_y, this.__tmp__._temp_x = e, this.__tmp__._temp_y = t
                            },
                            setScrollbar: function() {
                                this.scrollBar[0].css({
                                    left: Math.abs(Math.ceil(this.scrollElem[0].scrollLeft / this.barIndex.X[0]))
                                }), this.scrollBar[1].css({
                                    top: Math.abs(Math.ceil(this.scrollElem[0].scrollTop / this.barIndex.Y[0]))
                                })
                            },
                            scroll: function(t, e) {
                                var s = this.scrollElem[0].scrollLeft,
                                    i = this.scrollElem[0].scrollTop;
                                t = this.__tmp__._scrollsX ? Math.round(t) : s, e = this.__tmp__._scrollsY ? Math.round(e) : i, this.scrollElem.scrollLeft(t).scrollTop(e)
                            },
                            scrollStart: function(e, i) {
                                this.stopScroll();
                                var o = e.target,
                                    n = o === this.scrollBar[0][0],
                                    a = o === this.scrollBar[1][0],
                                    l = o === this.scrollBarContainer[0][0],
                                    r = o === this.scrollBarContainer[1][0];
                                e.preventDefault(), this.scrollElem.unbind(this.events.SCROLL), this.__tmp__._scrollsX = n || l, this.__tmp__._scrollsY = a || r, this._getMousePosition.apply(this, arguments), i ? (this.__tmp__._scrollsX = !0, this.__tmp__._scrollsY = !0, this.__tmp__._mode = "wheel", this.__tmp__._start.x = 0, this.__tmp__._start.y = 0, this._checkDragMXYPos(), this.initMouseWheel()) : (s.bind(this.events.M_MOVE, t.proxy(this._getMousePosition, this)), s.bind(this.events.M_UP, t.proxy(this.scrollStop, this)), this.__tmp__._start.x = n ? this.mx - this.scrollBar[0].offset().left + this.scrollBarContainer[0].offset().left : l ? Math.round(this.scrollBar[0].outerWidth() / 2) : 0, this.__tmp__._start.y = a ? this.my - this.scrollBar[1].offset().top + this.scrollBarContainer[1].offset().top : r ? Math.round(this.scrollBar[1].outerHeight() / 2) : 0, this.__tmp__._mode = "scrollbar"), this.startTimer("scrollBPos"), this.elem.trigger(this.events.S_START)
                            },
                            scrollBPos: function() {
                                var t, e, s;
                                this._getDiff(), "wheel" === this.__tmp__._mode && this._getWheelDelta(), e = Math.min(Math.max(0, this.mx - this.__tmp__._start.x), this.__tmp__._cdd.x - this.barIndex.X[1]), t = Math.min(Math.max(0, this.my - this.__tmp__._start.y), this.__tmp__._cdd.y - this.barIndex.Y[1]), s = this._getScrollPosition(e, t), this.__tmp__._scrollsX && this.scrollBar[0].css({
                                    left: e
                                }), this.__tmp__._scrollsY && this.scrollBar[1].css({
                                    top: t
                                }), this.scroll(s[0], s[1]), this.startTimer("scrollBPos"), "wheel" === this.__tmp__._mode && this.__tmp__._scrolls && !this._hasScrolledSince().verify && this.scrollStop(), this.__tmp__._scrolls || (this.__tmp__._scrolls = !0), this.__tmp__.mx = this.mx, this.__tmp__.my = this.my
                            },
                            scrollStop: function(t) {
                                var e = this._hasScrolledSince();
                                s.unbind(this.events.M_MOVE), s.unbind(this.events.M_UP), e.verify ? this.startTimer("scrollStop") : (this.stopScroll(), this._clearScrollStatus(!1), this.initMouseWheel("rebind"), this.elem.trigger(this.events.S_STOP), this.__tmp__._mx = null, this.__tmp__._my = null, this.__tmp__._start.x = 0, this.__tmp__._start.y = 0), this.__tmp__._temp_x = e.scrollLeft, this.__tmp__._temp_y = e.scrollTop
                            },
                            dragScrollStart: function(e) {
                                this.stopScroll(), e.preventDefault(), this._clearScrollStatus(!0), this._getMousePosition.apply(this, arguments), this.__tmp__._start.x = this.mx + this.scrollElem[0].scrollLeft, this.__tmp__._start.y = this.my + this.scrollElem[0].scrollTop, s.bind(this.events.M_MOVE, t.proxy(this._getMousePosition, this)), s.bind(this.events.M_UP, t.proxy(this._initDragScrollStop, this)), this.scrollElem.bind(this.events.SCROLL, t.proxy(this.setScrollbar, this)), this.startTimer("dragScrollMove"), this.elem.trigger(this.events.S_START)
                            },
                            _checkDragMXYPos: function() {
                                var t = this._getScrollOffset();
                                this.mx = Math.round(t.x / this.barIndex.X[0]), this.my = Math.round(t.y / this.barIndex.Y[0])
                            },
                            dragScrollMove: function() {
                                this.stop = !1;
                                var t = Math.min(Math.max(this.__tmp__._start.x - this.mx, 0), this.scrollElem[0].scrollWidth),
                                    e = Math.min(Math.max(this.__tmp__._start.y - this.my, 0), this.scrollElem[0].scrollHeight),
                                    s = this._getScrollOffset();
                                this._getDiff(), this.scroll(t, e), this.__tmp__.temp_x = s.x, this.__tmp__.temp_y = s.y, this.startTimer("dragScrollMove")
                            },
                            _initDragScrollStop: function() {
                                s.unbind(this.events.M_MOVE), s.unbind(this.events.M_UP), this.elem.removeClass("scrolls"), this.stopScroll(), this.dragScrollStop()
                            },
                            dragScrollStop: function() {
                                var t, e = this._hasScrolledSince();
                                e.verify ? (t = this._getDragScrollPosition(), this.scroll(t[0], t[1]), this.startTimer("dragScrollStop"), this.__tmp__._temp_x = e.scrollLeft, this.__tmp__._temp_y = e.scrollTop) : (this.stopScroll(), this.scrollElem.unbind(this.events.SCROLL), this._clearScrollStatus(!1), this.elem.trigger(this.events.S_STOP))
                            },
                            _clearScrollStatus: function() {
                                var t = arguments,
                                    e = t.length,
                                    s = t[0],
                                    i = t[1],
                                    o = t[2];
                                1 === e && (i = s, o = s), 2 === e && (o = i), this.__tmp__._scrolls = s, this.__tmp__._scrollsX = i, this.__tmp__._scrollsY = o
                            },
                            hideBars: function() {
                                return this.__tmp__._scrolls ? this : (this.scrollBarContainer.each(function() {
                                    this.stop().delay(100).fadeTo(250, 0)
                                }), this)
                            },
                            showBars: function() {
                                return this.scrollBarContainer.each(function() {
                                    parseInt(this.css("opacity"), 10) < 1 && (this.css({
                                        opacity: 0,
                                        display: "block"
                                    }), this.stop().delay(100).fadeTo(250, 1))
                                }), this
                            },
                            startTimer: function(t) {
                                var s = this;
                                this.timer = e.setTimeout(function() {
                                    s[t]()
                                }, 15)
                            },
                            stopScroll: function() {
                                e.clearTimeout(this.timer), this.timer = void 0
                            },
                            teardown: function(e) {
                                var s = 2;
                                for (this.elem.removeClass("scrolls"), this._unbind(), this.elem.unbind("destroyed"); s--;) this.scrollBarContainer[s].empty().remove();
                                t.removeData(this.name)
                            }
                        }), t.fn.dragscroll = function(e) {
                            var s = t.extend({}, {
                                    scrollClassName: "",
                                    scrollBars: !0,
                                    smoothness: 15,
                                    mouseWheelVelocity: 2,
                                    autoFadeBars: !0,
                                    onScrollStart: function() {},
                                    onScrollEnd: function() {},
                                    ignoreMouseWheel: !1
                                }, e),
                                i = this;
                            return this.each(function() {
                                t(this).data(o.prototype.name, new o(i, s))
                            })
                        }
                    }(this.jQuery, this), $(".dragscroll-holder").dragscroll({
                        scrollBars: !0,
                        autoFadeBars: !0,
                        smoothness: 15,
                        mouseWheelVelocity: 2,
                        ignoreMouseWheel: !0
                    })
                }(), window.addEventListener("orientationchange", function() {
                    if ($(".top-panel-auction").length) {
                        var t = $(".top-panel-auction").outerHeight();
                        $(".top-panel-auction .buttons.active").css("top", t), $(".sec-holder-inner .toggle-block").each(function() {
                            $(this).hasClass("expanded") || $(this).find(".opener").trigger("click")
                        }), c()
                    }
                }), $("#color-selectize-2, #custom-color-selectize-2").selectize({
                    valueField: "url",
                    labelField: "name",
                    searchField: "url",
                    create: !1,
                    render: {
                        item: function(t, e) {
                            return '<div><span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' + t.url + '"></i></span><span class="by">' + t.name + "</span></div>"
                        },
                        option: function(t, e) {
                            return '<div><span class="name"><i style="display: inline-block; margin-right: 10px; padding: 6px; background-color:' + t.url + '"></i></span><span class="by">' + t.name + "</span></div>"
                        }
                    }
                }), $(window).scroll(function() {}), $(window).resize(function() {
                    $(window).width() > 736 && $("header .nav").removeAttr("style"), a(), i(), n(), l(), c(), $(".content-blocks-holder").length && autosize($(".content-blocks-holder textarea")), r(), $(".sec-holder-inner .toggle-block").each(function() {
                        $(this).hasClass("expanded") || $(this).find(".opener").trigger("click")
                    })
                }), $(window).scroll(function() {
                    $(window).scrollTop() >= 20 ? $("header").addClass("second") : $("header").removeClass("second")
                }), $(".cmd-auction_details").scroll(function() {
                    $(window).scrollTop() < 20 && $("header").addClass("second")
                }), $(".slider-for").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: !1,
                    fade: !0,
                    asNavFor: ".slider-nav"
                }), $(".slider-nav").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    asNavFor: ".slider-for",
                    dots: !0,
                    centerMode: !0,
                    focusOnSelect: !0,
                    arrows: !1,
                    infinite: !0,
                    adaptiveHeight: !0
                }), $(".slider-car").slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: !0,
                    focusOnSelect: !0,
                    arrows: !1,
                    infinite: !0,
                    adaptiveHeight: !0
                }), $("select").selectize(), TweenMax.to("html", 1, {
                    delay: .1,
                    opacity: 1,
                    ease: Expo.easeOut
                }), $(".module-tab-1").length && ($(".module-tab-1 .tab-index .item").each(function() {
                    if (!$(this).hasClass("active")) {
                        $(this);
                        var t = $(this).index(),
                            e = ($(this).parent().children(), $(this).parent().parent().siblings(".tab-content"), $(this).parent().parent().siblings(".tab-content").children(".tab-item")),
                            i = $(this).parent().parent().siblings(".tab-content").children(".tab-item").eq(t);
                        (new TimelineMax).to(e, .3, {
                            opacity: 1,
                            x: 0,
                            ease: Power3.easeInOut,
                            onCompleteParams: ["{self}"],
                            onComplete: (o(), void s())
                        }).to(i, .3, {
                            opacity: 0,
                            x: 0,
                            ease: Power3.easeInOut
                        })
                    }
                }), o()), Modernizr.addTest("isios", function() {
                    return navigator.userAgent.match(/(iPad|iPhone|iPod)/g)
                }), Modernizr.isios ? (Modernizr.prefixed("ios"), $("body").addClass("ios")) : (Modernizr.prefixed("notios"), $("body").addClass("notios"), -1 != navigator.userAgent.indexOf("Mac OS X") && $("body").addClass("mac"))
        })
    }
};
