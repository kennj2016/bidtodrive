{include file="includes/admin/manage_records.tpl"}

<script type="text/javascript">
    {literal}
    $(function(){
        function getIds(target){
            var ids = [], id = $(target).attr('data-id');
            if(id){
                if(id == 'batch') $('[name="batch_ids[]"]:checked').each(function(){ids.push($(this).val());});
                else ids.push(id);
            }
            return ids;
        }

        $('body').on('click', '[data-post-action]', function(event){
            var This = $(event.target), action = This.attr('data-post-action'), ids = getIds(event.target);
            if(ids.length){
                var postApprove = function(){
                    form_post('', {action: action, ids: ids, command:1});
                };
                var postReject = function(reason){
                    form_post('', {action: action, ids: ids, command:0, reason:reason});
                };
                var formReject = function(){
                    defaultConfirmPopupX('Reason', postReject)
                }
                if(action == 'approvex') {
                    defaultConfirmPopup("Approve this request?", postApprove, formReject);
                }
            }
            return false;
        })

        function defaultConfirmPopupX(message, yes, no){
            var state = false;
            var text = '';
            return defaultPopup({message: '<p><b>'+message.replace(/\n/g, "<br />")+'</b></p> ', title: 'confirm', onbefore: function(popup){
                    var block = $('<textarea style="width:100%" rows="3"></textarea><div class="block"><a class="button1" href="#">Confirm</a><a class="button1" href="#">Cancel</a></div>');
                    block.find('a').click(function(){
                        state = !$(this).index();
                        text = $(this).parent().parent().find('textarea').val();
                        popup.close();
                        return false;
                    });
                    popup.container.find('.popup-text').append(block);
                },
                onclose: function(){
                    if(state){
                        if(yes) yes(text);
                    }else if(no) no();
                }});
        }//defaultConfirmPopup
    });

    {/literal}
</script>