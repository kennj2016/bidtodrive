<?php /* Smarty version 2.6.31, created on 2020-01-21 04:05:30
         compiled from includes/main/account_left.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'includes/main/account_left.tpl', 12, false),)), $this); ?>
<div class="sec-1">
    <div class="baron">
        <div class="baron__clipper">
            <div class="baron__bar"></div>
            <div class="baron__scroller">
                <div class="content-box">
                    <div class="account-left-box">
                        <div class="contentbox">
                            <?php if ($this->_tpl_vars['parameters']['user']->user_type == 'Seller' && $this->_tpl_vars['parameters']['user']->profile_photo): ?>
                                <div class="img-holder">
                                    <div class="holder no-overlay">
                                        <img src="<?php if ($this->_tpl_vars['parameters']['user']->profile_photo): ?>/site_media/<?php echo $this->_tpl_vars['parameters']['user']->profile_photo; ?>
/m/<?php else: ?>/images/default-user-image.png<?php endif; ?>" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="img-holder no-padding">
                                    <div class="holder no-border">
                                        <img src="/images/bg/bg-3.jpg" alt="Welcome <?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" title="Welcome <?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"/>
                                        <div class="info">
                                            <span>welcome</span>
                                            <?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <h4 class="name">
                                <?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                <div class="left-panel-close-button"></div>
                            </h4>
                            <div class="page-links-list">
                                <a href="/auctions/create/" class="item btn <?php if ($this->_tpl_vars['parameters']['cmd'] == 'auctions_edit' && $this->_tpl_vars['parameters']['action'] == 'create'): ?> active<?php endif; ?>" title="Create Auction">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/steering-whee-accountl.svg" alt="Create Auction" title="Create Auction"/>
                                    </div>
                                    <span>Create Auction</span>
                                </a>
                                <a href="/account/listings/" class="item btn <?php if (! ( $this->_tpl_vars['parameters']['cmd'] == 'auctions_edit' || $this->_tpl_vars['parameters']['action'] == 'create' || $this->_tpl_vars['parameters']['action'] == 'account_info' || $this->_tpl_vars['parameters']['action'] == 'account_content_blocks' || $this->_tpl_vars['parameters']['cmd'] == 'account_security_access' || $this->_tpl_vars['parameters']['cmd'] == 'account_seller_notification_settings' )): ?>active<?php endif; ?>" id="my-listings-btn" title="My listings">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My listings" title="My listings"/>
                                    </div>
                                    <span>My listings</span>
                                </a>
                                <a href="/account/content-blocks/" class="item btn<?php if ($this->_tpl_vars['parameters']['action'] == 'account_content_blocks'): ?> active<?php endif; ?> " title="My content blocks">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My content blocks" title="My content blocks"/>
                                    </div>
                                    <span>My content blocks</span>
                                </a>
                                <a href="/account/info/" class="item btn<?php if ($this->_tpl_vars['parameters']['action'] == 'account_info'): ?> active<?php endif; ?> " title="My account information">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information"/>
                                    </div>
                                    <span>My account information</span>
                                </a>
                                <a href="/account/security-access/" class="item btn<?php if ($this->_tpl_vars['parameters']['cmd'] == 'account_security_access'): ?> active<?php endif; ?> " title="Security & Access">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                    </div>
                                    <span>Security & Access</span>
                                </a>
                                <a href="/account/seller-notification-settings/" class="item btn <?php if ($this->_tpl_vars['parameters']['cmd'] == 'account_seller_notification_settings'): ?> active<?php endif; ?>" title="Notification Settings">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/notification.svg" alt="Notification Settings" title="Notification Settings"/>
                                    </div>
                                    <span>Notification Settings</span>
                                </a>
                                <a href="/logout/" class="item" title="Sign Out">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-signout.svg" alt="Sign Out" title="Sign Out"/>
                                    </div>
                                    <span>Sign Out</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>