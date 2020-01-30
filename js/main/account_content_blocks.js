$(function () {

    $('.account-right-box .content-blocks .add_term_condition').on('click', function () {
        var taid = guid();
        var template = '<div class="item_wrapper content-blocks"><form><input type="hidden" name="action" value="save_term" /><input type="hidden" name="id" value="" /><div class="header-group"><label class="small">Title</label><input name="title" type="text" value=""/><span class="line"></span></div> <div class="text-group"><label class="small">Enter Terms & Conditions</label><textarea id="ta_' + taid + '" class="trumbowyg" name="description" cols="30"></textarea></div><div class="button-group"><a href="#" data-id="" data-type="save" class="btn-2 black">Save</a><a href="#" data-id="" data-type="delete" class="btn-2 blue">Delete</a></div></form></div>';
        $(this).closest('.content-blocks-holder').append(template);
        autosize($('.content-blocks-holder textarea'));
        
        $("#ta_" + taid).trumbowyg({
            btns: ['strong', 'em', '|', 'unorderedList', 'orderedList'],
            autogrow: true
        });
    });
    
    $('.account-right-box .content-blocks .add_fee').on('click', function () {
        var taid = guid();
        var template = '<div class="item_wrapper content-blocks"><form><input type="hidden" name="action" value="save_fee" /><input type="hidden" name="id" value="" /><div class="header-group"><label class="small">Title</label><input name="title" type="text" value=""/><span class="line"></span></div> <div class="text-group"><label class="small">Enter Additional Fees</label><textarea id="ta_' + taid + '" class="trumbowyg" name="description" cols="30"></textarea></div><div class="button-group"><a href="#" data-id="" data-type="save" class="btn-2 black">Save</a><a href="#" data-id="" data-type="delete" class="btn-2 blue">Delete</a></div></form></div>';
        $(this).closest('.content-blocks-holder').append(template);
        autosize($('.content-blocks-holder textarea'));
        $("#ta_" + taid).trumbowyg({
            btns: ['strong', 'em', '|', 'unorderedList', 'orderedList'],
            autogrow: true
        });
    });

    $('.account-right-box .content-blocks .add_payment_pickup').on('click', function () {
        var taid = guid();
        var template = '<div class="item_wrapper content-blocks">' +
            '<form>' +
            '<input type="hidden" name="action" value="payment_pickup"/>' +
            '<input type="hidden" name="id" value=""/>' +
            '<div class="header-group">' +
            '<label class="small">Title</label>' +
            '<input type="text" name="title" value="" />' +
            '<span class="line"></span>' +
            '</div>' +
            '<div class="text-group select-3-payment-method">' +
            '<label class="small">Payment Method</label>' +
            '<select class="select-3 payment-select-custom-2" name="payment_method[]" multiple>' +
            '<option value="0"></option>' +
            '<option value="1">Check</option>' +
            '<option value="2">Cash</option>' +
            '<option value="3">Bank Check</option>' +
            '<option value="4">Money Order</option>' +
            '<option value="5">Wire Transfer</option>' +
            '</select>' +
            '</div>' +
            '<div class="header-group">' +
            '<label class="small">Pickup Window</label>' +
            '<input type="text" name="pickup_window" value="" />' +
            '</div>' +
            '<div class="text-group">' +
            '<label class="small">Pickup Note</label>' +
            '<textarea id="ta_' + taid + '" class="trumbowyg" name="pickup_note" cols="30"></textarea>' +
            '</div>' +
            '<div class="button-group">' +
            '<a href="#" data-id="" data-type="save" class="btn-2 black">Save</a>' +
            '<a href="#" data-id="" data-type="delete" class="btn-2 blue">Delete</a>' +
            '</div>' +
            '</form>' +
            '</div>';
        $(this).closest('.content-blocks-holder').append(template);
        $('select').selectize();
        autosize($('.content-blocks-holder textarea'));

        $("#ta_" + taid).trumbowyg({
            btns: ['strong', 'em', '|', 'unorderedList', 'orderedList'],
            autogrow: true
        });
    });

    $(document).on('click', '.item_wrapper [data-type="save"]', function (e) {
        e.preventDefault();
        var This = $(this);
        var frm = This.closest("form");
        $.ajax({
            type: "POST",
            url: "/ajax/account/content-blocks/",
            data: frm.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.has_error) {
                    showErrorMessage(response.status);
                }
                else {
                    frm.find("input[name='id']").val(response.id);
                    frm.find("[data-type='save']").attr("data-id", response.id);
                    frm.find("[data-type='delete']").attr("data-id", response.id);
                    if (response.success) {
                        if ($('iao-alert[type="error"]').length) {
                            $('iao-alert > iao-alert-close').trigger('click');
                        }
                        showSuccessMessage(response.status);
                    }
                }
            }
        });
    });

    $(document).on('click', '.item_wrapper [data-type="delete"]', function (e) {
        e.preventDefault();
        var This = $(this);
        var frm = This.closest("form");
        if (confirm("Are you sure you want to delete this data?")) {
            $.ajax({
                type: "POST",
                url: "/ajax/account/content-blocks/",
                data: frm.serialize() + "&action=delete_term",
                dataType: 'json',
                success: function (response) {
                    if (response.has_error) {
                        showErrorMessage(response.status);
                    }
                    else {
                        frm.closest(".item_wrapper").remove();
                        if (response.success) {
                            showSuccessMessage(response.status);
                        }
                    }
                }
            });
        }
    });

    $('.payment-select-custom-2').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function (input) {
            return {
                value: input,
                text: input
            }
        }
    });

    if ($('.trumbowyg').length){
        function initTrumbowyg () {
            $('.trumbowyg').trumbowyg({
                btns: ['strong', 'em', '|', 'unorderedList', 'orderedList'],
                autogrow: true
            });
        }
        initTrumbowyg();
    }
});