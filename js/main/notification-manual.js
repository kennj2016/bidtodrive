function is_read_notification_manual(){
    $.ajax({
        url:'/ajax/notification-manual',
        type:'POST',
        success: function(res){
            $(".notifi-icon-menu").text("0");
        },
        error: function(err){
            console.log(err);
        }
    });
    if(document.getElementById("id__read_notification")) {
        $("#id__read_notification").toggle();
        $( ".open" ).trigger( "click" );
    }
}
function close_notification(){
    $("#id__read_notification").toggle();
}
$(document).ready(function(){
$.ajax({
    url:'/ajax/notification-manual',
    success: function(res){
        /**
         * Show notification
         */
        var notifi_menu = '';
        if(res.count > 0 ) {
            notifi_menu = '<a onclick="is_read_notification_manual();" href="#" title="notification"> <i class="fa fa-bell"></i> <span class="notifi-icon-menu">' + res.count + '</span> </a>';
            notification_manual_html(res.data,res.user_type);
        } else {
            notifi_menu = '<a href="#" title="notification"><i class="fa fa-bell"></i> <span class="notifi-icon-menu">' + res.count + '</span> </a>';
        }
        $("header.header div.notifi_header").append(notifi_menu);

    },
    error: function(err){
        // console.log(err.responseText);
    }
});


function notification_manual_html(data,user_type = ''){
    Number.prototype.formatMoney = function(c, d, t){
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    var div = '<div id="id__read_notification" class="notification_manual_html">';
            // background
            div += '<a class="notification_manual_html_background" onclick="close_notification();">X</a>';
            div += '<ul>';
                data.forEach((item) => {

                    var _item = JSON.parse(item.notification);
                    var sta = "";
                    if(_item.status){
                        sta = _item.status;
                    }else{
                        sta = "Current Bid";
                    }


                    div += '<li>';
                    div += '<p  style="margin: 0px;font-weight: bold;">' + _item.year  + ' '+ _item.make  + ' '+ _item.model + '</p>';
                    if(user_type === 'Seller') {
                        if(sta != "Current Bid"){
                            if(sta == "Accept the highest bid"){
                                div += '<p style="margin: 0px;"> '+sta+' : $' + parseInt(_item.total_price).formatMoney(0, '.', ',') + '</p>';
                            }else if(sta == "You won"){
                                div += '<p style="margin: 0px;"> '+sta+' : $' + parseInt(_item.total_price).formatMoney(0, '.', ',') + '</p>';
                            }else if(sta == "Buy now"){
                                div += '<p style="margin: 0px;"> Buy Now : $' + parseInt(_item.buy_now_price).formatMoney(0, '.', ',') + '</p>';
                            }else{
                                if(_item.amount){
                                    div += '<p style="margin: 0px;"> '+sta+' : $' + parseInt(_item.amount).formatMoney(0, '.', ',') + '</p>';
                                }else{
                                    if(parseInt(_item.starting_bid) == 0){
                                      div += '<p style="margin: 0px;"> '+sta+' : $' + (parseInt(_item.starting_bid)+50).formatMoney(0, '.', ',') + '</p>';
                                    }else{
                                      div += '<p style="margin: 0px;"> '+sta+' : $' + (parseInt(_item.starting_bid)).formatMoney(0, '.', ',') + '</p>';
                                    }
                                }
                            }

                        }else{
                            if(_item.amount){
                                div += '<p style="margin: 0px;"> Amount : $' + parseInt(_item.amount).formatMoney(0, '.', ',') + '</p>';
                            }else{
                                if(parseInt(_item.starting_bid) == 0){
                                  div += '<p style="margin: 0px;"> New auction : $' + parseInt(_item.starting_bid+50).formatMoney(0, '.', ',') + '</p>';
                                }else{
                                  div += '<p style="margin: 0px;"> New auction : $' + parseInt(_item.starting_bid).formatMoney(0, '.', ',') + '</p>';
                                }

                            }

                        }


                    } else {
                        if(sta == "You won"){
                            div += '<p style="margin: 0px;"> '+sta+' : $' + parseInt(_item.total_price).formatMoney(0, '.', ',') + '</p>';
                        }else if(sta == "Buy now"){
                            div += '<p style="margin: 0px;"> Buy Now : $' + parseInt(_item.buy_now_price).formatMoney(0, '.', ',') + '</p>';
                        }else{
                            div += '<p style="margin: 0px;"> '+sta+' : $' + parseInt(_item.current_bid).formatMoney(0, '.', ',') + '</p>';
                        }

                    }
                    div += '<p style="margin: 0px;"> Date time : '+item.datetime+'</p>';
                    div += '</li>';
                });
            div += '</ul>';
        div += '</div>';
    $("body").append(div);

}
});
