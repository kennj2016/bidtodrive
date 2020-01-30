<?php /* Smarty version 2.6.31, created on 2019-10-06 09:24:47
         compiled from admin_users.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "includes/admin/manage_records.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
    <?php echo '
    $(function(){
        function getIds(target){
            var ids = [], id = $(target).attr(\'data-id\');
            if(id){
                if(id == \'batch\') $(\'[name="batch_ids[]"]:checked\').each(function(){ids.push($(this).val());});
                else ids.push(id);
            }
            return ids;
        }

        $(\'body\').on(\'click\', \'[data-post-action]\', function(event){
            var This = $(event.target), action = This.attr(\'data-post-action\'), ids = getIds(event.target);
            if(ids.length){
                var post = function(reason){
                    form_post(\'\', {action: action, ids: ids, command:1, reason:reason});
                };

                var formReject = function(){
                    defaultConfirmPopupX(\'Reason\', post)
                }
                if(This.hasClass("action-status-off")) {
                    defaultConfirmPopup("Deactive this user?", formReject);
                }
            }
            return false;
        })

        function defaultConfirmPopupX(message, yes, no){
            var state = false;
            var text = \'\';
            return defaultPopup({message: \'<p><b>\'+message.replace(/\\n/g, "<br />")+\'</b></p> \', title: \'confirm\', onbefore: function(popup){
                    var block = $(\'<textarea style="width:100%" rows="3"></textarea><div class="block"><a class="button1" href="#">Confirm</a><a class="button1" href="#">Cancel</a></div>\');
                    block.find(\'a\').click(function(){
                        state = !$(this).index();
                        text = $(this).parent().parent().find(\'textarea\').val();
                        popup.close();
                        return false;
                    });
                    popup.container.find(\'.popup-text\').append(block);
                },
                onclose: function(){
                    if(state){
                        if(yes) yes(text);
                    }else if(no) no();
                }});
        }//defaultConfirmPopup
    });

    '; ?>

</script>