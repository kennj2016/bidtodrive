<?php /* Smarty version 2.6.31, created on 2020-01-21 03:46:51
         compiled from includes/main/account_buyer_left.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'escape', 'includes/main/account_buyer_left.tpl', 14, false),)), $this); ?>
<div class="sec-1">
    <div class="baron">
        <div class="baron__clipper">
            <div class="baron__bar"></div>
            <div class="baron__scroller">
                <div class="content-box">
                    <div class="account-left-box">
                        <div class="contentbox">
                            <div class="img-holder no-padding">
                                <div class="holder no-border">
                                    <img src="/images/bg/bg-3.jpg" alt="img"/>
                                    <div class="info">
                                        <span>welcome</span>
                                        <?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>

                                    </div>
                                </div>
                            </div>
                            <h4 class="name no-padding no-border">
                                <span class="mobile-only"><?php echo ((is_array($_tmp=$this->_tpl_vars['parameters']['user']->name)) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</span>
                                <div class="left-panel-close-button">
                                </div>
                            </h4>
                            <div class="page-links-list">
                                <a href="/account/buyer/bids/" title="My Bids" id="mode-bids" class="item btn activate-sticky-scroll <?php if ($this->_tpl_vars['parameters']['mode'] == 'bids'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Bids" title="My Bids"/>
                                    </div>
                                    <span>My Bids</span>
                                </a>
                                <a href="/account/buyer/watched-listings/" title="My watched listings" id="mode-watched-listings" class="item btn <?php if ($this->_tpl_vars['parameters']['mode'] == 'watched_listings'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My watched listings" title="My watched listings"/>
                                    </div>
                                    <span>My watched listings</span>
                                </a>
                                <a href="/account/buyer/watched-sellers/" title="My watched sellers" id="mode-watched-sellers" class="item btn <?php if ($this->_tpl_vars['parameters']['mode'] == 'watched_sellers'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My watched sellers" title="My watched sellers"/>
                                    </div>
                                    <span>My watched sellers</span>
                                </a>
                                <a href="/account/buyer/payments/" title="My Purchases" id="mode-payments" class="item btn activate-sticky-scroll <?php if ($this->_tpl_vars['parameters']['mode'] == 'payments'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Purchases" title="My Purchases"/>
                                    </div>
                                    <span>My Purchases</span>
                                </a>
                                <a href="/account/buyer/" title="My account information" class="item btn <?php if ($this->_tpl_vars['parameters']['mode'] != 'payments' && $this->_tpl_vars['parameters']['mode'] != 'watched_listings' && $this->_tpl_vars['parameters']['mode'] != 'watched_sellers' && $this->_tpl_vars['parameters']['cmd'] != 'account_security_access' && $this->_tpl_vars['parameters']['cmd'] != 'account_buyer_billing_details' && $this->_tpl_vars['parameters']['cmd'] != 'account_buyer_notification_settings'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information"/>
                                    </div>
                                    <span>My account information</span>
                                </a>
                                <a href="/account/security-access/" title="Security & Access" class="item btn <?php if ($this->_tpl_vars['parameters']['cmd'] == 'account_security_access'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                    </div>
                                    <span>Security & Access</span>
                                </a>
                                <a href="/account/billing-details/" title="Billing Details" class="item btn <?php if ($this->_tpl_vars['parameters']['cmd'] == 'account_buyer_billing_details'): ?>active<?php endif; ?>">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/credit-card.svg" alt="Billing Details" title="Billing Details"/>
                                    </div>
                                    <span>Billing Details</span>
                                </a>
                                <a href="/account/notification-settings/" title="Notification Settings" class="item btn <?php if ($this->_tpl_vars['parameters']['cmd'] == 'account_buyer_notification_settings'): ?>active<?php endif; ?>">
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