"use strict";
var WebSocket = WebSocket || MozWebSocket;
var serverUrl = "wss://" + window.location.hostname + ":4300";
var connection = new WebSocket(serverUrl);
var notificationsOnPage = {};

connection.onmessage = function (evt) {
    var notification = "";
    var response = JSON.parse(evt.data);

    response.notification = JSON.parse(response.notification);
    switch (response.type) {
        case 0:
            loginClient();
            break;
        case 1:
            notification = "Buyer registration confirmation";
            break;
        case 2:
            notification = "You won " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " with a bid of $" + moneyFormat(response.notification.final_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showSuccessNotification(notification, response.id);
            break;
        case 3:
            notification = "Your auction for " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " is complete with a winning bid of $" + moneyFormat(response.notification.final_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showSuccessNotification(notification, response.id);
            break;
        case 4:
            notification = "Your watched listing ends in 24 hours: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 5:
            notification = "Your watched listing ends in 1 hour: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 6:
            notification = "Your watched listing ends in 5 minutes: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 7:
            notification = "Buyer is outbid on " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". The new high bid is $" + moneyFormat(response.notification.amount) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 8:
            notification = "New auction from " + response.notification.seller_name + ": " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 9:
            notification = "Your listing ends in 24 hours: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 10:
            notification = "Your listing ends in 1 hour: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 11:
            notification = "Your listing ends in 5 minutes: " + response.notification.year + " " + response.notification.make + " " + response.notification.model + ". Current bid is $" + moneyFormat(response.notification.current_bid) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 12:
            notification = "New bid on  " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " by " + response.notification.buyer_name + " for $" + moneyFormat(response.notification.amount) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 13:
            notification = "Your auction for " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " ended without meeting the reserve price. <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a> <a href='/auctions/" + response.notification.auction_id + "/relist/' class='btn'>Relist</a> <a href='/auctions/" + response.notification.auction_id + "/accept-highest-bid/' class='btn'>Accept High Bid</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 14:
            notification = "Your dealer license expires soon on " + response.notification.license_expiration_date + ". Please update it on your account to continue using Bid to Drive. <a href='/account/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 15:
            notification = "Your driver's license expires soon on " + response.notification.license_expiration_date + ". Please update it on your account to continue using Bid to Drive. <a href='/account/buyer/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 16:
            notification = "Your driver's license has expired. Please update it on your account to continue using Bid to Drive. <a href='/account/buyer/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 17:
            notification = "Your dealer license has expired. Please update it on your account to continue using Bid to Drive. <a href='/account/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 18:
            notification = "You bid $" + moneyFormat(response.notification.amount) + " on " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 19:
            notification = "Your auction " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " was bought out for $" + moneyFormat(response.notification.buy_now_price) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showSuccessNotification(notification, response.id);
            break;
        case 20:
            notification = "You won " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " with a buy now purchase of $" + moneyFormat(response.notification.buy_now_price) + ". <a href='/auctions/" + response.notification.auction_id + "/' class='btn'>view</a>";
            showSuccessNotification(notification, response.id);
            break;
        case 21:
            notification = "The buyer's commission payment for " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " failed. The buyer has been removed as the winning bidder. To relist the auction, click here <a href='/auctions/" + response.notification.auction_id + "/relist/' class='btn'>relist</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 22:
            notification = "Your commission payment for " + response.notification.year + " " + response.notification.make + " " + response.notification.model + " has failed. You have been removed as the winning bidder.";
            showUpcomingNotification(notification, response.id);
            break;
        case 23:
            notification = "Your credit card ending in " + response.notification.cc_exp_number + " is expiring on " + response.notification.cc_exp_date + ". Please update your credit card before then to continue using Bid to Drive without interruption. <a href='/account/billing-details/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
        case 24:
            notification = "Your credit card ending in " + response.notification.cc_exp_number + " has expired. Please update it on your account to continue using Bid to Drive. <a href='/account/billing-details/' class='btn'>Update</a>";
            showUpcomingNotification(notification, response.id);
            break;
    }
};

function loginClient() {
    connection.send(JSON.stringify({uid: uid}));
}

function showSuccessNotification(msg, id) {
    // if this notification already on screen, not showing 2nd one
    if (notificationAlreadyShown(id)) {
        return true;
    }

    var html = '';
    html += '<div id="nid_' + id + '" class="io-text">';
    html += '   <div class="holder">';
    html += '       <div class="label">';
    html += '           <span class="icon">';
    html += '               <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta><!--?xpacket end="w"?--></metadata><defs><style>.cls-1 {fill-rule: evenodd;}</style></defs><path class="cls-1" d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z" transform="translate(-1404 -748)"></path></svg>';
    html += '           </span>';
    html += '           <span class="alert-text">';
    html += '               <span>Success</span>';
    html += '           </span>';
    html += '       </div>';
    html += '       <div class="msg">';
    html += '           <p><span>' + msg + '</span></p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    $.iaoAlert({
        msg: html,
        type: "success",
        autoHide: false,
        position: 'bottom-right',
        fadeOnHover: false,
        mode: "dark",
        onClose: function () {
            notificationMarkAsRead(id);
        }
    });
}

function showUpcomingNotification(msg, id) {
    // if this notification already on screen, not showing 2nd one
    if (notificationAlreadyShown(id)) {
        return true;
    }

    var html = '';
    html += '<div id="nid_' + id + '" class="io-text">';
    html += '   <div class="holder">';
    html += '       <div class="label">';
    html += '           <span class="icon">';
    html += '               <svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta><!--?xpacket end="w"?--></metadata><defs><style>.cls-1 { fill-rule: evenodd; }</style></defs><path class="cls-1" d="M1419.5,685a0.909,0.909,0,1,0,0,1.817,13.854,13.854,0,1,1-9.5,3.935v1.577a0.905,0.905,0,1,0,1.81,0V688.7a0.911,0.911,0,0,0-.91-0.909h-3.66a0.906,0.906,0,1,0,0,1.812h1.33A15.438,15.438,0,1,0,1419.5,685Zm0,5.512a10,10,0,1,0,9.99,10A10,10,0,0,0,1419.5,690.512Zm6.38,15.1-0.6-.6a0.907,0.907,0,1,0-1.28,1.284l0.6,0.6a8.159,8.159,0,0,1-4.19,1.741v-0.858a0.91,0.91,0,0,0-1.82,0v0.858a8.159,8.159,0,0,1-4.19-1.741l0.6-.6a0.907,0.907,0,1,0-1.28-1.284l-0.6.6a8.107,8.107,0,0,1-1.74-4.192h0.85a0.909,0.909,0,1,0,0-1.818h-0.85a8.107,8.107,0,0,1,1.74-4.192l0.6,0.6a0.907,0.907,0,1,0,1.28-1.285l-0.6-.6a8.159,8.159,0,0,1,4.19-1.741v0.858a0.91,0.91,0,0,0,1.82,0V692.38a8.159,8.159,0,0,1,4.19,1.741l-0.6.6a0.907,0.907,0,1,0,1.28,1.285l0.6-.6a8.107,8.107,0,0,1,1.74,4.192h-0.85a0.906,0.906,0,1,0,0,1.812h0.85A8.127,8.127,0,0,1,1425.88,705.608Zm-3.92-3.926-1.55-1.551v-3.258a0.91,0.91,0,0,0-1.82,0v3.634a0.916,0.916,0,0,0,.27.643l1.81,1.817A0.91,0.91,0,0,0,1421.96,701.682Z" transform="translate(-1404 -685)"></path></svg>';
    html += '           </span>';
    html += '       </div>';
    html += '       <div class="msg">';
    html += '           <p><span>' + msg + '</span></p>';
    html += '       </div>';
    html += '   </div>';
    html += '</div>';
    $.iaoAlert({
        msg: html,
        type: "notification",
        autoHide: false,
        position: 'bottom-right',
        fadeOnHover: false,
        mode: "dark",
        onClose: function () {
            notificationMarkAsRead(id);
        }
    });
}

function notificationAlreadyShown(id) {
    if (typeof notificationsOnPage["nid_" + id] !== "undefined") {
        return true;
    }
    var d = new Date();
    var n = d.getTime();
    notificationsOnPage["nid_" + id] = n;
    return false;
}

function notificationMarkAsRead(id) {
    // sending ajax request anyway
    $.ajax({
        type: "POST",
        url: "/ajax/account/notifications/",
        data: {'id': id},
        dataType: 'json',
        success: function (response) {
            if (typeof response.status !== "undefined" && response.status == "Success") {
                if (typeof notificationsOnPage["nid_" + id] !== "undefined") {
                    delete notificationsOnPage["nid_" + id];
                }
            }
        }
    });
}

var activeTab = (function(){
    var stateKey, eventKey, keys = {
        hidden: "visibilitychange",
        webkitHidden: "webkitvisibilitychange",
        mozHidden: "mozvisibilitychange",
        msHidden: "msvisibilitychange"
    };
    for (stateKey in keys) {
        if (stateKey in document) {
            eventKey = keys[stateKey];
            break;
        }
    }
    return function(c) {
        if (c) document.addEventListener(eventKey, c);
        return !document[stateKey];
    }
})();

setInterval(function () {
    if (activeTab() && !$.isEmptyObject(notificationsOnPage)) {
        $.each(notificationsOnPage, function(key, value) {
            var nid = key.replace("nid_", "");
            var d = new Date();
            var n = d.getTime();
            if (value > 0 && ((n - value) > 20000)) {
                notificationMarkAsRead(nid);
                $("#" + key).parent().find($("iao-alert-close")).trigger("click");
            }
        });
    }
}, 1000);

activeTab(function(){
    if (!$.isEmptyObject(notificationsOnPage)) {
        if (activeTab()) {
            $.each(notificationsOnPage, function(key, value) {
                var d = new Date();
                var n = d.getTime();
                notificationsOnPage[key] = n;
            });
        } else {
            $.each(notificationsOnPage, function(key, value) {
                notificationsOnPage[key] = 0;
            });
        }
    }
});
