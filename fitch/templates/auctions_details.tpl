{strip}
{include file="includes/main/site_top.tpl"}
    |||| {$parameters.auction_info->winner_id}  ||||2||
    <!-- is seller or buyer | realtime function -->
    <input type="hidden" id="rl_is_seller" value="{$parameters.is_seller == true ? 1 : 0 }"/>
    <input type="hidden" id="auction_detail_reverse_price" value="{$parameters.auction_info->reserve_price}"/>
    {if $parameters.is_seller == false }
        <input type="hidden" id="rl_buyer_name" value="{$parameters.user->name}"/>
        <input type="hidden" id="rl_buyer_timestamp" value="{$parameters.timestamp}"/>
    {/if}
    <!-- end realtime function -->
                <div class="sec-holder" {if $parameters.user->user_type == "Buyer"}style="padding-top: 0;"{/if}>
                    {if $parameters.user->user_type == "Seller" && $parameters.user->id == $parameters.auction_info->user_id}
                        <div class="t1-top-panel-instance">
                            <div class="top-panel-auction">
                                <div class="container">
                                    <div class="content">
                                        <h2 class="title">
                                            <span style="color: #0650cb;">{$parameters.auction_info->year}</span><span class="mark"> {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span> {$parameters.auction_info->trim}&nbsp;{$parameters.auction_info->trim2}
                                        </h2>
                                        {if $parameters.auction_info->auction_status == "Completed" && $parameters.auction_info->auction_fake_winning_bid != "N/A"}
                                            <div class="button-read green fake-link" data-link="/auctions/{$parameters.auction_info->id}/bill/">
                                                <div class="ico">
                                                    <img class="svg-icon-inject" src="/images/icons/icon-bill.svg" alt="bill" title="bill"/>
                                                </div>
                                                read bill of sale
                                            </div>
                                            <div class="mobile-fixed-panel only-show-on-mobile">
                                                <div class="holder">
                                                    <div class="btn read fake-link" data-link="/auctions/{$parameters.auction_info->id}/bill/">
                                                        <div class="holder">
                                                            <div class="ico">
                                                                <img class="svg-icon-inject" src="/images/icons/icon-bill.svg" alt="bill" title="bill"/>
                                                            </div>
                                                            <span class="describe">
                                                                <strong class="val big">read bill of sale</strong>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                        {if $parameters.dealers_only == "Yes"}
                                            <div class="buttons"><p>Dealer-Only Auction</p></div>
                                        {else}
                                            {if $parameters.auction_info->auction_status == "Active"}
                                                <div class="buttons">
                                                    <div class="input-holder-box">
                                                        <div class="buttons-box">
                                                            <div class="btn blue">
                                                                <span class="describe 333">
                                                                    {if $parameters.auction_info->count_bids == "0"}
                                                                    {assign var=sellerAuctionCurrentBid value="`$parameters.auction_info->starting_bid_price`"}
                                                                    <span class="name">Starting Bid</span>
                                                                    {else}
                                                                    {assign var=sellerAuctionCurrentBid value="`$parameters.auction_info->current_bid_price`"}
                                                                    <span class="name">Current Bid</span>
                                                                    {/if}
                                                                    <strong class="val">${$sellerAuctionCurrentBid|money_format}</strong>
                                                                </span>
                                                            </div>
                                                            <div class="btn green">
                                                                <span class="describe">
                                                                    <span class="name">Time Left To Bid</span>
                                                                    <strong class="val big {if $parameters.auction_info->expiration_date_main > 0}timer{/if}" data-started="" data-left="{$parameters.auction_info->expiration_date_main}">{if $parameters.auction_info->expiration_date_main < 0}00:00:00{/if}</strong>
                                                                    <span class="det">{$parameters.auction_info->expiration_date|date_format:"%a, %I:%M%p"} EDT</span>
                                                                </span>
                                                            </div>
                                                            <div class="btn">
                                                                <div class="holder blue fake-link" data-link="/auctions/{$parameters.auction_info->id}/edit/">
                                                                    <span class="describe">
                                                                        <strong class="val big">edit</strong>
                                                                    </span>
                                                                    <span class="sep"></span>
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-edit.svg" alt="edit" title="edit" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn">
                                                                <div class="holder red">
                                                                    <a class="link-box popup" data-number="4" href=""></a>
                                                                    <span class="describe">
                                                                        <strong class="val big">cancel</strong>
                                                                    </span>
                                                                    <span class="sep"></span>
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="edit" title="edit" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mobile-fixed-panel">
                                                    <div class="holder">
                                                        <div class="btn blue">
                                                            <span class="describe">
                                                                <span class="name 444">Current Bid</span>
                                                                <strong class="val">${$sellerAuctionCurrentBid|money_format}</strong>
                                                            </span>
                                                        </div>
                                                        <div class="btn green">
                                                            <span class="describe">
                                                                <span class="name">Time Left To Bid</span>
                                                                <strong class="val big {if $parameters.auction_info->expiration_date_main > 0}timer{/if}" data-started="" data-left="{$parameters.auction_info->expiration_date_main}">{if $parameters.auction_info->expiration_date_main < 0}0:00:00{/if}</strong>
                                                                <span class="det">{$parameters.auction_info->expiration_date|date_format:"%a, %I:%M%p"} EDT</span>
                                                            </span>
                                                        </div>
                                                        <div class="btn white-bg mob-icon-only">
                                                            <div class="holder blue fake-link" data-link="/auctions/{$parameters.auction_info->id}/edit/">
                                                                <span class="describe">
                                                                    <strong class="val big">edit</strong>
                                                                </span>
                                                                <span class="sep"></span>
                                                                <div class="ico change">
                                                                    <img class="svg-icon-inject" src="/images/icons/pencil-edit-button.svg" alt="pencil-edit-button" title="pencil-edit-button" />
                                                                    <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="btn open-mob-bid-input mob-icon-only">
                                                            <div class="holder red">
                                                                    <span class="describe">
                                                                        <strong class="val big cancel-auction"></strong>
                                                                    </span>
                                                                <span class="sep"></span>
                                                                <div class="ico change">
                                                                        <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel" />
                                                                        <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="input-bid-mob-box">
                                                        <div class="hold-box">
                                                            <div>
                                                                <form action="" method="POST" id="mobile-cancel-auction-form">
                                                                    <input type="hidden" name="action" value="cancel-auction">
                                                                    <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                    <h2 class="title">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model} {$parameters.auction_info->trim} {$parameters.auction_info->trim2}</h2>
                                                                    <p id="mobile-cancel-auction-err" style="display:none; color:red; padding:0; margin:0;"></p>
                                                                    <p class="desc">Are you sure you wish to cancel this auction?</p>
                                                                    <div class="center-buttons">
                                                                        <button type="button" class="btn-2 black close-it close-mob-bid-input" id="close-mobile-popup-cancel">No, nevermind</button>
                                                                        <br/>
                                                                        <button type="button" class="btn-2 red" id="mobile-popup-cancel-yes">Yes, cancel auction</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {/if}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sec-holder-inner">
                            <div class="sec-1">
                                <div class="content-box full-width">
                                    <div class="auction-detail" id="auction-detail-box">
                                        <div class="container">
                                            <div class="border-box">
                                                <div class="container">
                                                    <div class="container">
                                                        <div class="content mob-t-p-0">
                                                            <div class="module-intro-box">
                                                                <div class="animation-small-load img-holder {if $parameters.auction_info->photos}slider{/if}">
                                                                    {if $parameters.auction_info->photos}
                                                                    <div class="anim lds-ring">
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                    </div>
                                                                    {/if}
                                                                    {if $parameters.auction_info->photos}
                                                                        <div id="slider-car" class="slider-car">
                                                                            {foreach from=$parameters.auction_info->photos item=item}
                                                                            <div class="slide">
                                                                                <a id="desktop-image" class="auction-details-photo swipebox" href="/site_media/{$item->photo}/l/" data-caption="{$item->title}" title="View Image">
                                                                                    <div class="img" style="background-image: url('/site_media/{$item->photo}/m/');background-color: #000000;background-repeat: no-repeat;background-size: contain;" alt="{$item->title}"></div>
                                                                                </a>
                                                                            </div>
                                                                            {/foreach}
                                                                        </div>
                                                                        {assign var="photosCount" value=$parameters.auction_info->photos|@count}
                                                                        {if $photosCount > 1}
                                                                            <div id="next-prev-arrow">
                                                                                <span id="prev-slide" class="prev-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-p.svg" alt="Prev Slide" title="Prev Slide"/></span>
                                                                                <span id="next-slide" class="next-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-n.svg" alt="Next Slide" title="Next Slide"/></span>
                                                                            </div>
                                                                        {/if}
                                                                    {/if}
                                                                    {if !$parameters.auction_info->photos}
                                                                        <div class="slider-car slider-car-no-photo">
                                                                            <div class="slide">
                                                                                <div class="img" style="background-image: url('/images/default-car-image.png');background-color: #e3e3e3;" alt="{$item->title}"></div>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                    {if $parameters.auction_info->auction_status == "Completed" && $parameters.auction_info->auction_fake_winning_bid != "N/A"}
                                                                        <div class="soldout">sold</div>
                                                                    {/if}
                                                                </div>
                                                                {if $parameters.auction_info->auction_status == "Completed"}
                                                                    <div class="text grid-options">
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">winning bid</h5>
                                                                                    <div class="value blue" {if $parameters.auction_info->auction_fake_winning_bid == "N/A"}style="color:red;"{/if}>
                                                                                        {if $parameters.auction_info->auction_fake_winning_bid != "N/A"}${$parameters.auction_info->current_bid_price|money_format}{else}N/A{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">winning bidder</h5>
                                                                                    <div class="value blue" {if $parameters.auction_info->auction_fake_winning_bid == "N/A"}style="color:red;"{/if}>
                                                                                        {if $parameters.auction_info->auction_fake_winning_bid != "N/A"}{$parameters.auction_info->winning_user_name}{else}N/A{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title"># bids</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->count_bids}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">auction length</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auctions_length == 60}
                                                                                            1 hour
                                                                                        {else}
                                                                                            {if $parameters.auction_info->auctions_length != 0 || $parameters.auction_info->auctions_length != ""}
                                                                                                {$parameters.auction_info->auctions_length}
                                                                                            {else}
                                                                                                0
                                                                                            {/if} day{if $parameters.auction_info->auctions_length > 1}s{/if}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction started</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->datetime_create|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->datetime_create|date_format:"%I:%M:%S %Z"}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue" {if $parameters.auction_info->auction_fake_winning_bid == "N/A"}style="color:red;"{/if}>
                                                                                        {if $parameters.auction_info->auction_fake_winning_bid != "N/A"}{$parameters.auction_info->auction_completion_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->auction_completion_date|date_format:"%I:%M:%S %Z"}{else}N/A{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {elseif $parameters.auction_info->auction_status == "Active"}
                                                                    <div class="text grid-options">
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">starting bid</h5>
                                                                                    <div class="value blue">
                                                                                        ${$parameters.auction_info->starting_bid_price|money_format}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">reserve price</h5>
                                                                                    <div class="value blue">
                                                                                        ${if $parameters.auction_info->reserve_price > 0}{$parameters.auction_info->reserve_price|money_format}{else}0{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">buy now</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->buy_now_price > 0}${$parameters.auction_info->buy_now_price|money_format}{else}N/A{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">auction length</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auctions_length == 60}
                                                                                            1 hour
                                                                                        {else}
                                                                                            {if $parameters.auction_info->auctions_length != 0 || $parameters.auction_info->auctions_length != ""}
                                                                                                {$parameters.auction_info->auctions_length}
                                                                                            {else}
                                                                                                0
                                                                                            {/if} day{if $parameters.auction_info->auctions_length > 1}s{/if}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title"># saved</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->count_saved}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-3 mob-i-3">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title"># bids</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->count_bids != 0}{$parameters.auction_info->count_bids}{else}0{/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction started</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->datetime_create|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->datetime_create|date_format:"%I:%M:%S %Z"}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {elseif $parameters.auction_info->auction_status == "Refunded"}
                                                                    <div class="text grid-options">
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_status}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->refunded_date == ""}
                                                                                            {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                        {else}
                                                                                            {$parameters.auction_info->refunded_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->refunded_date|date_format:"%I:%M:%S %Z"}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {elseif $parameters.auction_info->auction_status == "Canceled"}
                                                                    <div class="text grid-options">
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_status}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auction_completion_date == ""}
                                                                                            {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                        {else}
                                                                                            {$parameters.auction_info->auction_completion_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->auction_completion_date|date_format:"%I:%M:%S %Z"}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {elseif $parameters.auction_info->auction_status == "Expired"}
                                                                    <div class="text grid-options">
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_status}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auction_completion_date == ""}
                                                                                            {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                        {else}
                                                                                            {$parameters.auction_info->auction_completion_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->auction_completion_date|date_format:"%I:%M:%S %Z"}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {/if}
                                                            </div>
                                                            <!-- button Unsold -->
                                                            {if intval($parameters.button_unsold) === 1}
                                                                <form method="POST" id="form_accept_high_bid">
                                                                    <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}"/>
                                                                    <input type="hidden" name="accept_high_bid" value="1"/>
                                                                    <button class="btn-2 blue"> Unsold </button>
                                                                </form>
                                                            {/if}
                                                            {if $parameters.auction_info->auction_status == "Active"}
                                                                <div class="share-box">
                                                                    <h5 class="title">Share auction</h5>
                                                                    <div class="addthis_inline_share_toolbox social"></div>
                                                                </div>
                                                            {/if}
                                                            {if $parameters.auction_info->auction_status == "Canceled" || $parameters.auction_info->auction_status == "Completed"|| $parameters.auction_info->auction_status == "Expired"}
                                                                <br/>
                                                                <br/>
                                                            {/if}
                                                            {if $parameters.auction_info->description}
                                                                <div class="performance-box" contenteditable="false">
                                                                     {$parameters.auction_info->description}
                                                                </div>
                                                            {/if}
                                                            {if $parameters.auction_info->description != ""}
                                                                <br/>
                                                                <br/>
                                                            {/if}
                                                            <div class="property-list">
                                                                {if $parameters.auction_info->vin_number}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-vin-number.svg" alt="Vin Number" title="Vin Number"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">vin number</h5>
                                                                        {$parameters.auction_info->vin_number}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->engine}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-engine.svg" alt="Engine" title="Engine"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">engine</h5>
                                                                        {$parameters.auction_info->engine}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->trim}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-trim.svg" alt="Trim" title="Trim"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">trim</h5>
                                                                        {$parameters.auction_info->trim}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->mpg}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mpg.svg" alt="MPG" title="MPG" />
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">MPG</h5>
                                                                        {$parameters.auction_info->mpg}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->mileage}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mileage.svg" alt="Mileage" title="Mileage"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">mileage</h5>
                                                                        {$parameters.auction_info->mileage|money_format}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->number_of_cylinders}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-cylinder.svg" alt="Number of cylinders" title="Number of cylinders"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">number of cylinders</h5>
                                                                        {$parameters.auction_info->number_of_cylinders}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->color}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-color.svg" alt="Exterior color" title="Exterior color" />
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">exterior color</h5>
                                                                        {$parameters.auction_info->color|escape}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->interior_color}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-color.svg" alt="Interior color" title="Interior color"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">interior color</h5>
                                                                        {$parameters.auction_info->interior_color|escape}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->auction_condition}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-condition.svg" alt="Condition" title="Condition" />
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">condition</h5>
                                                                        {$parameters.auction_info->auction_condition}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->transmission}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-transmission.svg" alt="Transmission" title="Transmission"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">transmission</h5>
                                                                        {$parameters.auction_info->transmission}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->fuel_type}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-fuel-type.svg" alt="fuel type" title="fuel type"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">fuel type</h5>
                                                                        {$parameters.auction_info->fuel_type}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->options}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-options.svg" alt="options" title="options"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">options</h5>
                                                                        {$parameters.auction_info->options}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->number_of_doors}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-car-doors.svg" alt="number of doors" title="number of doors"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">number of doors</h5>
                                                                        {$parameters.auction_info->number_of_doors}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->title_status}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-title.svg" alt="Title status" title="Title status"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Title status</h5>
                                                                        {if $parameters.auction_info->title_status}{$parameters.auction_info->title_status}{else}Clear{/if}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->title_wait_time}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-title.svg" alt="Title wait time" title="Title wait time"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Title wait time</h5>
                                                                        {if $parameters.auction_info->title_wait_time}{$parameters.auction_info->title_wait_time}{else}Clear{/if}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->drive_type}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mpg.svg" alt="Drive Type" title="Drive Type"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Drive Type</h5>
                                                                        {$parameters.auction_info->drive_type}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                            </div>
                                                            <div class="info-section alt">
                                                                {if $parameters.auction_info->terms_conditions}
                                                                    <div class="section-box-2">
                                                                        <div class="info-box">
                                                                            <h3 class="title">Terms & Conditions</h3>
                                                                            <div class="holder">
                                                                                {$parameters.auction_info->terms_conditions|nl2br}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {/if}
                                                                {if $parameters.auction_info->additional_fees}
                                                                    <div class="section-box-2">
                                                                        <div class="info-box">
                                                                            <h3 class="title">additional Fees</h3>
                                                                            <div class="holder">
                                                                                {$parameters.auction_info->additional_fees|nl2br}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {if $parameters.auctions_bids}
                                            <div class="toggle-block slide expanded">
                                                <div class="opener">
                                                    <div class="detail-opener">
                                                        <div class="holder">
                                                            <div class="name">Bids</div>
                                                            <span class="arr"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="slide">
                                                    <div class="container">
                                                        <div class="payment-table-holder">
                                                            <div class="payment-table">
                                                                <div class="table-header container">
                                                                    <div class="table-row">
                                                                        <div class="cell " data-number="2">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-timestamp.svg" alt="TimeStamp" title="TimeStamp"/>
                                                                                </span>
                                                                                <em>TimeStamp</em>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell " data-number="3">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-amount.svg" alt="Amount" title="Amount"/>
                                                                                </span>
                                                                                <em>Amount</em>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell " data-number="4">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-location-4.svg" alt="Location" title="Location"/>
                                                                                </span>
                                                                                <em>Location</em>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="table-body container">
                                                                    {foreach from=$parameters.auctions_bids item=bid}
                                                                    <div class="table-row {if $bid->winning_bid == 1}new{/if}  ">
                                                                        <div class="cell" data-number="2" data-text="timestamp">
                                                                            <div class="el">{$bid->datetime_create|date_format} | {$bid->datetime_create|date_format:"%H:%M:%S %Z"}</div>
                                                                        </div>
                                                                        <div class="cell" data-number="3" data-text="amount">
                                                                            <div class="el">US&nbsp; ${$bid->bid_price|money_format}</div>
                                                                        </div>
                                                                        <div class="cell {if !$bid->location}no-user-location{/if}" data-number="4" data-text="Location">
                                                                            <div class="el">{$bid->location}</div>
                                                                        </div>
                                                                    </div>
                                                                    {/foreach}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                    {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                                </div>
                            </div>
                        </div>
                        {include file="includes/main/popup_auction_cancel.tpl"}
                    {elseif ($parameters.auction_info->auction_status == "Completed" || $parameters.auction_info->auction_status == "Canceled" || $parameters.auction_info->auction_status == "Expired") && ($parameters.user->user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id || $parameters.user->user_type == "Buyer" && $parameters.auction_info->winning_user_id != $parameters.user->id || !isset($smarty.session.user))}
                        <div class="sec-holder-inner sec-holder-inner-unavailable">
                            <div class="sec-1">
                                <div class="content-box full-width">
                                    <div class="auction-detail">
                                        <div class="toggle-block slide expanded">
                                            <div class="slide">
                                                <div class="container">
                                                    <div class="border-box">
                                                        <div class="container">
                                                            <div class="content content-unavailable">
                                                                <div class="module-sold-bid">
                                                                    <div class="title">Unavailable</div>
                                                                    <p class="des">Auction has ended and is no longer available</p>
                                                                    <button type="button" class="btn-2 blue fake-link" data-link="/auctions/">browse all auctions</button>
                                                                    <figure class="img-holder img-holder-cus">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-unavailable-2.svg" alt="browse all auctions" title="browse all auctions" />
                                                                    </figure>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="slide skin-grey">
                                                <div class="container">
                                                    <div class="border-box">
                                                        <div class="container">
                                                            <div class="content ">
                                                                <div class="module-intro-box">
                                                                    <div class="img-holder" style="background-image: url('/site_media/{$item->photo}/m/');background-color: #000000;background-repeat: no-repeat;background-size: contain;" alt="{$item->title}">
                                                                        <span></span>
                                                                        {if $parameters.auction_info->auction_status == "Completed" && $parameters.auction_info->auction_fake_winning_bid != "N/A"}
                                                                            <div class="soldout">sold</div>
                                                                        {/if}
                                                                        {if $parameters.auction_info->photos}
                                                                        <div id="slider-car" class="slider-car">
                                                                            {foreach from=$parameters.auction_info->photos item=item}
                                                                                <div class="slide">
                                                                                    <a id="desktop-image" class="auction-details-photo swipebox" href="/site_media/{$item->photo}/l/" data-caption="{$item->title}" title="View Photo">
                                                                                        <div class="img" style="background-image: url('/site_media/{$item->photo}/m/');background-color: #000000;background-repeat: no-repeat;background-size: contain;" alt="{$item->title}"></div>
                                                                                    </a>
                                                                                </div>
                                                                            {/foreach}
                                                                        </div>
                                                                        {assign var="photosCount" value=$parameters.auction_info->photos|@count}
                                                                            {if $photosCount > 1}
                                                                                <div id="next-prev-arrow">
                                                                                    <span id="prev-slide" class="prev-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-p.svg" alt="prev slide" title="prev slide"/></span>
                                                                                    <span id="next-slide" class="next-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-n.svg" alt="next slide" title="next slide"/></span>
                                                                                </div>
                                                                            {/if}
                                                                        {else}
                                                                            <div class="slider-car slider-car-no-photo">
                                                                                <div class="slide">
                                                                                    <div class="img" style="background-image: url('/images/default-car-image.png');background-color: #e3e3e3;" alt="{$item->title}" title="{$item->title}"></div>
                                                                                </div>
                                                                            </div>
                                                                        {/if}
                                                                    </div>
                                                                    <div class="text grid-options">
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">winning bid</h5>
                                                                                    <div class="value {if $parameters.auction_info->auction_status == "Completed" && $parameters.auction_info->auction_fake_winning_bid == "N/A"}red{else}blue{/if}">
                                                                                        {if $parameters.auction_info->auction_status == "Completed" && $parameters.auction_info->auction_fake_winning_bid == "N/A"}
                                                                                            N/A
                                                                                        {elseif $parameters.auction_info->auction_status == "Completed"}
                                                                                            ${$parameters.auction_info->current_bid_price|money_format}
                                                                                        {elseif $parameters.auction_info->auction_status == "Canceled"}
                                                                                            Canceled
                                                                                        {elseif $parameters.auction_info->auction_status == "Expired"}
                                                                                            Expired
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ended</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auction_completion_date}
                                                                                            {$parameters.auction_info->auction_completion_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->auction_completion_date|date_format:"%I:%M:%S %Z"}
                                                                                        {else}
                                                                                            {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                                </div>
                            </div>
                        </div>
                    {else}
                        <div class="t2-top-panel-instance">
                            <div class="top-panel-auction">
                                <div class="">
                                    <div class="content">
                                        <h2 class="title">
                                            <span style="color: #0650cb;">{$parameters.auction_info->year}</span> <span class="mark"> {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span>{$parameters.auction_info->trim}&nbsp;{$parameters.auction_info->trim2}
                                        </h2>
                                        <div id="place-bid-dealer-only-auction-err" style="display: none;">
                                            <p>This is a dealer-only auction</p>
                                        </div>
                                        {if $parameters.auction_info->auction_status == "Active" && !isset($smarty.session.user)}
                                            <div class="btn place-bid">
                                                <div class="holder red">
                                                    <a class="link-box popup" data-number="5" href="javascript:void(0);"></a>
                                                        <span class="describe">
                                                            <strong class="val big">place bid</strong>
                                                        </span>
                                                    <span class="sep"></span>
                                                    <div class="ico">
                                                        <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Place Bid" title="Place Bid"/>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                        {if $parameters.auction_info->auction_status != "Completed" && $parameters.auction_info->auction_status != "Canceled" && $parameters.auction_info->auction_status != "Expired"}
                                            {if $parameters.dealers_only == "Yes"}
                                                {***
                                                <div class="buttons"><p class="auction-dealers-only">Dealer-Only Auction</p></div>
                                                ***}
                                            {else}
                                                {if $parameters.user->user_type == "Buyer" && $parameters.auction_info->auction_status != "Refunded"}
                                                    <div class="buttons">
                                                        <div class="input-holder-box">
                                                            <div class="buttons-box">
                                                                <div class="btn blue">
                                                                    <span class="describe">
                                                                        {if $parameters.auction_info->count_bids == "0"}
                                                                            {assign var=currentBid value="`$parameters.auction_info->starting_bid_price`"}
                                                                            <span class="name">Starting Bid</span>
                                                                        {else}
                                                                            {assign var=currentBid value="`$parameters.auction_info->current_bid_price`"}
                                                                            <span class="name">Current Bid</span>
                                                                        {/if}
                                                                        <strong class="val rm-custom {if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price || $parameters.auction_info->reserve_price == 0}green{else}red{/if}">${$currentBid|money_format}</strong>
                                                                        {if $parameters.auction_info->reserve_price > 0}
                                                                            <div class="{if $parameters.auction_info->winner_id == ''}text-red{elseif $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}text-green{else}text-yellow{/if}">{if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}Reserve Met{else}Reserve Not Met{/if}</div>
                                                                        {/if}
                                                                    </span>
                                                                </div>
                                                                <div class="btn green">
                                                                    <span class="describe">
                                                                        <span class="name">Time Left To Bid</span>
                                                                        <strong class="val big {if $parameters.auction_info->expiration_date_main > 0}timer{/if}" data-started="" data-left="{$parameters.auction_info->expiration_date_main}">{if $parameters.auction_info->expiration_date_main < 0}00:00:00{/if}</strong>
                                                                        <span class="det">{$parameters.auction_info->expiration_date|date_format:"%a, %I:%M%p %Z"}</span>
                                                                    </span>
                                                                </div>
                                                                {if ($parameters.user->buyer_type == "Dealer" && $parameters.auction_info->sell_to == 1) || $parameters.auction_info->sell_to == 2}
                                                                    <div class="btn">
                                                                        <div class="holder red">
                                                                            <div class="link-box popup" data-number="1" href="javascript:void(0);"></div>
                                                                            <span class="describe">
                                                                                <strong class="val big">place bid</strong>
                                                                            </span>
                                                                            <span class="sep"></span>
                                                                            <div class="ico">
                                                                                <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Bid" title="Bid"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {else}
                                                                    <div class="btn">
                                                                        <div class="holder grey" id="place-bid-dealer-only-auction">
                                                                            <div class="link-box" href="javascript:void(0);"></div>
                                                                            <span class="describe">
                                                                                <strong class="val big">place bid</strong>
                                                                            </span>
                                                                            <span class="sep"></span>
                                                                            <div class="ico">
                                                                                <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Bid" title="Bid"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {/if}
                                                            </div>
                                                            <div class="input-box">
                                                                <form class="form" action="#">
                                                                    <div class="field-block-1">
                                                                        <div class="flex">
                                                                            <input type="text" class="text" placeholder="Enter US $30,050 or more"/>
                                                                            <div class="btn blue">
                                                                                <div class="ico">
                                                                                    <img class="svg-icon-inject" src="/images/icons/racquet.svg" alt="Bid" title="Bid"/>
                                                                                </div>
                                                                                <span class="describe">
                                                                                    <span class="name">Bid</span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mobile-fixed-panel">
                                                        <div id="mobile-place-bid-dealer-only-auction-err" style="display: none;">
                                                            <p>This is a dealer-only auction</p>
                                                        </div>
                                                        <div class="holder">
                                                            <div class="btn blue">
                                                                <span class="describe">
                                                                    {if $parameters.auction_info->count_bids == "0"}
                                                                        {assign var=sellerAuctionCurrentBid value="`$parameters.auction_info->starting_bid_price`"}
                                                                        <span class="name">Starting Bid</span>
                                                                    {else}
                                                                        {assign var=sellerAuctionCurrentBid value="`$parameters.auction_info->current_bid_price`"}
                                                                        <span class="name">Current Bid</span>
                                                                    {/if}
                                                                    <strong class="val rm-custom {if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price || $parameters.auction_info->reserve_price == 0}green{else}red{/if}">${$currentBid|money_format}</strong>
                                                                    {if $parameters.auction_info->reserve_price > 0}
                                                                        <div class="{if $parameters.auction_info->winner_id == ''}text-red{elseif $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}text-green{else}text-yellow{/if}">{if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}Reserve Met{else}Reserve Not Met{/if}</div>
                                                                    {/if}
                                                                </span>
                                                            </div>
                                                            <div class="btn green">
                                                                <span class="describe">
                                                                    <span class="name">Time Left To Bid</span>
                                                                    <strong class="val big {if $parameters.auction_info->expiration_date_main > 0}timer{/if}" data-started="" data-left="{$parameters.auction_info->expiration_date_main}">{if $parameters.auction_info->expiration_date_main < 0}00:00:00{/if}</strong>
                                                                    <span class="det">{$parameters.auction_info->expiration_date|date_format:"%a, %I:%M%p %Z"}</span>
                                                                </span>
                                                            </div>
                                                            {if ($parameters.user->buyer_type == "Dealer" && $parameters.auction_info->sell_to == 1) || $parameters.auction_info->sell_to == 2}
                                                                <div class="btn open-mob-bid-input">
                                                                    <div class="holder red">
                                                                            <span class="describe">
                                                                                <strong class="val big open-bid-pop"></strong>
                                                                            </span>
                                                                        <span class="sep"></span>
                                                                        <div class="ico change">
                                                                            <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Bid" title="Bid"/>
                                                                            <img class="svg-icon-inject" src="/images/icons/cancel.svg" alt="cancel" title="cancel"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {else}
                                                                <div class="btn custom-grey-btn">
                                                                    <div class="holder grey" id="mobile-place-bid-dealer-only-auction">
                                                                            <span class="describe">
                                                                                <strong class="val big">PLACE BID</strong>
                                                                            </span>
                                                                        <span class="sep"></span>
                                                                        <div class="ico change">
                                                                            <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Bid" title="Bid"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {/if}
                                                        </div>
                                                        <div class="input-bid-mob-box">
                                                            <div class="hold-box">
                                                                <div>
                                                                    <form action="" id="mobile_popup_place_bid_form">
                                                                        <input type="hidden" name="action" value="mobile-popup-place-bid">
                                                                        <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                        <label class="title-bid">Enter Amount</label>
                                                                        <div class="input-bid-holder">
                                                                            <span>$</span>
                                                                            <input name="mobile_popup_bid_price" id="txt" type="tel" class="bid-input-field custom-number" placeholder="0" />
                                                                        </div>
                                                                        {if $parameters.auction_info->count_bids == "0"}
                                                                            {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                                        {else}
                                                                            {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                                                        {/if}
                                                                        <div class="desc">Enter ${$nextMinimumBid|money_format} or more</div>
                                                                        <p id="mobile_popup_place_bid_form_err" style="display: none;"></p>
                                                                        <button type="button" class="btn-2 place-bid-grey mobile-popup-place-bid-btn-2" data-number="7">place bid</button>
                                                                    </form>
                                                                    {if $parameters.user->user_type == "Buyer" && $parameters.auction_info->auction_status == "Active"}
                                                                        {if ($parameters.user->buyer_type == "Dealer" && $parameters.auction_info->sell_to == 1) || $parameters.auction_info->sell_to == 2}
                                                                            {if $parameters.auction_info->buy_now_price > 0 && $parameters.auction_info->current_bid_price < $parameters.auction_info->buy_now_price}
                                                                                <div class="or">or</div>
                                                                                <form method="POST" action="" id="mobile_popup_buy_now_form">
                                                                                    <input type="hidden" name="action" value="buy_now">
                                                                                    <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                                    <input type="hidden" name="mobile_buy_now_for_price" value="{$parameters.auction_info->buy_now_price|money_format}">
                                                                                    <div class="btn-buy submit-mobile-popup-buy-now" >
                                                                                        <span>buy now</span>
                                                                                        <span class="ico">
                                                                                            <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="buy now" title="buy now"/>
                                                                                        </span>
                                                                                    </div>
                                                                                </form>
                                                                                <div class="price-tip">${$parameters.auction_info->buy_now_price|money_format}</div>
                                                                            {/if}
                                                                        {/if}
                                                                    {/if}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {/if}
                                            {/if}
                                        {/if}
                                        {if $parameters.auction_info->auction_status == "Completed"}
                                            {if $parameters.auction_info->winning_user_id == $parameters.user->id}
                                                <div class="button-read green fake-link" data-link="/auctions/{$parameters.auction_info->id}/bill/">
                                                    <div class="ico">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-bill.svg" alt="read bill of sale" title="read bill of sale"/>
                                                    </div>
                                                    read bill of sale
                                                </div>
                                                <div class="mobile-fixed-panel only-show-on-mobile">
                                                    <div class="holder">
                                                        <div class="btn read fake-link" data-link="/auctions/{$parameters.auction_info->id}/bill/">
                                                            <div class="holder">
                                                                <div class="ico">
                                                                    <img class="svg-icon-inject" src="/images/icons/icon-bill.svg" alt="read bill of sale" title="read bill of sale"/>
                                                                </div>
                                                                <span class="describe">
                                                                    <strong class="val big">read bill of sale</strong>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            {/if}
                                        {/if}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sec-holder-inner">
                            <div class="sec-holder-box">
                                <div class="sec-1">
                                    <div class="baron">
                                        <div class="baron__clipper">
                                            <div class="baron__bar"></div>
                                            <div class="baron__scroller">
                                                <div class="content-box">
                                                    <div class="auction-detail">
                                                        <div class="left-contentbox">
                                                            <div class="img-holder">
                                                                <div class="holder no-overlay">
                                                                    <img src="{if $parameters.seller_info->profile_photo}/site_media/{$parameters.seller_info->profile_photo}/md/{else}/images/default-user-image.png{/if}" alt="{$parameters.seller_info->name}" title="{$parameters.seller_info->name}"/>
                                                                </div>
                                                            </div>
                                                            <h4 class="name">
                                                                {$parameters.seller_info->name|escape}
                                                                <div class="left-panel-close-button">
                                                                </div>
                                                            </h4>
                                                            <div class="seller-info">
                                                                {if $parameters.seller_info->zip != "" || $parameters.seller_info->city != "" || $parameters.seller_info->state != ""}
                                                                <div class="item">
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-location-2.svg" alt="location" title="location"/>
                                                                    </div>
                                                                    <span>{if $parameters.seller_info->city != ""}{$parameters.seller_info->city}, {/if}{$parameters.seller_info->state} {$parameters.seller_info->zip}</span>
                                                                </div>
                                                                {/if}
                                                                <div class="item">
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-miles.svg" alt="distance" title="distance"/>
                                                                    </div>
                                                                    <span>{if $parameters.seller_info->distance != "0"}{$parameters.seller_info->distance|string_format:"%d"} miles away{else}< 1 Mile Away{/if}</span>
                                                                </div>
                                                                {if isset($smarty.session.user) && $parameters.user->user_type == "Buyer"}
                                                                <div class="btn">
                                                                    <a class="btn-2 black" style="padding: 20px 19px;" href="/seller/{$parameters.seller_info->url_title}/" title="SEE ALL {$parameters.seller_info->name|escape} VEHICLES FOR SALE">SEE ALL {$parameters.seller_info->name|escape} VEHICLES FOR SALE </a>
                                                                </div>
                                                                {/if}
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
                                                    <div class="auction-detail">
                                                        <div class="content">
                                                            <div class="module-intro-box">
                                                                <div class="animation-small-load img-holder {if $parameters.auction_info->photos}slider{/if}">
                                                                    {if $parameters.auction_info->photos}
                                                                    <div class="anim lds-ring">
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                        <div></div>
                                                                    </div>
                                                                    {/if}
                                                                    {if $parameters.auction_info->auction_status != "Completed" && $parameters.auction_info->auction_status != "Canceled" && $parameters.auction_info->auction_status != "Expired" && $parameters.user->user_type == "Buyer"}
                                                                        <div class="star alt {if in_array($parameters.auction_info->id, $parameters.user_watched)} active{/if}" record-id="{$parameters.auction_info->id}">
                                                                            <img class="svg-icon-inject" src="/images/icons/star.svg" alt="user watched" title="user watched"/>
                                                                        </div>
                                                                    {/if}
                                                                    {***
                                                                    {if $parameters.auction_info->auction_status != "Completed"}
                                                                        <div class="arr"></div>
                                                                    {/if}
                                                                    ***}
                                                                    {if $parameters.auction_info->photos}
                                                                        <div id="slider-car" class="slider-car">
                                                                            {foreach from=$parameters.auction_info->photos item=item}
                                                                                <div class="slide">
                                                                                    <a id="desktop-image" class="auction-details-photo swipebox" href="/site_media/{$item->photo}/l/" data-caption="{$item->title}" title="View Photo">
                                                                                        <div class="img" style="background-image: url('/site_media/{$item->photo}/m/');background-color: #000000;background-repeat: no-repeat;background-size: contain;" alt="{$item->title}"></div>
                                                                                    </a>
                                                                                </div>
                                                                            {/foreach}
                                                                        </div>
                                                                        {assign var="photosCount" value=$parameters.auction_info->photos|@count}
                                                                        {if $photosCount > 1}
                                                                            <div id="next-prev-arrow">
                                                                                <span id="prev-slide" class="prev-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-p.svg" alt="prev slide" title="prev slide"/></span>
                                                                                <span id="next-slide" class="next-slide"><img class="svg-icon-inject" src="/images/arrows/icon-arrow-n.svg" alt="next slide" title="next slide"/></span>
                                                                            </div>
                                                                        {/if}
                                                                    {else}
                                                                        <div class="slider-car-no-photo">
                                                                            <div class="slide">
                                                                                <div class="img" style="background-image: url('/images/default-car-image.png');background-color: #e3e3e3;" alt="default-car-image" title="default-car-image"></div>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                    {if $parameters.auction_info->auction_status == "Completed"}
                                                                        <div class="soldout">sold</div>
                                                                    {/if}
                                                                </div>
                                                                <div class="text grid-options">
                                                                    {if $parameters.auction_info->auction_status == "Active"}
                                                                        {if !isset($smarty.session.user) || $parameters.user->user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id}
                                                                            <div class="item i-2 mob-i-1">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">top bid</h5>
                                                                                        <div class="value blue">
                                                                                            {if $parameters.auction_info->count_bids == "0"}
                                                                                                {assign var=currentBid value="0"}
                                                                                            {else}
                                                                                                {assign var=currentBid value="`$parameters.auction_info->current_bid_price`"}
                                                                                            {/if}
                                                                                            ${$currentBid|money_format}
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-2 mob-i-2">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">next min. bid</h5>
                                                                                        <div class="value blue">
                                                                                            {if $parameters.auction_info->count_bids == "0"}
                                                                                                {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                                                            {else}
                                                                                                {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                                                                            {/if}
                                                                                            ${$nextMinimumBid|money_format}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-2 mob-i-2">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title"># bids</h5>
                                                                                        <div class="value blue">
                                                                                            {if $parameters.auction_info->count_bids != "0"}{$parameters.auction_info->count_bids}{else}0{/if}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-2 mob-i-2">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">Auction Length</h5>
                                                                                        <div class="value blue">
                                                                                        {if $parameters.auction_info->auctions_length == 60}
                                                                                            1 hour
                                                                                        {else}
                                                                                            {if $parameters.auction_info->auctions_length != 0 || $parameters.auction_info->auctions_length != ""}
                                                                                                {$parameters.auction_info->auctions_length}
                                                                                            {else}
                                                                                                0
                                                                                            {/if} day{if $parameters.auction_info->auctions_length > 1}s{/if}
                                                                                        {/if}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-1 mob-i-1">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">Auction ends</h5>
                                                                                        <div class="value blue">
                                                                                            {$parameters.auction_info->expiration_date|date_format:"%b %d, %Y"} <span class="divider"> | </span> {$parameters.auction_info->expiration_date|date_format:"%I:%M:%S %Z"}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        {else}
                                                                            <div class="item i-2 mob-i-1">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">your bid</h5>
                                                                                        <div class="value {if $parameters.auction_info->you_are_winner == true}green{else}red{/if}">
                                                                                            {if $parameters.auction_info->user_max_bid_on_auction != ""}
                                                                                                ${$parameters.auction_info->user_max_bid_on_auction|money_format}
                                                                                            {else}
                                                                                                N/A
                                                                                            {/if}
                                                                                        </div>
                                                                                        <h5 class="title">your maximum proxy</h5>
                                                                                        <div class="value {if $parameters.auction_info->you_are_winner == true}green{else}red{/if}">
                                                                                            {if $parameters.auction_info->user_maximum_proxy_bid_on_auction != ""}
                                                                                                ${$parameters.auction_info->user_maximum_proxy_bid_on_auction|money_format}
                                                                                            {else}
                                                                                                N/A
                                                                                            {/if}
                                                                                        </div>
                                                                                        <p style="color: {if $parameters.auction_info->you_are_winner == true}#53c00b{else}red{/if}; font-weight: bold;">{if $parameters.auction_info->you_are_winner == true}You are the highest bid{else}You are not the highest bid{/if}</p>
                                                                                    </div>
                                                                                    {if $parameters.auction_info->you_are_winner == true}
                                                                                        <div class="top-sign">
                                                                                            top bid
                                                                                        </div>
                                                                                    {/if}
                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-2 mob-i-2">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title">next min. bid</h5>
                                                                                        {if $parameters.auction_info->count_bids == "0"}
                                                                                               {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                                                            {else}
                                                                                               {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                                                                            {/if}
                                                                                        <div class="value {if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price || $parameters.auction_info->reserve_price == 0}green{else}red{/if}">
                                                                                            ${$nextMinimumBid|money_format}
                                                                                        </div>
                                                                                        <div class="{if $parameters.auction_info->winner_id == ''}text-red{elseif $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}text-green{else}text-yellow{/if}">{if $parameters.auction_info->current_bid_price >= $parameters.auction_info->reserve_price}Reserve Met{else}Reserve Not Met{/if}</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="item i-5-1 mob-i-2">
                                                                                <div class="box padding">
                                                                                    <div class="inner">
                                                                                        <h5 class="title"># bids</h5>
                                                                                        <div class="value blue">
                                                                                            {$parameters.auction_info->count_bids}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            {if $parameters.user->user_type == "Buyer" && (($parameters.user->buyer_type == "Dealer" && $parameters.auction_info->sell_to == 1) || $parameters.auction_info->sell_to == 2)}
                                                                                <div class="item i-5-4 mob-i-1">
                                                                                    <div class="box">
                                                                                        <div class="input-box">
                                                                                            <form class="form" action="" id="place_bid_form">
                                                                                                <input type="hidden" name="action" value="place-bid">
                                                                                                <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                                                <div class="field-block-1">
                                                                                                    <div class="flex block-1">
                                                                                                        <label for="">Place a bid</label>
                                                                                                        {if $parameters.auction_info->count_bids == "0"}
                                                                                                            {assign var=nextMinimumBid value="`$parameters.auction_info->starting_bid_price+50`"}
                                                                                                        {else}
                                                                                                            {assign var=nextMinimumBid value="`$parameters.auction_info->current_bid_price+50`"}
                                                                                                        {/if}
                                                                                                        <input name="next_minimum_bid_value" type="hidden" value="{$nextMinimumBid}" />
                                                                                                        <span class="dollar-bid" style="display: none;">$</span>
                                                                                                        <input name="bid_price" type="tel" class="text custom-number inp-dollar" placeholder="Enter ${$nextMinimumBid|money_format} or more..." />
                                                                                                        <div class="btn-2 place-bid-grey page-bid-price" data-number="6">
                                                                                                            <span class="name">submit bid</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </form>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="item i-2 mob-i-2">
                                                                                    <form class="form form-quick-bid" action="" id="place_quick_bid_form">
                                                                                        <input type="hidden" name="action" value="place-quick-bid">
                                                                                        <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                                        <input type="hidden" name="quick_bid" value="{$nextMinimumBid|money_format}">
                                                                                        <div class="box padding text-center icon-right quick-bid-button popup" data-number="8">
                                                                                            <div class="inner">
                                                                                                <h5 class="title-big">Quick bid</h5>
                                                                                                <div class="det">${$nextMinimumBid|money_format}</div>
                                                                                            </div>
                                                                                             <span class="ico">
                                                                                                 <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Quick bid" title="Quick bid"/>
                                                                                            </span>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                                <p id="buy_now_form_err" style="display:none;"></p>
                                                                                {if $parameters.auction_info->buy_now_price > 0 && $parameters.auction_info->current_bid_price < $parameters.auction_info->buy_now_price}
                                                                                    <div class="item i-2 mob-i-2">
                                                                                        <form class="form form-buy-now" method="POST" action="" id="buy_now_form">
                                                                                            <p id="buy_now_form_err" style="display:none;color: red; font-weight: 400;text-align:center;"></p>
                                                                                            <input type="hidden" name="action" value="popup_buy_now">
                                                                                            <input type="hidden" name="auction_id" value="{$parameters.auction_info->id}">
                                                                                            <input type="hidden" name="popup_buy_now_for_price" value="{$parameters.auction_info->buy_now_price|money_format}">
                                                                                            <div class="box padding text-center  icon-right popup" data-number="3" id="buy_now_submit" {if $parameters.buy_now_off == true} style="visibility: hidden;" {/if}>
                                                                                                <div class="inner ">
                                                                                                    <h5 class="title-big">Buy now</h5>
                                                                                                    <div class="det">${$parameters.auction_info->buy_now_price|money_format}</div>
                                                                                                </div>
                                                                                                <span class="ico">
                                                                                                     <img class="svg-icon-inject" src="/images/icons/play-button.svg" alt="Buy now" title="Buy now"/>
                                                                                                </span>
                                                                                            </div>
                                                                                         </form>
                                                                                    </div>
                                                                                {/if}
                                                                            {/if}
                                                                        {/if}
                                                                    {/if}
                                                                    {if $parameters.auction_info->auction_status == "Completed"}
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">winning bid</h5>
                                                                                    <div class="value blue">
                                                                                        ${$parameters.auction_info->current_bid_price|money_format}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-2">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title 121212">buyer's fee</h5>
                                                                                    <div class="value blue">
                                                                                        {assign var=currentBidComplete value="`$parameters.auction_info->current_bid_price`"}
                                                                                        {if $parameters.auction_info->winning_buyer_fee != ""}
                                                                                            {assign var=buyersFeeComplete value="`$parameters.auction_info->winning_buyer_fee`"}
                                                                                        {else}
                                                                                            {assign var=buyersFeeComplete value="`$parameters.auction_info->current_bid_price*$parameters.auction_info->buyer_fee/100`"}
                                                                                        {/if}
                                                                                        ${$buyersFeeComplete|money_format}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Total price</h5>
                                                                                    <div class="value blue">
                                                                                        {assign var=totalPriceComplete value="`$currentBidComplete+$buyersFeeComplete`"}
                                                                                        ${$totalPriceComplete|money_format}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-5-4 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_completion_date|date_format} | {$parameters.auction_info->auction_completion_date|date_format:"%H:%M:%S %Z"}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-5-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title"># bids</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->count_bids}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                    {if $parameters.auction_info->auction_status == "Canceled"}
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_status}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {if $parameters.auction_info->auction_completion_date}
                                                                                            {$parameters.auction_info->auction_completion_date|date_format} | {$parameters.auction_info->auction_completion_date|date_format:"%H:%M:%S %Z"}
                                                                                        {else}
                                                                                            {$parameters.auction_info->expiration_date|date_format} | {$parameters.auction_info->expiration_date|date_format:"%H:%M:%S %Z"}
                                                                                        {/if}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                    {if  $parameters.auction_info->auction_status == "Expired"}
                                                                        <div class="item i-1 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h2 class="title-main"><span class="mark">{$parameters.auction_info->year} {$parameters.auction_info->make} {$parameters.auction_info->model}&nbsp;</span><em>{$parameters.auction_info->trim} {$parameters.auction_info->trim2}</em></h2>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->auction_status}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">Auction ends</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.auction_info->expiration_date|date_format} | {$parameters.auction_info->expiration_date|date_format:"%H:%M:%S %Z"}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <div class="inner">
                                                                                    <h5 class="title">seller</h5>
                                                                                    <div class="value blue">
                                                                                        {$parameters.seller_info->name}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item i-2 mob-i-1">
                                                                            <div class="box padding">
                                                                                <button class="btn-2 black stretch-btn fake-link" data-link="/seller/{$parameters.seller_info->url_title}/">view all seller auctions</button>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                </div>
                                                            </div>

                                                            <div class="performance-box text grid-options uship">
                                                                <div class="logo-uship">
                                                                    <img src="/images/UShip_logo.png" style="    width: 100px;">
                                                                </div>
                                                                {if $parameters.uship.from == ""}
                                                                    <div class="from-to"><strong>Unknown address</strong></div>
                                                                {else}
                                                                    <div class="from-to">
                                                                        <span><strong>From:</strong> {$parameters.uship.from} -  </span>
                                                                        <span><strong>To:</strong> {$parameters.uship.to}</span>
                                                                    </div>
                                                                    <div class="length"><strong>Length:</strong> {$parameters.uship.length}</div>
                                                                    <div class="uship-price"><strong>Price:</strong> {$parameters.uship.price}</div>
                                                                    {if $parameters.user->id == $parameters.auction_info->winner_id && $parameters.auction_info->auction_status == 'Canceled'}
                                                                        <div class="uship-apply"><a class="btn uship-apply-btn" href="https://www.uship.com/ship/vehicles/cars-light-trucks/create" target="_blank">Apply</a></div>
                                                                    {/if}
                                                                {/if}
                                                            </div>
                                                            {if $parameters.auction_info->auction_status != "Completed" && $parameters.auction_info->auction_status != "Canceled" && $parameters.auction_info->auction_status != "Expired"}
                                                                <div class="side-by-side-buyer-box">
                                                                    <div class="left">
                                                                        {if $parameters.auction_info->auction_status == "Active"}
                                                                            <div class="share-box">
                                                                                <h5 class="title">Share auction</h5>
                                                                                <div class="addthis_inline_share_toolbox social"></div>
                                                                            </div>
                                                                        {/if}
                                                                    </div>
                                                                    {if $parameters.user->user_type == "Buyer"}
                                                                        <div class="right">
                                                                            <div class="auction-det-box">
                                                                                <div class="item">
                                                                                    <span class="ico">
                                                                                        <img class="svg-icon-inject" src="/images/icons/star.svg" alt="add to favorites" title="add to favorites"/>
                                                                                    </span>
                                                                                    <em class="star star-detail-page{if in_array($parameters.auction_info->id, $parameters.user_watched)} active{/if}" record-id="{$parameters.auction_info->id}">{if in_array($parameters.auction_info->id, $parameters.user_watched)} remove from favorites{else}add to favorites{/if}</em>
                                                                                </div>
                                                                                <div class="item">
                                                                                    <strong>buyer fee: </strong>
                                                                                    <em>&nbsp;{$parameters.auction_info->buyer_fee}</em>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    {/if}
                                                                </div>
                                                            {/if}
                                                            {if $parameters.auction_info->auction_status == "Completed" || $parameters.auction_info->auction_status == "Canceled" || $parameters.auction_info->auction_status == "Expired"}
                                                                <br />
                                                                <br />
                                                            {/if}
                                                            {if $parameters.auction_info->description}
                                                                <div class="performance-box" contenteditable="false">
                                                                    {$parameters.auction_info->description|nl2br}
                                                                </div>
                                                                <br class="first">
                                                                <br class="first">
                                                            {/if}
                                                            <div class="property-list mob-3 last first">
                                                                {if $parameters.auction_info->vin_number && (isset($smarty.session.user) || $parameters.user->user_type == "Seller" && $parameters.user->id != $parameters.auction_info->user_id)}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-vin-number.svg" alt="vin number" title="vin number"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">vin number</h5>
                                                                        {$parameters.auction_info->vin_number}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->engine}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-engine.svg" alt="engine" title="engine"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">engine</h5>
                                                                        {$parameters.auction_info->engine}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->trim}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-trim.svg" alt="trim" title="trim"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">trim</h5>
                                                                        {$parameters.auction_info->trim}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->mpg}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mpg.svg" alt="MPG" title="MPG"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">MPG</h5>
                                                                        {$parameters.auction_info->mpg}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->mileage}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mileage.svg" alt="mileage" title="mileage"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">mileage</h5>
                                                                        {$parameters.auction_info->mileage|money_format}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->number_of_cylinders}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-cylinder.svg" alt="number of cylinders" title="number of cylinders"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">number of cylinders</h5>
                                                                        {$parameters.auction_info->number_of_cylinders}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->color}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-color.svg" alt="exterior color" title="exterior color"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">exterior color</h5>
                                                                        {$parameters.auction_info->color|escape}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->interior_color}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-color.svg" alt="interior color" title="interior color"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">interior color</h5>
                                                                        {$parameters.auction_info->interior_color|escape}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->auction_condition}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-condition.svg" alt="condition" title="condition"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">condition</h5>
                                                                        {$parameters.auction_info->auction_condition}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->transmission}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-transmission.svg" alt="transmission" title="transmission"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">transmission</h5>
                                                                        {$parameters.auction_info->transmission}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->fuel_type}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-fuel-type.svg" alt="fuel type" title="fuel type"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">fuel type</h5>
                                                                        {$parameters.auction_info->fuel_type}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->options}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-options.svg" alt="options" title="options"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">options</h5>
                                                                        {$parameters.auction_info->options}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->number_of_doors}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-car-doors.svg" alt="number of doors" title="number of doors"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">number of doors</h5>
                                                                        {$parameters.auction_info->number_of_doors}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->title_status}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-title.svg" alt="Title status" title="Title status"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Title status</h5>
                                                                        {if $parameters.auction_info->title_status}{$parameters.auction_info->title_status}{else}Clear{/if}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->title_wait_time}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-title.svg" alt="Title wait time" title="Title wait time"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Title wait time</h5>
                                                                        {if $parameters.auction_info->title_wait_time}{$parameters.auction_info->title_wait_time}{else}Clear{/if}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->drive_type}
                                                                <div class="item">
                                                                    <div class="icon">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-mpg.svg" alt="Drive Type" title="Drive Type"/>
                                                                    </div>
                                                                    <div class="text">
                                                                        <h5 class="title">Drive Type</h5>
                                                                        {$parameters.auction_info->drive_type}
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                            </div>
                                                            <div class="info-section alt last first">
                                                                {if $parameters.auction_info->terms_conditions}
                                                                <div class="section-box-2">
                                                                    <div class="info-box">
                                                                        <h3 class="title">Terms & Conditions</h3>
                                                                        <div class="holder">
                                                                            <p>{$parameters.auction_info->terms_conditions|nl2br}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                                {if $parameters.auction_info->additional_fees}
                                                                <div class="section-box-2">
                                                                    <div class="info-box">
                                                                        <h3 class="title">additional Fees</h3>
                                                                        <div class="holder">
                                                                            <p>{$parameters.auction_info->additional_fees|nl2br}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                {/if}
                                                            </div>
                                                        </div>
                                                        <div class="left-contentbox in-right-side">
                                                            <div class="img-holder">
                                                                <div class="holder no-overlay">
                                                                    <img src="{if $parameters.seller_info->profile_photo}/site_media/{$parameters.seller_info->profile_photo}/md/{else}/images/default-user-image.png{/if}" alt="{$parameters.seller_info->name}" title="{$parameters.seller_info->name}"/>
                                                                </div>
                                                            </div>
                                                            <h4 class="name">
                                                                {$parameters.seller_info->name|escape}
                                                                <div class="left-panel-close-button">
                                                                </div>
                                                            </h4>
                                                            <div class="seller-info">
                                                                {if $parameters.seller_info->zip != "" || $parameters.seller_info->city != "" || $parameters.seller_info->state != ""}
                                                                <div class="item">
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-location-2.svg" alt="location" title="location"/>
                                                                    </div>
                                                                    <span>{$parameters.seller_info->city} {if $parameters.seller_info->state}, {$parameters.seller_info->state}{/if} {$parameters.seller_info->zip}</span>
                                                                </div>
                                                                {/if}

                                                                <div class="item">
                                                                    <div class="ico">
                                                                        <img class="svg-icon-inject" src="/images/icons/icon-miles.svg" alt="distance" title="distance"/>
                                                                    </div>
                                                                    <span>{if $parameters.seller_info->distance != 0}{$parameters.seller_info->distance|string_format:"%d"} miles away{else}< 1 Mile Away{/if}</span>
                                                                </div>

                                                                {if isset($smarty.session.user) && $parameters.user->user_type == "Buyer"}
                                                                <div class="btn">
                                                                    <a class="btn-2 black" style="padding: 20px 19px;" href="/seller/{$parameters.seller_info->url_title}/" title="SEE ALL {$parameters.seller_info->name|escape} VEHICLES FOR SALE">SEE ALL {$parameters.seller_info->name|escape} VEHICLES FOR SALE </a>
                                                                </div>
                                                                {/if}
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
                                </div>
                            </div>
                        </div>
                        {include file="includes/main/popup_auction_bid_buy.tpl"}
                    {/if}
                </div>
            </main>
        </div>
    </body>
</html>
{/strip}
