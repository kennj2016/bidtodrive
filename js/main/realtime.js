var socket = io('http://bidtodrive.kennjdemo.com:5979');
socket.on('connect', function () {
    socket.on('has quick bid',function(data){
        var auction_id = $("#place_quick_bid_form input[name='auction_id']").val();
            if(auction_id === data.auction_id) {
                var quickForm = "#place_quick_bid_form";
                var price = $(quickForm + " .quick-bid-button .inner .det").text();
                var old_price = price;
                price = price.replace('$','',price);
                var _price = price.replace(',','',price);
                price = (Number(_price) + Number(50)).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                var nextPrice = Number(_price) + Number(50);
                nextPrice = nextPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                // set data
                $(quickForm + " input[name='quick_bid']").val();
                // change color your bid of first step
                $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .inner div").removeClass("red");
                $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .inner div").addClass('green');
                $(".auction-detail .module-intro-box .grid-options .value.red").text("$" + nextPrice);
                // $(".grid-options .mob-i-1 .inner .value.green").text("$" + price);
                var countBid = $(".grid-options .item.i-5-1.mob-i-2 .inner .value.blue").html();
                $(".grid-options .item.i-5-1.mob-i-2 .inner .value.blue").html(Number(countBid) + Number(1));
                // quick bid title popup
                //$("h1.price-title").html("$" + price);
                // your bid
                // $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .inner div").text("$" + _price);
                // change color your bid of first step
                $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .inner div").removeClass("green");
                $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .inner div").addClass('red');
                $(".auction-detail .module-intro-box .text.grid-options > div:nth-child(1) .top-sign ").remove();
                $(".buttons .input-holder-box .buttons-box .btn.blue .describe strong").text("$" + _price);

                // bid form
                $("#place_bid_form input[name='bid_price']").attr('placeholder',"Enter $" + price + " or more");
                $(quickForm + " input[name='quick_bid']").val(nextPrice);
                $(quickForm + " .quick-bid-button .inner .det").html("$" + price);
                socket.emit("has bid data for seller",{
                    "name":$("#rl_buyer_name").val(),
                    "timestamp":$("#rl_buyer_timestamp").val(),
                    "price":old_price,
                    "countBid":Number(countBid) + Number(1)
                });
            }
    });
    socket.on('has custom bid',function(data){
        var auction_id = $("#place_quick_bid_form input[name='auction_id']").val();
        if(auction_id === data.auction_id) {
            var quickForm = "#place_quick_bid_form";
            var price = data.custom_price;
            var old_price = data.custom_price
            _price = price.replace(',','',price);
            /**
             * Off button buy now
             * if bid more than reverse price will off buy now button
             */
            price = (Number(_price) + Number(50)).toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            var nextPrice = Number(_price) + Number(50);
            nextPrice = nextPrice.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            // set data
            $(quickForm + " input[name='quick_bid']").val();
            $(".grid-options .mob-i-2 .inner .value.green").text("$" + nextPrice);
            //$(".grid-options .mob-i-1 .inner .value.green").text("$" + price);
            var countBid = $(".grid-options .item.i-5-1.mob-i-2 .inner .value.blue").html();
            $(".grid-options .item.i-5-1.mob-i-2 .inner .value.blue").html(Number(countBid) + Number(1));
            // quick bid title popup
            $("h1.price-title").html("$" + price);
            // bid form
            $("#place_bid_form input[name='bid_price']").attr('placeholder',"Enter  $" + price + " or more");
            $(quickForm + " .quick-bid-button .inner .det").html("$" + price);
            socket.emit("has bid data for seller",{
                "name":$("#rl_buyer_name").val(),
                "timestamp":$("#rl_buyer_timestamp").val(),
                "price":old_price,
                "countBid":Number(countBid) + Number(1)
            });
        }
    });
    socket.on('data for seller',function(data){
        console.log(data);
        /**
         * Check seller or buyer
         */
        var type_account = $("#rl_is_seller").val();
        if(type_account === '1') {
            if(data.buy_now) {
                window.location.reload();
            } else {
                realtime_make_html_seller(data);
            }
        } else {
            window.location.reload();
            var reserve_price = $("#auction_detail_reverse_price").val();
            var price = data.price.replace(',','').replace('$','');
            if(Number(price) >= Number(reserve_price)) {
                $("#buy_now_submit").attr('style','visibility: hidden;');
            }
        }
    });
});

/**
 * Make html for realtime seller
**/
function realtime_make_html_seller(buyer){
    if($(".table-body.container > div:nth-child(1)").html()) {
        var check_price = $(".table-body.container > div:nth-child(1) > div:nth-child(3) > div").text();

        check_price = check_price.replace('US','').replace(' ','').trim();
        $(".input-holder-box .buttons-box .btn.blue .describe.333 strong").text(check_price);
        if(check_price !== buyer.price) {
            var price = buyer.price.replace(',','').replace('$','');
            check_price = check_price.replace(',','').replace('$','');
            var reserve_price = $("#auction_detail_reverse_price").val();
            if(Number(price) < Number(reserve_price)) {
                price = Number(check_price) + Number(50);
            }
            var item = '<div class="table-row last first">' +
                '<div class="cell" data-number="2" data-text="timestamp">' +
                '<div class="el">' + buyer.timestamp + '</div>' +
                '</div>' +
                '<div class="cell" data-number="3" data-text="amount">' +
                '<div class="el">US&nbsp; ' + '$' + price.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,') + '</div>' +
                '</div>' +
                '<div class="cell no-user-location" data-number="4" data-text="Location"><div class="el"></div>' +
                '</div>' +
                '</div>';
            $(".table-body.container > div:nth-child(1)").before(item);
            // count
            $(".auction-detail .module-intro-box .grid-options > div:nth-child(6) .value.blue").text(buyer.countBid);
        }
    } else {
        window.location.reload();
        // $(".table-body.container").append(item);
        // $(".auction-detail .module-intro-box .grid-options > div:nth-child(6) .value.blue").text(buyer.countBid);
    }
}
