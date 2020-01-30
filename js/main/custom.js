$( document ).ready(function() {
    var flag_search =0;
    $("#search_top_custom").on("click",function(){
        $("#form_search_top").toggleClass("active_search");
        if(flag_search == 0){
            $("#search_top_custom").html("<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Gnome-window-close.svg/512px-Gnome-window-close.svg.png' />");
            flag_search = 1;
        }else{
            $("#search_top_custom").html('<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve"><path d="M76.6,136.6c-11.7,43.7-5.7,89.4,16.9,128.6C123.6,317.5,179.7,350,240,350c22.7,0,45.3-4.7,66.2-13.6L394.1,489l35.1-20.3L341.3,316c30.2-22.6,51.9-54.5,61.8-91.6c11.7-43.7,5.7-89.4-16.9-128.6C356.1,43.5,300,11,239.7,11c-29.5,0-58.7,7.9-84.4,22.7C116.3,56.4,88.3,92.9,76.6,136.6z M239.7,51.7c45.8,0,88.5,24.7,111.4,64.4c17.2,29.8,21.7,64.5,12.8,97.7c-8.9,33.2-30.1,61-59.8,78.2c-19.5,11.3-41.7,17.3-64.1,17.3c-45.8,0-88.5-24.7-111.4-64.4c-17.2-29.8-21.7-64.5-12.8-97.7c8.9-33.2,30.1-61,59.8-78.2C195.2,57.6,217.3,51.7,239.7,51.7z"></path></svg>');
            flag_search = 0;
        }
    });
    $(".open-detail").on("click",function(){
        $('#'+$(this).attr("rel")).attr("style","display:flex");
    });
    $(".table-view-all .close").on("click",function(){
        $('.table-view-all').attr("style","display:none");
    });
    $('#form_search_top').each(function() {
        $(this).find('input').keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                this.form.submit();
            }
        });

        $(this).find('input[type=submit]').hide();
    });
});
function close_popup_view_buyer(){
    $('.table-view-all').attr("style","display:none");
}
function acceptAuction(id , price) {
    var result = confirm(" You agree to sell this product at the highest bid: "+price);
    if (result == true) {
      $.ajax({
          type: "POST",
          url: "/ajax/auctions/accept/",
          data: {auction_id:id},
          success: function (a) {
              // console.log(a);
              if(a.code == 0){
                alert(a.status);
                location.reload();
              }else{
                alert(a.status);
              }
          }
      });
    }
}
function showBuyer(id) {
    $('#view-buyer-'+id).attr("style","display:flex");
}
function svgIconInject() {
    $("img.svg-icon-inject").each(function () {
        var t = $(this), e = t.attr("id"), a = t.attr("class"), s = t.attr("src");
        $.get(s, function (s) {
            var i = $(s).find("svg");
            void 0 !== e && (i = i.attr("id", e)), void 0 !== a && (i = i.attr("class", a + " replaced-svg")), i = i.removeAttr("xmlns:a"), t.replaceWith(i)
        }, "xml")
    })
}

function showErrorMessage(t) {
    var e = "";
    e += '<div class="io-text">', e += '   <div class="holder">', e += '       <div class="label">', e += '           <span class="icon">', e += '               <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta>\x3c!--?xpacket end="w"?--\x3e</metadata><defs><style>.cls-1 {fill-rule: evenodd;}</style></defs><path class="cls-1" d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z" transform="translate(-1404 -748)"></path></svg>', e += "           </span>", e += '           <span class="alert-text">', e += "               <span>warning</span>", e += "           </span>", e += "       </div>", e += '       <div class="msg">', e += "           <p><span>" + t + "</span></p>", e += "       </div>", e += "   </div>", e += "</div>", $.iaoAlert({
        msg: e,
        type: "error",
        autoHide: !1,
        position: "bottom-right",
        fadeOnHover: !1,
        mode: "dark"
    })
}

function showSuccessMessage(t, e) {
    var a = "";
    a += '<div class="io-text">', a += '   <div class="holder">', a += '       <div class="label">', a += '           <span class="icon">', a += '               <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta>\x3c!--?xpacket end="w"?--\x3e</metadata><defs><style>.cls-1 {fill-rule: evenodd;}</style></defs><path class="cls-1" d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z" transform="translate(-1404 -748)"></path></svg>', a += "           </span>", a += '           <span class="alert-text">', a += "               <span>Success</span>", a += "           </span>", a += "       </div>", a += '       <div class="msg">', a += "           <p><span>" + t + "</span></p>", a += "       </div>", a += "   </div>", a += "</div>", $.iaoAlert({
        msg: a,
        type: "success",
        autoHide: !1,
        position: "bottom-right",
        fadeOnHover: !1,
        mode: "dark"
    })
}

function showUpcomingMessage(t) {
    var e = "";
    e += '<div class="io-text">', e += '   <div class="holder">', e += '       <div class="label">', e += '           <span class="icon">', e += '               <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta>\x3c!--?xpacket end="w"?--\x3e</metadata><defs><style>.cls-1 { fill-rule: evenodd; }</style></defs><path class="cls-1" d="M1419.5,685a0.909,0.909,0,1,0,0,1.817,13.854,13.854,0,1,1-9.5,3.935v1.577a0.905,0.905,0,1,0,1.81,0V688.7a0.911,0.911,0,0,0-.91-0.909h-3.66a0.906,0.906,0,1,0,0,1.812h1.33A15.438,15.438,0,1,0,1419.5,685Zm0,5.512a10,10,0,1,0,9.99,10A10,10,0,0,0,1419.5,690.512Zm6.38,15.1-0.6-.6a0.907,0.907,0,1,0-1.28,1.284l0.6,0.6a8.159,8.159,0,0,1-4.19,1.741v-0.858a0.91,0.91,0,0,0-1.82,0v0.858a8.159,8.159,0,0,1-4.19-1.741l0.6-.6a0.907,0.907,0,1,0-1.28-1.284l-0.6.6a8.107,8.107,0,0,1-1.74-4.192h0.85a0.909,0.909,0,1,0,0-1.818h-0.85a8.107,8.107,0,0,1,1.74-4.192l0.6,0.6a0.907,0.907,0,1,0,1.28-1.285l-0.6-.6a8.159,8.159,0,0,1,4.19-1.741v0.858a0.91,0.91,0,0,0,1.82,0V692.38a8.159,8.159,0,0,1,4.19,1.741l-0.6.6a0.907,0.907,0,1,0,1.28,1.285l0.6-.6a8.107,8.107,0,0,1,1.74,4.192h-0.85a0.906,0.906,0,1,0,0,1.812h0.85A8.127,8.127,0,0,1,1425.88,705.608Zm-3.92-3.926-1.55-1.551v-3.258a0.91,0.91,0,0,0-1.82,0v3.634a0.916,0.916,0,0,0,.27.643l1.81,1.817A0.91,0.91,0,0,0,1421.96,701.682Z" transform="translate(-1404 -685)"></path></svg>', e += "           </span>", e += "       </div>", e += '       <div class="msg">', e += "           <p><span>" + t + "</span></p>", e += "       </div>", e += "   </div>", e += "</div>", $.iaoAlert({
        msg: e,
        type: "notification",
        autoHide: !1,
        position: "bottom-right",
        fadeOnHover: !1,
        mode: "dark"
    })
}

function timer() {
    $(".notification-timer").each(function () {
        "started" !== $(this).data("started") && ("date" == $(this).data("format") ? $(this).backward_timer({
            seconds: $(this).data("left"),
            format: "d% days",
            on_tick: function (t) {
                t.target.css("color", "#ffffff"), $(t.target)[0].setAttribute("data-started", "started")
            }
        }) : $(this).backward_timer({
            seconds: $(this).data("left"), on_tick: function (t) {
                t.target.css("color", "#ffffff"), $(t.target)[0].setAttribute("data-started", "started")
            }
        }))
    }), $(".notification-timer").backward_timer("start")
}

function allowLeave() {
    window.onbeforeunload = null
}

function denyLeave(t) {
    window.onbeforeunload = function () {
        return "Your " + t + " is still uploading!"
    }
}

function moneyFormat(t, e, a, s, i) {
    t = t || 0, e = isNaN(e = Math.abs(e)) ? 2 : e, a = void 0 !== a ? a : "", s = s || ",", i = i || ".";
    var o = t < 0 ? "-" : "", r = parseInt(t = Math.abs(t || 0).toFixed(e), 10) + "",
        n = (n = r.length) > 3 ? n % 3 : 0;
    return i += Math.abs(t - r).toFixed(e).slice(2), a + o + (n ? r.substr(0, n) + s : "") + r.substr(n).replace(/(\d{3})(?=\d)/g, "$1" + s) + (e && ".00" != i ? i : "")
}

function buyNowSubmitForm(t) {
    if (void 0 !== t) {
        var e = $(".buy_now_submit", t);
        if (e.hasClass("in_progress")) return;

        e.addClass("in_progress"), $.ajax({
            type: "POST",
            url: "/ajax/auctions/buy-now/?code="+ $('#code_discount').val(),
            data: t.serialize(),
            success: function (a) {
                $('#code_discount').val('');
                // console.log(a);
                if (a.has_error) {
                    if ("" != a.status) {
                        var s = $(".buy_now_form_err", t);
                        s.html(a.status), s.show(), e.removeClass("in_progress");
                    }
                } else {
                    socket.emit("quick bid",{
                        "auction_id":$("#place_quick_bid_form input[name='auction_id']").val(),
                        "name":$("#rl_buyer_name").val(),
                        "timestamp":$("#rl_buyer_timestamp").val()
                    });
                    window.location = a.redirect;
                }

            }
        })
    }
    return !1
}

function auctionsConfirmationPopup(t, e) {
    var a = $("#popup-auction-bid-buy");
    t.hasOwnProperty("title") && $(".insert-title", a).html(t.title), t.hasOwnProperty("text") && $(".insert-content", a).html(t.text), a.addClass("active"), $(".close, .close-it", a).on("click", function () {
        a.hasClass("active") && a.removeClass("active")
    }), "function" == typeof e && $(".confirm-it", a).on("click", function () {
        a.hasClass("active") && a.removeClass("active"), e()
    })
}

function auctionsConfirmationPopupContent(t) {
    var e = $(t).val(), a = {};
    return e && ($(t).closest(".place_bid_form").length || $(t).closest(".mobile_place_bid_form").length ? (a.title = "New Bid", a.text = "You are submitting a bid of $" + e + ". Are you sure?") : $(t).closest(".buy_now_form").length ? (a.title = "Buy Now", a.text = "You are submitting a bid to purchase this car for $" + e + ". Are you sure?") : $(t).closest(".place_quick_bid_form").length ? (a.title = "Quick Bid", a.text = "You are submitting a bid to purchase this car for $" + e + ". Are you sure?") : $(t).closest(".mobile_place_quick_bid_form").length && (a.title = "Quick Bid", a.text = "You are submitting a bid to purchase this car for $" + e + ". Are you sure?")), a
}

function guid() {
    function t() {
        return Math.floor(65536 * (1 + Math.random())).toString(16).substring(1)
    }

    return t() + t() + "-" + t() + "-" + t() + "-" + t() + "-" + t() + t() + t()
}

$(function () {
    $(".popverify").length && $(".popverify .close").click(function (t) {
        t.preventDefault(), $(".popverify .popup-box").slideUp(500, function () {
            $(".popverify").remove()
        })
    });
    var t = !1, e = $("#footer-contact-form-wrap"), a = $("#footer-contact-form"), s = $("#footer-contact-form-thank");

    function i(t) {
        return $('[name="' + t + '"]', a).val()
    }

    a.submit(function (o) {
        var r = !1;
        if (o.preventDefault(), !t) {
            if (i("name") ? "" != i("name") && (r = !1, $(".block-2-name").addClass("pass"), $(".block-2-name").removeClass("error")) : (r = !0, $(".block-2-name").addClass("error")), i("email") && i("email").match(/^.+\@.+\..{2,}$/) ? "" != i("email") && (r = !1, $(".block-2-email").addClass("pass"), $(".block-2-email").removeClass("error")) : (r = !0, $(".block-2-email").addClass("error")), i("message") ? "" != i("message") && (r = !1, $(".block-1-message").addClass("pass"), $(".block-1-message").removeClass("error")) : (r = !0, $(".block-1-message").addClass("error")), r) return !1;
            t = !0, $.ajax("ajax/contact/", {
                type: "post",
                dataType: "json",
                data: a.serialize(),
                success: function (t) {
                    t.status ? (e.hide(), s.show(), a.find(".error.name").text("")) : a.find(".error.name").text(t.message)
                },
                complete: function () {
                    t = !1
                }
            })
        }
    }), $(document).on("click", ".star", function (t) {
        t.preventDefault(), elm = $(this), auctionID = $(this).closest(".item").data("auction-id"), elm.hasClass("active") ? $.post("/ajax/account/favorites/", {
            rec_id: elm.attr("record-id"),
            action: "remove"
        }, function (t) {
            t && ("Success" == (t = JSON.parse(t)).status && (elm.removeClass("active"), $(".buyer-watched-listing .auction-id-" + auctionID).hide(), "auctions_details" == pageCMD && (window.location = window.location)))
        }) : $.post("/ajax/account/favorites/", {rec_id: elm.attr("record-id"), action: "add"}, function (t) {
            t && ("Success" == (t = JSON.parse(t)).status && (elm.addClass("active"), "auctions_details" == pageCMD && (window.location = window.location)))
        })
    }), $(".star-seller, .buyer-star-seller").on("click", function (t) {
        t.preventDefault(), elm = $(this), elm.hasClass("active") ? $.post("/ajax/account/seller-favorites/", {
            seller_id: elm.attr("record-id"),
            action: "remove"
        }, function (t) {
            t && ("Success" == (t = JSON.parse(t)).status && (elm.removeClass("active"), location.reload()))
        }) : $.post("/ajax/account/seller-favorites/", {seller_id: elm.attr("record-id"), action: "add"}, function (t) {
            t && ("Success" == (t = JSON.parse(t)).status && elm.addClass("active"))
        })
    }), $(".io-text").click(function () {
        $(".io-text").hide()
    }), $("iao-alert-close").click(function () {
        $(".io-text").hide()
    }), $(".ul-bill-car").slickLightbox({itemSelector: ".li-bill-car a"}), $(".swipebox").on("click", function (t) {
        t.preventDefault();
        var e = $(this).closest(".slick-slide").data("slick-index") || 0;
        $.swipebox(swipeboxItems, {
            initialIndexOnArray: e, hideBarsDelay: 0, afterOpen: function () {
                var t = $("#swipebox-close");
                t.unbind("touchend click"), t.bind("touchend click", function (t) {
                    t.preventDefault(), t.stopPropagation(), $.swipebox.close()
                })
            }
        })
    }), $("body").hasClass("Seller") && $("body").hasClass("cmd-auctions_details") && $("body").hasClass("t1") && $("body").removeClass("t1").removeClass("full-height")
}), timer(), svgIconInject(), $(function () {
    $("#ut_admin, #ut_user").click(function () {
        var t = $(this).val();
        $.cookie("user_type", t, {
            expires: 7,
            path: "/"
        }), "user" == t ? ($("#users_select").show(), $("#college_users").autocomplete({
            minLength: 2,
            source: "/ajax/users-switcher/?action=get_users",
            select: function (t, e) {
                $.cookie("cc_user_id", e.item.id, {
                    expires: 7,
                    path: "/"
                }), $("#view_as_user").show().html("Viewing as: <b>" + e.item.label + "</b>")
            }
        })) : ($.cookie("cc_user_id", 0, {expires: 7, path: "/"}), $.cookie("user_type", "admin", {
            expires: 7,
            path: "/"
        }), $("#users_select").hide(), $("#view_as_user").hide().html("")), window.location.reload()
    }), $("#college_users").autocomplete({
        minLength: 2,
        source: "/ajax/users-switcher/?action=get_users",
        select: function (t, e) {
            $.cookie("cc_user_id", e.item.id, {
                expires: 7,
                path: "/"
            }), $("#view_as_user").show().html("<b>" + e.item.label + "</b>"), window.location.reload()
        }
    }), $.getJSON("/ajax/users-switcher/", function (t) {
        $("#view-as-bar").length && ("user" == t.user_type && ($("#ut_user").attr("checked", "checked"), $("#users_select").show()), "" != t.user_name && $("#view_as_user").show().text(t.user_name))
    })
}), $("#print-btn").click(function () {
    window.print()
}), $(function () {
    var t = $(".buy_now_submit");
    t.length && t.each(function () {
        var t = $(this), e = t.closest(".buy_now_form"), a = t.closest("[data-auction-id]").data("auction-id");
        e.length && a > 0 && t.on("click", function (t) {
            t.preventDefault(), auctionsConfirmationPopup(auctionsConfirmationPopupContent('[data-auction-id="' + a + '"] [name="buy_now_for_price"]'), function () {
                buyNowSubmitForm(e)
            })
        })
    })
}), $(".uship-apply-btn").click(function () {
    alert("Confirmed delivery method.")
}), $("form#switch_account_seller").submit(function () {
    alert("Submitted successfully!")
});
