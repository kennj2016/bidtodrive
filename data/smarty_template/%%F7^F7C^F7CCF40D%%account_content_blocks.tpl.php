<?php /* Smarty version 2.6.31, created on 2020-01-21 04:05:31
         compiled from includes/main/account_content_blocks.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'includes/main/account_content_blocks.tpl', 38, false),array('modifier', 'strip_tags', 'includes/main/account_content_blocks.tpl', 43, false),array('modifier', 'explode', 'includes/main/account_content_blocks.tpl', 119, false),)), $this); ?>
<?php echo '
	<style type="text/css"> 
		.account-right-box .subpage .btn-2.black:hover{border:none;} 
	</style>
'; ?>

<div class="page <?php if ($this->_tpl_vars['parameters']['action'] == 'account_content_blocks'): ?>active<?php endif; ?>">
    <h4 class="head-title">
        <div class="ico">
            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My content blocks" title="My content blocks"/>
        </div>
        <span>My content blocks</span>
    </h4>
    <div class="subpage">
        <div class="content-blocks-holder">
            <div class="content-blocks">
                <p class="cb-introductory-text">Content Blocks save you time by allowing you to use the same text on multiple auctions. You can create multiple versions of a content block (for example, several different sets of Terms & Conditions) and pick the appropriate one for each auction.</p>
            </div>
        </div>
        <div class="content-blocks-holder content-blocks-term-condition">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Terms & Conditions</h4>
                    <a class="add add_term_condition" href="#terms" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Terms & Conditions" title="Terms & Conditions" />
                        </div>
                    </a>
                </div>
                <?php if ($this->_tpl_vars['parameters']['content_blocks']['terms']): ?>
                    <?php $_from = $this->_tpl_vars['parameters']['content_blocks']['terms']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="save_term"/>
                                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']->id; ?>
"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group">
                                    <label class="small">Enter Terms & Conditions</label>
                                    <textarea class="trumbowyg" name="description" cols="30"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']->description)) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
            </div>
            <div id="terms"></div>
        </div>
        <div class="content-blocks-holder content-blocks-fee">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Additional Fees</h4>
                    <a class="add add_fee" href="#fees" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Additional Fees" title="Additional Fees"/>
                        </div>
                    </a>
                </div>
                <?php if ($this->_tpl_vars['parameters']['content_blocks']['fees']): ?>
                    <?php $_from = $this->_tpl_vars['parameters']['content_blocks']['fees']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="save_fee"/>
                                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']->id; ?>
"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group">
                                    <label class="small">Enter Additional Fees</label>
                                    <textarea class="trumbowyg" name="description" cols="30"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']->description)) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
            </div>
            <div id="fees"></div>
        </div>
        <div class="content-blocks-holder content-blocks-payment-pickup">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Payment/Pickup</h4>
                    <a class="add add_payment_pickup" href="#payment_pickup" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Payment/Pickup" title="Payment/Pickup"/>
                        </div>
                    </a>
                </div>
                <?php if ($this->_tpl_vars['parameters']['content_blocks']['payment_pickup']): ?>
                    <?php $_from = $this->_tpl_vars['parameters']['content_blocks']['payment_pickup']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="payment_pickup"/>
                                <input type="hidden" name="id" value="<?php echo $this->_tpl_vars['item']->id; ?>
"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']->title)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group select-3-payment-method">
                                    <label class="small">Payment Method</label>
                                    <select class="select-3 payment-select-custom-2" name="payment_method[]" multiple="multiple">
                                        <option value=""></option>
                                        <?php $this->assign('methods', ((is_array($_tmp=",")) ? $this->_run_mod_handler('explode', true, $_tmp, $this->_tpl_vars['item']->payment_method) : explode($_tmp, $this->_tpl_vars['item']->payment_method))); ?>
                                        <?php $_from = $this->_tpl_vars['web_config']['payment_methods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['payment_methods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['payment_methods']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['method']):
        $this->_foreach['payment_methods']['iteration']++;
?>
                                            <option value="<?php echo $this->_tpl_vars['key']; ?>
"<?php if (in_array ( $this->_tpl_vars['key'] , $this->_tpl_vars['methods'] )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['method']; ?>
</option>
                                        <?php endforeach; endif; unset($_from); ?>
                                    </select>
                                    <div class="header-group">
                                        <label class="small">Pickup Window</label>
                                        <input type="text" name="pickup_window" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['item']->pickup_window)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
                                    </div>
                                    <div class="text-group">
                                        <label class="small">Pickup Note</label>
                                        <textarea class="trumbowyg" name="pickup_note" cols="30"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']->pickup_note)) ? $this->_run_mod_handler('strip_tags', true, $_tmp) : smarty_modifier_strip_tags($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</textarea>
                                    </div>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="<?php echo $this->_tpl_vars['item']->id; ?>
" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
            </div>
            <div id="payment_pickup"></div>
        </div>
    </div>
</div>