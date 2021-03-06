{strip}
    {include file="includes/main/html_top.tpl"}
        <div id="trumbowyg-icons">
            <svg xmlns="http://www.w3.org/2000/svg">
                <symbol id="trumbowyg-bold" viewBox="0 0 72 72"><path d="M51.1 37.8c-1.1-1.4-2.5-2.5-4.2-3.3 1.2-.8 2.1-1.8 2.8-3 1-1.6 1.5-3.5 1.5-5.3 0-2-.6-4-1.7-5.8-1.1-1.8-2.8-3.2-4.8-4.1-2-.9-4.6-1.3-7.8-1.3h-16v42h16.3c2.6 0 4.8-.2 6.7-.7 1.9-.5 3.4-1.2 4.7-2.1 1.3-1 2.4-2.4 3.2-4.1.9-1.7 1.3-3.6 1.3-5.7.2-2.5-.5-4.7-2-6.6zM40.8 50.2c-.6.1-1.8.2-3.4.2h-9V38.5h8.3c2.5 0 4.4.2 5.6.6 1.2.4 2 1 2.7 2 .6.9 1 2 1 3.3 0 1.1-.2 2.1-.7 2.9-.5.9-1 1.5-1.7 1.9-.8.4-1.7.8-2.8 1zm2.6-20.4c-.5.7-1.3 1.3-2.5 1.6-.8.3-2.5.4-4.8.4h-7.7V21.6h7.1c1.4 0 2.6 0 3.6.1s1.7.2 2.2.4c1 .3 1.7.8 2.2 1.7.5.9.8 1.8.8 3-.1 1.3-.4 2.2-.9 3z"></path></symbol>
                <symbol id="trumbowyg-em" viewBox="0 0 72 72"><path d="M26 57l10.1-42h7.2L33.2 57H26z"></path></symbol>
                <symbol id="trumbowyg-ordered-list" viewBox="0 0 72 72"><path d="M27 14h36v8H27zM27 50h36v8H27zM27 32h36v8H27zM11.8 15.8V22h1.8v-7.8h-1.5l-2.1 1 .3 1.3zM12.1 38.5l.7-.6c1.1-1 2.1-2.1 2.1-3.4 0-1.4-1-2.4-2.7-2.4-1.1 0-2 .4-2.6.8l.5 1.3c.4-.3 1-.6 1.7-.6.9 0 1.3.5 1.3 1.1 0 .9-.9 1.8-2.6 3.3l-1 .9V40H15v-1.5h-2.9zM13.3 53.9c1-.4 1.4-1 1.4-1.8 0-1.1-.9-1.9-2.6-1.9-1 0-1.9.3-2.4.6l.4 1.3c.3-.2 1-.5 1.6-.5.8 0 1.2.3 1.2.8 0 .7-.8.9-1.4.9h-.7v1.3h.7c.8 0 1.6.3 1.6 1.1 0 .6-.5 1-1.4 1-.7 0-1.5-.3-1.8-.5l-.4 1.4c.5.3 1.3.6 2.3.6 2 0 3.2-1 3.2-2.4 0-1.1-.8-1.8-1.7-1.9z"></path></symbol>
                <symbol id="trumbowyg-unordered-list" viewBox="0 0 72 72"><path d="M27 14h36v8H27zM27 50h36v8H27zM9 50h9v8H9zM9 32h9v8H9zM9 14h9v8H9zM27 32h36v8H27z"></path></symbol>
                <symbol id="trumbowyg-strong" viewBox="0 0 72 72"><path d="M51.1 37.8c-1.1-1.4-2.5-2.5-4.2-3.3 1.2-.8 2.1-1.8 2.8-3 1-1.6 1.5-3.5 1.5-5.3 0-2-.6-4-1.7-5.8-1.1-1.8-2.8-3.2-4.8-4.1-2-.9-4.6-1.3-7.8-1.3h-16v42h16.3c2.6 0 4.8-.2 6.7-.7 1.9-.5 3.4-1.2 4.7-2.1 1.3-1 2.4-2.4 3.2-4.1.9-1.7 1.3-3.6 1.3-5.7.2-2.5-.5-4.7-2-6.6zM40.8 50.2c-.6.1-1.8.2-3.4.2h-9V38.5h8.3c2.5 0 4.4.2 5.6.6 1.2.4 2 1 2.7 2 .6.9 1 2 1 3.3 0 1.1-.2 2.1-.7 2.9-.5.9-1 1.5-1.7 1.9-.8.4-1.7.8-2.8 1zm2.6-20.4c-.5.7-1.3 1.3-2.5 1.6-.8.3-2.5.4-4.8.4h-7.7V21.6h7.1c1.4 0 2.6 0 3.6.1s1.7.2 2.2.4c1 .3 1.7.8 2.2 1.7.5.9.8 1.8.8 3-.1 1.3-.4 2.2-.9 3z"></path></symbol>
            </svg>
        </div>
    {user_type assign="user_type"}
    {user_name assign="user_name"}
    {if $page->getAdminPermissions()}
        <div id="view-as-bar">
            <div class="float">
                <input type="radio" id="ut_admin" name="user_type" value="admin" checked="checked" />
                <label for="ut_admin">Admin View</label>
            </div>
            <div class="float">
                <input type="radio" id="ut_user" name="user_type" value="user" />
                <label for="ut_user">User View</label>
            </div>
            <div id="users_select" style="display: none;">
                <span>Users: </span>
                <input type="text" id="college_users" name="college_users" value="" />
            </div>
            <div id="view_as_user" class="float" style="display: none;"></div>
        </div>
    {/if}
<div class="wrapper
  {if $parameters.auction_info->auction_status == "Sold" && ($parameters.user->user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id || $parameters.user->user_type == "Buyer" && $parameters.auction_info->winning_user_id != $parameters.user->id || !isset($smarty.session.user))} t1-top-panel space-fix
  {else}
      {if $parameters.cmd == "auctions" || $parameters.cmd == "seller_profile" || $parameters.cmd == "account_buyer" || $parameters.cmd == "account" || $parameters.cmd == "account_security_access" || $parameters.cmd == "auctions_edit" || $parameters.cmd == "account_buyer_billing_details" || $parameters.cmd == "account_buyer_notification_settings" || $parameters.cmd == "accept_highest_bid"} t2{else}{if $parameters.cmd != "auctions_details"} t1{/if}{/if}
      {if $parameters.cmd == "homepage"} homepage{/if}
      {if $parameters.cmd == "contact" || $parameters.cmd == "login" || $parameters.cmd == "forgot_password" || $parameters.cmd == "register" || $parameters.cmd == "reset_password" || $parameters.cmd == "browser_fallback"} full-height{/if}
      {if $parameters.cmd == "auctions_details" && ($user_type == "Buyer" || $user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id)}
      {elseif $parameters.cmd == "auctions_details" && $user_type == "Seller"} t1-top-panel{/if}
      {if $parameters.cmd == "auctions_details" && $parameters.auction_info->auction_status != "Canceled" && $parameters.auction_info->auction_status != "Sold" && $parameters.auction_info->auction_status != "Refunded" && $parameters.auction_info->auction_status != "Sold" && $parameters.user->id != $parameters.auction_info->user_id} t2-top-panel space-fix{/if}
      {if $parameters.auction_info->auction_status == "Sold" && $parameters.user->user_type == "Seller" && $parameters.user->id == $parameters.auction_info->user_id || $parameters.cmd == "auctions"} space-fix{/if}
      {if $parameters.cmd == "account"} space-fix{/if}
  {/if}">
    {if $parameters.cmd != "browser_fallback"}
        <header class="header {if $parameters.cmd == "auctions_details"}second{/if}">
            <div class="container locked">
                <div class="left">
                    <div class="logo">
                        <a href="/" title="Go to Homepage">
                            <img src="/images/icons/logo.svg" alt="Go to Homepage" title="Go to Homepage"/>
                        </a>
                    </div>
                </div>
                <div class="right">
                  <form class="form" id="form_search_top" method="post" action="/auctions/">
                      <input type="text" class="text" id="keyword" name="keyword" placeholder="Search for auctions..." />

                  </form>
                    <a href="/" title="Go to Homepage"><div class="logo-mobile"><img class="svg-icon-inject" src="/images/icons/logomark.svg" alt="Logo" title="Logo"/></div></a>
                    <a href="#" class="mobile-btn" title="Menu"><img class="svg-icon-inject" src="/images/icons/menu.svg" alt="Menu" title="Menu"/></a>
                    <a id="search_top_custom" class="search" title="Go to Auctions">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
                         <path d="M76.6,136.6c-11.7,43.7-5.7,89.4,16.9,128.6C123.6,317.5,179.7,350,240,350c22.7,0,45.3-4.7,66.2-13.6L394.1,489l35.1-20.3
                          L341.3,316c30.2-22.6,51.9-54.5,61.8-91.6c11.7-43.7,5.7-89.4-16.9-128.6C356.1,43.5,300,11,239.7,11c-29.5,0-58.7,7.9-84.4,22.7
                          C116.3,56.4,88.3,92.9,76.6,136.6z M239.7,51.7c45.8,0,88.5,24.7,111.4,64.4c17.2,29.8,21.7,64.5,12.8,97.7
                          c-8.9,33.2-30.1,61-59.8,78.2c-19.5,11.3-41.7,17.3-64.1,17.3c-45.8,0-88.5-24.7-111.4-64.4c-17.2-29.8-21.7-64.5-12.8-97.7
                          c8.9-33.2,30.1-61,59.8-78.2C195.2,57.6,217.3,51.7,239.7,51.7z"></path>
                        </svg>
                    </a>

                    {if $user_type == "Buyer"}
                        <span class="login logged">
                            <div class="opener-el">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/wheel.svg" alt="{$user_name|escape}" title="{$user_name|escape}"/>
                                </span>
                                <span class="sign-text">{$user_name}</span>
                                <span class="arr">
                                    <img class="svg-icon-inject" src="/images/icons/icon-carrot-down-right.svg" alt="My Account: Options" title="My Account: Options"/>
                                </span>
                            </div>
                            <div class="drop">
                                <div class="inner">
                                    <div class="subcategory">
                                        Account options
                                    </div>
                                    <a href="/account/buyer/bids/" class="green-color" title="My Bids">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-bids.svg" alt="My Bids" title="My Bids"/>
                                        </div>
                                        <span class="sign-text">My Bids</span>
                                    </a>
                                    <a href="/account/buyer/watched-listings/" class="blue-icon" title="My Watched Listings">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My Watched Listings" title="My Watched Listings"/>
                                        </div>
                                        <span class="sign-text">My Watched Listings</span>
                                    </a>
                                    <a href="/account/buyer/watched-sellers/" class="blue-icon" title="My Watched Sellers">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My Watched Sellers" title="My Watched Sellers"/>
                                        </div>
                                        <span class="sign-text">My Watched Sellers</span>
                                    </a>
                                    <a href="/account/buyer/payments/" class="blue-icon" title="My Purchases">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Purchases" title="My Purchases"/>
                                        </div>
                                        <span class="sign-text">My Purchases</span>
                                    </a>
                                    <div class="subcategory">
                                        Settings
                                    </div>
                                    <div class="subcategory" style="color:red;font-size : 11px;">
                                        You logged in as buyer
                                    </div>
                                    <a href="/account/switch-to-seller/" title="Switch to Seller">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-switch-account.png" alt="Edit My Account" title="Switch to Seller" class="swith-account-a"/>
                                        </div>
                                        <span class="sign-text">Switch to Seller</span>
                                    </a>
                                    <a href="/account/buyer/" title="Edit My Account">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="Edit My Account" title="Edit My Account"/>
                                        </div>
                                        <span class="sign-text">Edit My Account</span>
                                    </a>
                                    <a href="/account/security-access/" title="Security & Access">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                        </div>
                                        <span class="sign-text">Security & Access</span>
                                    </a>
                                    <a href="/account/billing-details/" title="Billing Details">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/credit-card.svg" alt="Billing Details" title="Billing Details"/>
                                        </div>
                                        <span class="sign-text">Billing Details</span>
                                    </a>
                                    <a href="/account/notification-settings/" title="Notification Settings">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/notification.svg" alt="Notification Settings" title="Notification Settings"/>
                                        </div>
                                        <span class="sign-text">Notification Settings</span>
                                    </a>
                                    <a href="/logout/" class="red-bg" title="Sign Out">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-signout.svg" alt="Sign Out" title="Sign Out"/>
                                        </div>
                                        <span class="sign-text">Sign Out</span>
                                    </a>
                                </div>
                            </div>

                        </span>
                    {elseif $user_type == "Seller"}
                        <span class="login logged">
                            <div class="opener-el">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/wheel.svg" alt="{$user_name|escape}" title="{$user_name|escape}"/>
                                </span>
                                <span class="sign-text">{$user_name|escape}</span>
                                <span class="arr">
                                    <img class="svg-icon-inject" src="/images/icons/icon-carrot-down-right.svg" alt="My Account: Options" title="My Account: Options"/>
                                </span>
                            </div>
                            <div class="drop">
                                <div class="inner">
                                    <div class="subcategory">
                                        Account options
                                    </div>
                                    <a href="/auctions/create/" class="green-color" title="Create Auction">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-bids.svg" alt="Create Auction" title="Create Auction"/>
                                        </div>
                                        <span class="sign-text">Create Auction</span>
                                    </a>
                                    <a href="/account/listings/" class="blue-icon" title="My Listings">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My Listings" title="My Listings"/>
                                        </div>
                                        <span class="sign-text">My Listings</span>
                                    </a>
                                    <a href="/account/content-blocks/" class="blue-icon" title="My Content Blocks">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My Content Blocks" title="My Content Blocks"/>
                                        </div>
                                        <span class="sign-text">My Content Blocks</span>
                                    </a>
                                    <div class="subcategory">
                                        Settings
                                    </div>
                                    <div class="subcategory" style="color:red;font-size : 11px;">
                                        You logged in as Seller
                                    </div>
                                    <a href="/account/switch-to-buyer/" title="Switch to Buyer" class="swith-account-a">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-switch-account.png" alt="Edit My Account" title="Switch to Buyer" class="swith-account-a"/>
                                        </div>
                                        <span class="sign-text">Switch to Buyer</span>
                                    </a>
                                    <a href="/account/info/" title="Edit My Account">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="Edit My Account" title="Edit My Account"/>
                                        </div>
                                        <span class="sign-text">Edit My Account</span>
                                    </a>
                                    <a href="/account/security-access/" title="Security & Access">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                        </div>
                                        <span class="sign-text">Security & Access</span>
                                    </a>
                                    <a href="/account/seller-notification-settings/" title="Notification Settings">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/notification.svg" alt="Notification Settings" title="Notification Settings"/>
                                        </div>
                                        <span class="sign-text">Notification Settings</span>
                                    </a>
                                    <a href="/logout/" class="red-bg" title="Sign Out">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-signout.svg" alt="Sign Out" title="Sign Out"/>
                                        </div>
                                        <span class="sign-text">Sign Out</span>
                                    </a>
                                </div>
                            </div>
                        </span>

                    {elseif $user_name != ""}
                        <span class="login logged">
                            <div class="opener-el">
                              <a href="/logout/" class="red-bg" title="Sign Out">
                                  <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-signout.svg" alt="Sign Out" title="Sign Out"/>
                                  </span>

                                </a>
                            </div>


                        </span>
                    {else}
                    <a href="/login/" title="sign in" class="login">
                        <span class="title">Sign in</span>
                        <img class="svg-icon-inject" src="/images/icons/icon-login.svg" alt="Sign in" title="Sign in"/>
                    </a>
                    {/if}
                    <div class="notifi_header">
                    </div>
                    {if $page->hasNavigation('main')}
                        <div class="nav" id="menu_nav_top">
                            <form class="form search-mobile" method="post" action="/auctions/">
                                <div class="block-1">
                                    <input type="text" class="text" id="keyword" name="keyword" placeholder="Search..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search...'" />
                                </div>
                            </form>
                            {foreach from=$page->getNavigation('main') item=item}
                                <a href="{if $item->url}{$item->url}{else}javascript:void(0);{/if}" {if $item->is_external} target="_blank"{/if} title="{$item->title|escape|lower}">{$item->title|escape|lower}</a>
                            {/foreach}
                            <!-- {if $user_type == "Buyer"}
                            <a href="/account/switch-to-seller/" title="Request to be Seller">Request to be Seller</a>
                            {/if} -->
                        </div>
                    {/if}

                </div>
            </div>
        </header>
    {/if}

        {if $parameters.cmd == "auctions_details"}
            <div class="visualhidden">
                <div class="popup-box popup-box-1">
                    <div class="content bid-pop cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="Bid" title="Bid"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="Bid" title="Bid"/>
                                    <span>Place Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <!-- popup place bid form -->
                                            <form class="form" action="" id="popup_place_bid_form">
                                                <input type="hidden" name="action" value="popup-place-bid">
                                                <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                <label class="title-bid">Enter Amount</label>
                                                <div class="input-bid-holder">
                                                    <span>$</span>
                                                    <input name="popup_bid_price" id="txt2" type="text" class="bid-input-field custom-number" placeholder="0" />
                                                </div>
                                                {if $parameters.auction_info->count_bids == "0"}
                                                    {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                {else}
                                                    {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                                {/if}
                                                <div class="desc">Enter ${$nextMinimumBid|money_format} or more</div>
                                                <a class="btn-2 place-bid-grey popup-place-bid-confirm-step" data-number="2" href="javascript:void(0);">place bid</a>
                                            </form>
                                            {if $parameters.user->user_type == "Buyer" && $parameters.auction_info->auction_status == "Active"}
                                                {if ($parameters.user->buyer_type == "Dealer" && $parameters.auction_info->sell_to == 1) || $parameters.auction_info->sell_to == 2}
                                                    {if $parameters.auction_info->buy_now_price > 0 && $parameters.auction_info->current_bid_price < $parameters.auction_info->buy_now_price}
                                                        <div class="or">or</div>
                                                        <div class="btn-buy">
                                                            <form method="POST" action="" id="popup_buy_now_form">
                                                                <input type="hidden" name="action" value="buy_now">
                                                                <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                <input type="hidden" name="buy_now_for_price" value="{$parameters.auction_info->buy_now_price|money_format}">
                                                                <a class="link-box popup" data-number="3" href="javascript:void(0);"></a>
                                                                <span>buy now</span>
                                                                <span class="ico">
                                                                    <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Bid" title="Bid"/>
                                                                </span>
                                                            </form>
                                                        </div>
                                                        <div class="price-tip">${$parameters.auction_info->buy_now_price|money_format}</div>
                                                    {/if}
                                                {/if}
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="btn blue">
                                            <span class="describe">
                                                <span class="name">Current Bid</span>
                                                {if $parameters.auction_info->count_bids == "0"}
                                                    {assign var=currentBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                {else}
                                                    {assign var=currentBid value="`$parameters.auction_info->current_bid_price`"}
                                                {/if}
                                                <strong class="val">${$currentBid|money_format}</strong>
                                                <span class="det">top bid price</span>
                                            </span>
                                        </div>
                                        <div class="btn green">
                                            <span class="describe">
                                                <span class="name">Time Remaining</span>
                                                <strong class="val big {if $parameters.auction_info->expiration_date_main > 0}timer{/if}" data-started="" data-left="{$parameters.auction_info->expiration_date_main}">{if $parameters.auction_info->expiration_date_main < 0}0:00:00{/if}</strong>
                                                <span class="det">AUCTION ENDS {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-2 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="auction" title="auction"/>
                                    <span>Place Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <h2 class="title" id="popup-place-bid-value"></h2>
                                            <span class="fee-tip">
                                                Plus buyer's fee of {$parameters.auction_info->buyer_fee}
                                            </span>
                                            <p id="popup_place_bid_form_err" style="display:none;"></p>
                                            <div class="center-buttons">
                                                <button type="button" class="btn-2 black prew-popup">No, nevermind</button>
                                                <button type="button" class="btn-2 green popup-place-bid-submit">Yes, submit bid</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-3 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="cancel" title="cancel"/>
                                    <span>Buy Now</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <h1 class="price-title">${$parameters.auction_info->buy_now_price|money_format}</h1>
                                            <span class="fee-tip">
                                                Plus buyer's fee of {$parameters.auction_info->buyer_fee}
                                            </span>
                                            <p id="popup_buy_now_form_err" style="display:none;color: red; font-weight: 400;text-align:center;"></p>
                                            <div class="center-buttons">
                                                <button type="button" class="btn-2 black close-it">No, nevermind</button>
                                                <button type="button" class="btn-2 green submit-popup-buy-now">Yes, buy now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-4 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>

                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-cancel-auction.svg" alt="cancel" title="cancel"/>
                                    <span>Cancel Auction</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                        	  <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <h2 class="title">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model} {$parameters.auction_info->trim} {$parameters.auction_info->trim2}</h2>
                                            <p class="desc">Are you sure you wish to cancel this auction?</p>
                                            <p id="cancel-auction-err" style="display:none; color:red; padding:0; margin:0;"></p>
                                            <div class="center-buttons">
                                                <form action="" method="POST" id="cancel-auction-form">
                                                    <input type="hidden" name="action" value="cancel-auction">
                                                    <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                    <button type="button" class="btn-2 black close-it">No, nevermind</button>
                                                    <button type="button" class="btn-2 red" id="popup-cancel-yes">Yes, cancel auction</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-5 tablet-full-screen">
                    <div class="content register-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="auction" title="auction"/>
                                    <span>Place Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <h2 class="title">Please Register or Sign In</h2>
                                            <p class="desc">In order to bid, you must first create a buyers account. Returning members must be signed in.</p>
                                            <a class="btn-2 black"  href="/register/">create account</a>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="member-box">
                                            <span>Already a member?</span>
                                            <a class="btn-2 green" href="/login/?redirect=/auctions/{$parameters.auction_info->id}/">sign in</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-6 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="auction" title="auction"/>
                                    <span>Place Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <div class="input-bid-holder" style="    display: -webkit-box; display: -webkit-flex; display: -moz-flex; display: -ms-flexbox; display: flex; -webkit-box-pack: center; -ms-flex-pack: center;    -webkit-justify-content: center;   -moz-justify-content: center; justify-content: center;">
                                              <span style="font-size: 4rem; color: #0650cb;">$</span>

                                                <input  style="font-size:4rem;color:#0650cb;width: 28px;    min-width: 50px;" name="page-place-bid-value-text" id="page-place-bid-value-text" type="text" class="text custom-number inp-dollar padding-left" placeholder="0" style="width: 28px;">
                                            </div>
                                            <span class="fee-tip">
                                                Plus buyer's fee of {$parameters.auction_info->buyer_fee}
                                            </span>
                                            <p id="page_place_bid_form_err" style="display:none;"></p>
                                            <div class="center-buttons">
                                                <button type="button" class="btn-2 black close-it close-place-bid-submit">No, nevermind</button>
                                                <button type="button" class="btn-2 green" id="place_bid_submit">Yes, submit bid</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-7 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="auction" title="auction"/>
                                    <span>Place Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            <h2 class="title" id="mobile-popup-place-bid-value"></h2>
                                            <span class="fee-tip">
                                                Plus buyer's fee of {$parameters.auction_info->buyer_fee}
                                            </span>
                                            <p id="mobile_popup_place_bid_form_err" style="display:none;"></p>
                                            <div class="center-buttons">
                                                <button type="button" class="btn-2 black close-it mobile-place-bid-close-it">No, nevermind</button>
                                                <button type="button" class="btn-2 green mobile-popup-place-bid-submit">Yes, submit bid</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="popup-box popup-box-8 tablet-full-screen">
                    <div class="content cancel-auction-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/icon-auction.svg" alt="auction" title="auction"/>
                                    <span>Quick Bid</span>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <div class="top">
                                        <div class="inner">
                                            <div class="anim lds-ring">
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                              <div></div>
                                            </div>
                                            {if $parameters.auction_info->count_bids == "0"}
                                               {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                            {else}
                                               {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                            {/if}
                                            <h1 class="price-title">${$nextMinimumBid|money_format}</h1>
                                            <span class="fee-tip">
                                                Plus buyer's fee of {$parameters.auction_info->buyer_fee}
                                            </span>
                                            <p id="place_quick_bid_form_err" style="display:none;"></p>
                                            <div class="center-buttons">
                                                <button type="button" class="btn-2 black close-it">No, nevermind</button>
                                                <button type="button" class="btn-2 green quick-bid-submit">Yes, submit bid</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}
        {if $parameters.cmd == "account_buyer"}
            <div class="visualhidden">
                <div id="popup-account-buyer-switch" class="popup-box tablet-full-screen">
                    <div class="content request-pop">
                        <div class="header-box">
                            <div class="name">
                                <span></span>
                            </div>
                            <span class="close">
                                <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                            </span>
                        </div>
                        <div class="context">
                            <div class="left">
                                <span class="ico">
                                    <img class="svg-icon-inject" src="/images/icons/switch-icon.svg" alt="switch" title="switch"/>
                                </span>
                            </div>
                            <div class="right">
                                <div class="con">
                                    <h2 class="title">
                                        Switch Account Type
                                    </h2>
                                    <p class="desc">
                                        Are you sure you want to switch your account type from <span id="popup-switch-from-to-1" class="popup-switch-from-to">Dealer to Individual</span><span id="popup-switch-from-to-2" class="popup-switch-from-to">Individual to Dealer</span>?
                                    </p>
                                    <div class="center-buttons">
                                        <button type="button" class="btn-2 black close-it">Cancel</button>
                                        <button type="button" class="btn-2 blue switch-it">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/if}

<main id="main" {if $parameters.cmd == "contact" || $parameters.cmd == "login" || $parameters.cmd == "forgot_password" || $parameters.cmd == "register" || $parameters.cmd == "reset_password" || $parameters.cmd == "browser_fallback"}class="full-height"{/if}>
{/strip}
