$(function () {
    timer();

    var errors = [];
    var conf = {
        onElementValidate: function (valid, $el, $form, errorMess) {
            if (!valid) {
                errors.push({el: $el, error: errorMess});
            }
        }
    };
    var lang = {};

    var netxMinimumBidValue = $("input[name=next_minimum_bid_value]").val();

    $('input[name=bid_price]').on('input', function (evt) {
      var inputValue = evt.target.value;
      var inputValue = parseInt(inputValue.replace(/,/g , ''));

      if (inputValue >= netxMinimumBidValue){
          $(".inp-dollar").addClass('padding-left');
          $('.page-bid-price').addClass('black popup');
          $('.page-bid-price').removeClass('place-bid-grey');
      }else{
          if (isNaN(inputValue)){
              $(".inp-dollar").removeClass('padding-left');
          }else{
              $(".inp-dollar").addClass('padding-left');
          }
          $('.page-bid-price').removeClass('black popup');
          $('.page-bid-price').addClass('place-bid-grey');
      }

      var inputValuePD = inputValue;
        if (inputValuePD > 0){
          $('.dollar-bid').show();
      }else{
          $('.dollar-bid').hide();
      }

    });

    $('input[name=popup_bid_price]').on('input', function (evt) {
      var inputValue = evt.target.value;
      var inputValue = parseInt(inputValue.replace(',', ''));
      if (inputValue >= netxMinimumBidValue){
          $('.popup-place-bid-confirm-step').addClass('green popup');
          $('.popup-place-bid-confirm-step').removeClass('place-bid-grey');
      }else{
          $('.popup-place-bid-confirm-step').removeClass('green popup');
          $('.popup-place-bid-confirm-step').addClass('place-bid-grey');
      }
    });

    $('input[name=mobile_popup_bid_price]').on('input', function (evt) {
        var inputValue = evt.target.value;
        var inputValue = parseInt(inputValue.replace(',', ''));
        if (inputValue >= netxMinimumBidValue){
            $('.mobile-popup-place-bid-btn-2').addClass('green popup');
            $('.mobile-popup-place-bid-btn-2').removeClass('place-bid-grey');
        }else{
            $('.mobile-popup-place-bid-btn-2').removeClass('green popup');
            $('.mobile-popup-place-bid-btn-2').addClass('place-bid-grey');
        }
    });

    $("#place_bid_submit").on("click", function () {
        submitForm();
    });

    function submitForm(){
        errors = [];
        if ($("#place_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#place_bid_form").serialize(),
                success: function (response) {
                    console.log(response);
                    if (response.has_error) {
                        $("input[name=bid_price]").val(0);
                        $("#page_place_bid_form_err").show();
                        $("#page_place_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#page_place_bid_form_err").html(response.cc_status);
                            $("#page_place_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        socket.emit("custom bid",{
                            "auction_id":$("#place_quick_bid_form input[name='auction_id']").val(),
                            "custom_price":$("input[name='bid_price']").val(),
                            "name":$("#rl_buyer_name").val(),
                            "timestamp":$("#rl_buyer_timestamp").val()
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    $(".quick-bid-submit").on("click", function (e) {
      e.preventDefault();
      submitQuickBidForm();
    });

    function submitQuickBidForm(){
        errors = [];
        if ($("#place_quick_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#place_quick_bid_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#place_quick_bid_form_err").show();
                        $("#place_quick_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#place_quick_bid_form_err").html(response.cc_status);
                            $("#place_quick_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        socket.emit("quick bid",{
                            "auction_id":$("#place_quick_bid_form input[name='auction_id']").val(),
                            "name":$("#rl_buyer_name").val(),
                            "timestamp":$("#rl_buyer_timestamp").val()
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    $(".mobile-quick-bid-button").on("click", function (e) {
      e.preventDefault();
        var confirmContent = auctionDetailsConfirmationPopupContent('[name="mobile_quick_bid"]');
        auctionDetailsConfirmationPopup(confirmContent, submitMobileQuickBidForm);
    });

    function submitMobileQuickBidForm(){
        errors = [];
        if ($("#mobile_place_quick_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#mobile_place_quick_bid_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#mobile_place_quick_bid_form_err").show();
                        $("#mobile_place_quick_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#mobile_place_quick_bid_form_err").html(response.cc_status);
                            $("#mobile_place_quick_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    $("#mobile_place_bid_submit").on("click", function () {
        var confirmContent = auctionDetailsConfirmationPopupContent('[name="mobile_bid_price"]');
        auctionDetailsConfirmationPopup(confirmContent, mobileSubmitForm);
        //mobileSubmitForm();
    });

    $("input[name = mobile_bid_price]").on("keydown", function(e) {
        if (e.keyCode === 13) {
            var confirmContent = auctionDetailsConfirmationPopupContent('[name="mobile_bid_price"]');
            auctionDetailsConfirmationPopup(confirmContent, mobileSubmitForm);
            //mobileSubmitForm();
        }
    });

    function mobileSubmitForm(){
        errors = [];
        if ($("#mobile_place_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#mobile_place_bid_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("input[name=mobile_bid_price]").val("");
                        $("#mobile_place_bid_form_err").show();
                        $("#mobile_place_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#mobile_place_bid_form_err").html(response.cc_status);
                            $("#mobile_place_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    var buyNowBtn = $("#buy_now_submit");
    buyNowBtn.on("click", function (e) {
        e.preventDefault();
        var confirmContent = auctionDetailsConfirmationPopupContent('[name="popup_buy_now_for_price"]');
        auctionDetailsConfirmationPopup(confirmContent, buyNowSubmit);
    });

    function buyNowSubmit(){
        if (buyNowBtn.hasClass("in_progress")) {
            return;
        }
        errors = [];
        if ($("#buy_now_form").valid(lang, conf, true)) {
            buyNowBtn.addClass("in_progress");
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/buy-now/?code="+ $('#code_discount').val(),
                data: $("#buy_now_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        if (response.status != "") {
                            $("#buy_now_form_err").html(response.status);
                            $("#buy_now_form_err").show();
                            buyNowBtn.removeClass("in_progress");
                        }
                        alert(response.status);
                    }
                    else {
                        socket.emit("has bid data for seller",{
                            "auction_id":$("#place_quick_bid_form input[name='auction_id']").val(),
                            "name":"",
                            "timestamp":"",
                            "buy_now":1
                        });
                        window.location = response.redirect;
                    }
                }
            });
        }
        return false;
    }

    $("#popup-cancel").on("click", function () {
        if (!$('.popup-box').hasClass('active')) {
            $('.popup-box').addClass('active');
        }
    });
    $("#cancel-popup-box .second-btn").on("click", function (e) {
        e.preventDefault();
        if ($('.popup-box').hasClass('active')) {
            $('.popup-box').removeClass('active');
        }
    });

    $("#popup-cancel-yes").on("click", function (e) {
        e.preventDefault();
        errors = [];
        if ($("#cancel-auction-form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/cancel-auction/",
                data: $("#cancel-auction-form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#cancel-auction-err").show();
                        $("#cancel-auction-err").html(response.status);
                    }
                    else {
                        location.reload();
                    }
                }
            });
        }
    });

    $('#next-prev-arrow .prev-slide').click(function () {
        $(".slider-car").slick('slickPrev');
    });

    $('#next-prev-arrow .next-slide').click(function () {
        $(".slider-car").slick('slickNext');
    });

    $(document).on('click','.link-box.popup[data-number=1]', function() {
        $('.popup-box-1').show();
        $('.popup-box-1.active').removeAttr("style");
    });

    $('.popup-place-bid-confirm-step').click(function () {
        var popupPlaceBidCurrentVal = $('#txt2').val();
        if (popupPlaceBidCurrentVal == "") {
            popupPlaceBidVal = "0";
        } else {
            popupPlaceBidVal = popupPlaceBidCurrentVal;
        }
        $('#popup-place-bid-value').text("$" + popupPlaceBidVal);
        $('#popup_place_bid_form_err').text("");
    });

    $("#mobile-popup-cancel-yes").on("click", function (e) {
        e.preventDefault();
        errors = [];
        if ($("#mobile-cancel-auction-form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/cancel-auction/",
                data: $("#mobile-cancel-auction-form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#mobile-cancel-auction-err").show();
                        $("#mobile-cancel-auction-err").html(response.status);
                    }
                    else {
                        location.reload();
                    }
                }
            });
        }
    });

    $('.popup-place-bid-submit').click(function () {
        popupSubmitPlaceBidForm();
    });

    $('.prew-popup').click(function () {
        $('.popup-box-2').hide();
        $('.popup-box-2').removeClass("active");
        $('.popup-box-1').show();
    });

    function popupSubmitPlaceBidForm(){
        errors = [];
        if ($("#popup_place_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#popup_place_bid_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#popup_place_bid_form_err").show();
                        $("#popup_place_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#popup_place_bid_form_err").html(response.cc_status);
                            $("#popup_place_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    $('.submit-popup-buy-now').click(function () {
        popupBuyNowSubmit();
    });

    function popupBuyNowSubmit(){
        errors = [];
        if ($("#popup_buy_now_form").valid(lang, conf, true)) {
            //buyNowBtn.addClass("in_progress");
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/buy-now/?code="+ $('#code_discount').val(),
                data: $("#popup_buy_now_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        if (response.status != "") {
                            $("#popup_buy_now_form_err").html(response.status);
                            $("#popup_buy_now_form_err").show();
                        }

                        alert(response.status);
                    }
                    else {
                        socket.emit("has bid data for seller",{
                            "auction_id":$("#place_quick_bid_form input[name='auction_id']").val(),
                            "name":"",
                            "timestamp":"",
                            "buy_now":1
                        });
                        window.location = response.redirect;
                    }
                }
            });
        }
        return false;
    }

    function mobilePopupBuyNowSubmit(){
        errors = [];
        if ($("#popup_buy_now_form").valid(lang, conf, true)) {
            //buyNowBtn.addClass("in_progress");
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/buy-now/?code="+ $('#code_discount').val(),
                data: $("#popup_buy_now_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        if (response.status != "") {
                            $("#popup_buy_now_form_err").html(response.status);
                            $("#popup_buy_now_form_err").show();
                        }

                        alert(response.status);
                    }
                    else {
                        window.location = response.redirect;
                    }
                }
            });
        }
        return false;
    }

    $(document).on('click','.mobile-popup-place-bid-btn-2', function() {
        var mobilePopupBidPriceValue = $('[name="mobile_popup_bid_price"]').val();
        $('#mobile-popup-place-bid-value').text('$' + mobilePopupBidPriceValue);
    });

    $(document).on('click','.mobile-place-bid-close-it', function() {
      $('[name="mobile_popup_bid_price"]').val('');
      $('.mobile-popup-place-bid-btn-2').removeClass('green popup');
      $('.mobile-popup-place-bid-btn-2').addClass('place-bid-grey');
    });

    $(document).on('click','.mobile-popup-place-bid-submit', function() {
        mobilePopupSubmitPlaceBidForm();
    });

    $(document).on('click','.mobile-fixed-panel .btn.open-mob-bid-input', function() {
      $('[name="mobile_popup_bid_price"]').val(0);
    });

    $(document).on('click','.con .btn-2.black.close-it', function() {
      $('#mobile_popup_place_bid_form_err').hide();
      $('[name="mobile_popup_bid_price"]').val(0);
    });

    function mobilePopupSubmitPlaceBidForm(){
        errors = [];
        if ($("#mobile_popup_place_bid_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/place-bid/",
                data: $("#mobile_popup_place_bid_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        $("#mobile_popup_place_bid_form_err").show();
                        $("#mobile_popup_place_bid_form_err").html(response.status);
                        if (response.cc_status != "") {
                            $("#mobile_popup_place_bid_form_err").html(response.cc_status);
                            $("#mobile_popup_place_bid_form_err").show();
                        }
                    }
                    else {
                        $('.anim.lds-ring').show();
                        showUpcomingMessage(response.message_info);
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                }
            });
        }
    }

    $(".submit-mobile-popup-buy-now").on("click", function () {
        var confirmContent = auctionDetailsConfirmationPopupContent('[name="mobile_buy_now_for_price"]');
        auctionDetailsConfirmationPopup(confirmContent, mobilePopupBuyNowSubmit);
    });

    function mobilePopupBuyNowSubmit(){
        errors = [];
        if ($("#mobile_popup_buy_now_form").valid(lang, conf, true)) {
            $.ajax({
                type: "POST",
                url: "/ajax/auctions/buy-now/?code="+ $('#code_discount').val(),
                data: $("#mobile_popup_buy_now_form").serialize(),
                success: function (response) {
                    if (response.has_error) {
                        if (response.status != "") {
                            $("#mobile_popup_buy_now_form_err").html(response.status);
                            $("#mobile_popup_buy_now_form_err").show();
                        }

                        alert(response.status);
                    }
                    else {
                        window.location = response.redirect;
                    }
                }
            });
        }
        return false;
    }

    $(document).on('click','#close-mobile-popup-cancel', function() {
        if ($(".input-bid-mob-box").hasClass('active')) {
            $(".input-bid-mob-box").removeClass('active');
        }
    });

    $(document).on('click','[name="mobile_popup_bid_price"]', function() {
      $('[name="mobile_popup_bid_price"]').removeAttr('placeholder');
      $('[name="mobile_popup_bid_price"]').val('');
    });

    $("#place-bid-dealer-only-auction").on("click", function () {
        $("#place-bid-dealer-only-auction-err").addClass("active");
        $("#place-bid-dealer-only-auction-err").show();
    });

    $("#mobile-place-bid-dealer-only-auction").on("click", function () {
        $("#mobile-place-bid-dealer-only-auction-err").addClass("active");
        $("#mobile-place-bid-dealer-only-auction-err").show();
    });

    $(".cmd-auctions_details .sec-1, .cmd-auctions_details .sec-2").on("click", function () {
        if ($("#place-bid-dealer-only-auction-err").hasClass("active")){
            $("#place-bid-dealer-only-auction-err").removeClass("active");
            $("#place-bid-dealer-only-auction-err").hide();
        }
        if ($("#mobile-place-bid-dealer-only-auction-err").hasClass("active")){
            $("#mobile-place-bid-dealer-only-auction-err").removeClass("active");
            $("#mobile-place-bid-dealer-only-auction-err").hide();
        }
    });

    $(".page-bid-price").on("click", function () {
        var pageBidPrice = $('input[name = bid_price]').val();
        $('#page-place-bid-value-text').attr("style","min-width: 50px;font-size: 4rem; color: #0650cb;    width:"+((pageBidPrice.length+1)*28)+"px");
        if (pageBidPrice != ""){
            $("#page-place-bid-value-text").val(pageBidPrice);
        } else {
            $("#page-place-bid-value-text").val("");
        }
    });

    $("#page-place-bid-value-text").on("keyup", function () {
        $('input[name = bid_price]').val($(this).val());
        console.log($(this).val().length*30+30);
        $('#page-place-bid-value-text').attr("style","min-width: 50px;font-size: 4rem; color: #0650cb;width:"+(($(this).val().length+1)*28)+"px");
    });

    $(".page-bid-price2").on("click", function () {
        var pageBidPrice = $('input[name = bid_price]').val();
        $('#page-place-bid-value-text').attr("style","min-width: 50px;font-size: 4rem; color: #0650cb;    width:"+((pageBidPrice.length+1)*28)+"px");
        if (pageBidPrice != ""){
            $("#page-place-bid-value-text").val(pageBidPrice);
        } else {
            $("#page-place-bid-value-text").val("");
        }
    });

    $(".close-place-bid-submit, .close").on("click", function () {
        $('#page_place_bid_form_err').text("");
        $('input[name = popup_bid_price]').val("");
        if ($('input[name = bid_price]').val() >= netxMinimumBidValue ){
            $('.popup-place-bid-confirm-step').addClass('green popup');
            $('.popup-place-bid-confirm-step').removeClass('place-bid-grey');
        }else{
            $('.popup-place-bid-confirm-step').removeClass('green popup');
            $('.popup-place-bid-confirm-step').addClass('place-bid-grey');
        }
    });

    $('input.custom-number').keyup(function(event) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
});

function auctionDetailsConfirmationPopup(content, callback){
    var popup = $('#popup-auction-bid-buy');
    if(content.hasOwnProperty("title")) $('.insert-title', popup).html(content.title);
    if(content.hasOwnProperty("text")) $('.insert-content', popup).html(content.text);
    popup.addClass('active');
    $('.close, .close-it', popup).on('click', function(){
        if (popup.hasClass('active')) {
            popup.removeClass('active');
        }
    });
    if(typeof callback == 'function'){
        $('.confirm-it', popup).on('click', function(){
            if (popup.hasClass('active')) {
                popup.removeClass('active');
            }
            callback();
        });
    }
}

function auctionDetailsConfirmationPopupContent(input){
    var amount = $(input).val();
    var result = {};
    if(amount){
        if($(input).closest('#place_bid_form').length || $(input).closest('#mobile_place_bid_form').length){
            result.title = 'New Bid';
            result.text = 'You are submitting a bid of $'+amount+'. Are you sure?';
        }
        else if($(input).closest('#buy_now_form').length){
            result.title = 'Buy Now';
            result.text = 'You are submitting a bid to purchase this car for $'+amount+'. Are you sure?';
        }
        else if($(input).closest('#place_quick_bid_form').length){
            result.title = 'Quick Bid';
            result.text = 'You are submitting a bid to purchase this car for $'+amount+'. Are you sure?';
        }
        else if($(input).closest('#mobile_place_quick_bid_form').length){
            result.title = 'Quick Bid';
            result.text = 'You are submitting a bid to purchase this car for $'+amount+'. Are you sure?';
        }
        else if($(input).closest('#mobile_popup_place_bid_form').length){
            result.title = 'New Bid';
            result.text = 'You are submitting a bid of $'+amount+'. Are you sure?';
        }
        else if($(input).closest('#mobile_popup_buy_now_form').length){
            result.title = 'Buy Now';
            result.text = 'You are submitting a bid to purchase this car for $'+amount+'. Are you sure?';
        }
    }
    return result;
}

function timer() {
    $('.timer').each(function () {
        if ($(this).data('started') !== 'started') {
            if ($(this).data("format") == "date") {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'd%d, h%h',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        $(".det").attr("style","color : "+color);
                        timer.target.css('color', color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    }
                });
            } else if ($(this).data('left') > 86399) {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'd%d, h%h',
                    on_tick: function (timer) {
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        $(".det").attr("style","color : "+color);
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
                        $(".det").attr("style","color : "+color);
                        $(timer.target)[0].setAttribute('data-started', "started");
                    }
                });
            } else {
                $(this).backward_timer({
                    seconds: $(this).data('left'),
                    format: 'm%:s%',
                    on_tick: function (timer) {
                        if(timer.seconds_left == 0){
                            window.location.href = window.location.pathname + window.location.search + window.location.hash;
                        }
                        var color = ((timer.seconds_left < 60 * 60) == 0) ? "#53c00b" : "red";
                        $(".det").attr("style","color : "+color);
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

$(document).ready(function () {
    var id = $('input[name=auction_id]').val();
    var user_id = $('input[name=user_id]').val();
    $.ajax({
        url: 'http://bidtodrive.kennjdemo.com/auctions/get-uship-html',
        type: 'GET',
        data: {
            'id' : id,
            'user_id' : user_id
        },
        success: function (resp) {
            $('#uship-content').html(resp);
        }
    });

    $('div#quick_bid_top').click(function () {
        $('.quick-bid-button').click();
    });

});
function cancleAuction (id) {
    var result = confirm(" Would you like to cancel this auction?");
    if (result == true) {
      $.ajax({
          type: "POST",
          url: "/ajax/auctions/cancel-auction",
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
