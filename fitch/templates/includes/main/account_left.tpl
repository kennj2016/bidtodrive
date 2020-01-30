<div class="sec-1">
    <div class="baron">
        <div class="baron__clipper">
            <div class="baron__bar"></div>
            <div class="baron__scroller">
                <div class="content-box">
                    <div class="account-left-box">
                        <div class="contentbox">
                            {if $parameters.user->user_type == "Seller" && $parameters.user->profile_photo}
                                <div class="img-holder">
                                    <div class="holder no-overlay">
                                        <img src="{if $parameters.user->profile_photo}/site_media/{$parameters.user->profile_photo}/m/{else}/images/default-user-image.png{/if}" alt="{$parameters.user->name|escape}" title="{$parameters.user->name|escape}"/>
                                    </div>
                                </div>
                            {else}
                                <div class="img-holder no-padding">
                                    <div class="holder no-border">
                                        <img src="/images/bg/bg-3.jpg" alt="Welcome {$parameters.user->name|escape}" title="Welcome {$parameters.user->name|escape}"/>
                                        <div class="info">
                                            <span>welcome</span>
                                            {$parameters.user->name|escape}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            <h4 class="name">
                                {$parameters.user->name|escape}
                                <div class="left-panel-close-button"></div>
                            </h4>
                            <div class="page-links-list">
                                <a href="/auctions/create/" class="item btn {if $parameters.cmd == "auctions_edit" && $parameters.action == "create"} active{/if}" title="Create Auction">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/steering-whee-accountl.svg" alt="Create Auction" title="Create Auction"/>
                                    </div>
                                    <span>Create Auction</span>
                                </a>
                                <a href="/account/listings/" class="item btn {if !($parameters.cmd == "auctions_edit" || $parameters.action == "create" || $parameters.action == "account_info" || $parameters.action == "account_content_blocks" || $parameters.cmd == "account_security_access" || $parameters.cmd == "account_seller_notification_settings")}active{/if}" id="my-listings-btn" title="My listings">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My listings" title="My listings"/>
                                    </div>
                                    <span>My listings</span>
                                </a>
                                <a href="/account/content-blocks/" class="item btn{if $parameters.action == "account_content_blocks"} active{/if} " title="My content blocks">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My content blocks" title="My content blocks"/>
                                    </div>
                                    <span>My content blocks</span>
                                </a>
                                <a href="/account/info/" class="item btn{if $parameters.action == "account_info"} active{/if} " title="My account information">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information"/>
                                    </div>
                                    <span>My account information</span>
                                </a>
                                <a href="/account/security-access/" class="item btn{if $parameters.cmd == "account_security_access"} active{/if} " title="Security & Access">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                    </div>
                                    <span>Security & Access</span>
                                </a>
                                <a href="/account/seller-notification-settings/" class="item btn {if $parameters.cmd == "account_seller_notification_settings"} active{/if}" title="Notification Settings">
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