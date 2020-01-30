$(function () {

    /*var frm = $('form.validate');
    formValidator(frm, [
        {name: 'name', label: 'Name', required: true},
        {name: 'email', label: 'Email', required: true, format: 'email'}
    ]);*/

    var buyerTypeValue = $('input[name=buyer_type]:checked').val();
    var userTypeValue = $('input[name=user_type]:checked').val();

    if (userTypeValue == "Seller") {
        $('#seller-type-div').hide();
        $("#seller-box").show();
        $('#dealer-type').show();
        $("#not-seller").hide();
    }
    $("#user_type-seller").click(function () {
        $("#seller-box").hide();
        $('#buyer-type-div').show();
        if (buyerTypeValue == "Dealer" && userTypeValue == "Seller") {
            $('#individual-type').hide();
            $('#dealer-type').show();
            $("#not-seller").show();
        }
        if (buyerTypeValue == "Individual" && userTypeValue == "Buyer") {
            $('#individual-type').show();
            $('#buyer-notifications').show();
            $('#dealer-type').hide();
        }
        if (buyerTypeValue == "Dealer" && userTypeValue == "Buyer") {
            $('#individual-type').hide();
            $('#buyer-notifications').show();
            $('#dealer-type').show();

        }
    });

    if (userTypeValue == "Buyer" && buyerTypeValue == "Individual") {
        $('#buyer-type-div').show();
        $("#seller-box").hide();
        $('#dealer-type').hide();
    }

    $("#buyer_type-individual").click(function () {
        $('#individual-type').show();
        $('#buyer-notifications').show();
        $('#dealer-type').hide();
        $("#seller-box").hide();
    });

    $("#buyer_type-dealer").click(function () {
        $('#individual-type').hide();
        $('#buyer-notifications').show();
        $('#dealer-type').show();
        $("#not-seller").show();
    });

    if (userTypeValue == "Buyer" && buyerTypeValue == "Dealer") {
        $('#individual-type').hide();
        $('#buyer-notifications').show();
        $('#dealer-type').show();
        $('#buyer-type-div').show();
    }

    $("#user_type-buyer").click(function () {
        $("#seller-box").show();
        $('#buyer-notifications').hide();
        $('#buyer-type-div').hide();
        $('input[name=buyer_type]').attr("checked", false);
        $('#individual-type').hide();
        $('#dealer-type').show();
        $("#not-seller").hide();
    });

    if (buyerTypeValue == "Individual") {
        $('#individual-type').show();
        $('#buyer-notifications').show();
        $('#dealer-type').hide();
    }
    
    $('.phone_mask').mask("(999) 999-9999", {
        insertMode: false,
        showMaskOnHover: true
    });
    
});