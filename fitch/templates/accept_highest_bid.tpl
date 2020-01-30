{strip}
{include file="includes/main/site_top.tpl"}
<div class="sec-holder">
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
                                    <a href="/auctions/create/" title="Create Auction" class="item btn {if $parameters.cmd == "auctions_edit" && $parameters.action == "create"} active{/if}">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/steering-whee-accountl.svg" alt="Create Auction" title="Create Auction"/>
                                        </div>
                                        <span>Create Auction</span>
                                    </a>
                                    <a href="/account/listings/" class="item btn {if !($parameters.cmd == "auctions_edit" || $parameters.action == "create" || $parameters.action == "account_info" || $parameters.action == "account_content_blocks" || $parameters.cmd == "account_security_access" || $parameters.cmd == "accept_highest_bid")}active{/if}" id="my-listings-btn" title="My listings">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My listings" title="My listings"/>
                                        </div>
                                        <span>My listings</span>
                                    </a>
                                    <a href="/account/content-blocks/" class="item btn" title="My content blocks">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My content blocks" title="My content blocks"/>
                                        </div>
                                        <span>My content blocks</span>
                                    </a>
                                    <a href="/account/info/" class="item btn" title="My account information">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information"/>
                                        </div>
                                        <span>My account information</span>
                                    </a>
                                    <a href="/account/security-access/" class="item btn" title="Security & Access">
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
    <div class="sec-2">
        <div class="baron">
            <div class="baron__clipper">
                <div class="baron__bar"></div>
                <div class="baron__scroller">
                    <div class="content-box">
                        <div class="account-right-box bottom-space">
                            <div class="tablet-left-panel-opener-box">
                                <div class="name">{$parameters.user->name|escape}</div>
                            </div>
                            <div id="create-edit-auction" class="page active">
                                <h4 class="head-title">
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="my account" title="my account"/>
                                    </div>
                                    <span id="edit-auction-title">
                                        Accept Highest Bid
                                    </span>
                                </h4>
                                <div class="subpage">
                                    <div class="inner-subpage-box">
                                        <iao-alert-box position="block">
                                            <iao-alert-start></iao-alert-start>
                                            <iao-alert class="" id="iao1524127332562" mode="dark" type="error" style="white-space:pre-wrap;word-wrap:break-word;">
                                                <div class="io-text">
                                                    <div class="holder">
                                                        <div class="label">
                                                            <span class="icon">
                                                                <img class="svg-icon-inject" src="/images/icons/icon-alert-warning.svg" alt="" title="Error"/>
                                                            </span>
                                                            <span class="alert-text">
                                                                <span>Error</span>
                                                            </span>
                                                        </div>
                                                        <div class="msg">
                                                            <p><span>{$parameters.error}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </iao-alert>
                                        </iao-alert-box>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="one-col-structure">
                                {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {include file="includes/main/popup_file_upload.tpl"}
        </div>
    </main>
</div>
</body>
</html>
{/strip}