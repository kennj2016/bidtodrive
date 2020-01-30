{strip}
    {if $parameters.buyer_watched_listings}
        {foreach from=$parameters.buyer_watched_listings item=item name="buyerWatchedListings"}
            <div class="item auction-id-{$item->id}" data-auction-id="{$item->id}" {if $smarty.foreach.buyerWatchedListings.last}data-load-more="1"{/if}>
                <div class="img-holder" {if $item->image}style="background-image: url('/site_media/{$item->image}/bd/');background-color: #000000;"{else}style="background-image: url('/images/default-car-image.png') !important;"{/if}>
                    {if $smarty.now < $item->expiration_date|strtotime}
                        <div class="star {if in_array($item->id, $parameters.user_favs)} active{/if}" {if !in_array($item->id, $parameters.user_favs)} style="display:none;"{/if} record-id="{$item->id}">
                            <img class="svg-icon-inject" src="/images/icons/star.svg" alt="Favs Icon" title="Favs Icon" />
                        </div>
                    {/if}
                    <a class="fake-link mobile-clickable-image" href="/auctions/{$item->id}/" style="display:none;" title="{$item->year} {$item->make} {$item->model}"></a>
                    {if $item->image}
                        <img src="/site_media/{$item->image}/ml/" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                    {else}
                        <img src="/images/default-car-image.png" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                    {/if}
                    <a class="fake-link" href="/auctions/{$item->id}/" title="{$item->year} {$item->make} {$item->model}"></a>
                    <div class="arr"></div>
                    {if $item->auction_status == "Sold"}
                        <div class="soldout">sold</div>
                    {/if}
                </div>
                <div class="text">
                    <div>
                        <a class="real-link" href="/auctions/{$item->id}/">
                            <h2 class="title" style="color: #0650cb;">{if $item->year}{$item->year}{/if}
                                <span> {$item->make} {$item->model}</span>
                            </h2>
                        </a>
                        <div class="subtitle">
                            {if $item->mileage}
                                <strong class="miles">Mileage: {$item->mileage|money_format}</strong>
                            {/if}
                            {if $item->city || $item->state}
                                <strong>{$item->city}{if $item->city && $item->state}, {/if}{$item->state}</strong>
                            {/if}
                            {if $item->distance_from_buyer_to_seller}
                                <strong>({$item->distance_from_buyer_to_seller|ceil} miles)</strong>
                            {/if}
                        </div>
                        {if $item->auction_status == "Sold"}
                            <p class="mark">Winning Bid: ${$item->current_bid_price|money_format}</p>
                        {else}
                            {if $item->auction_status != "Canceled" && $item->auction_status != "Unsold"}
                                <p>{if $item->current_bid_price < $item->starting_bid_price}Starting Bid: ${$item->starting_bid_price|money_format}{else}Current Bid: ${$item->current_bid_price|money_format}{/if}</p>
                                {if $item->current_bid_price < $item->buy_now_price && $item->buy_now_price != 0}
                                    <p class="buy-it-now-mention">Buy Now: ${$item->buy_now_price|money_format}</p>
                                {/if}
                            {/if}
                        {/if}
                        {if $item->auction_status == "Canceled"}
                            <div class="date-stamp error">{$item->auction_status}</div>
                        {elseif $item->auction_status == "Sold"}
                            <p>Date: {$item->auction_completion_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                            <div class="date-stamp bigger" data-started="">{$item->auction_status}</div>
                        {elseif $item->auction_status == "Unsold"}
                            <p>Unsold: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                            <div class="date-stamp error" data-started="">{$item->auction_status}</div>
                        {else}
                            {if $item->auction_status == "Active" && $smarty.now < $item->expiration_date|strtotime}
                                {if $item->count_down > 0}
                                    <div style="display: flex;"><span class="expires-in">Expires in:&nbsp;</span><div class="date-stamp timer" {if $item->count_down_red}style="color:red;"{/if}data-left="{$item->count_down}"></div></div>
                                {elseif $item->expiration_date_main > 0}
                                    <div style="display: flex;"><span class="expires-in">Expires in:&nbsp;</span><div class="date-stamp timer" {if $item->count_down_red}style="color:red;"{/if} data-started="" data-format="date" data-left="{$item->expiration_date_main}"></div></div>
                                {/if}
                            {/if}
                        {/if}
                    </div>
                    {if $item->auction_status == "Active" && $item->expiration_date_main > 0}
                        {*{if $item->hide_place_bid == "Hide" || $parameters.account_info->buyer_type == "Individual" && $item->sell_to == 1}*}
                        {if $item->hide_place_bid == "Hide" && $item->sell_to == 1}
                            <!-- <div id="hide_place_bid" class="btn-2 blue">DEALER ONLY AUCTION</div> -->
                            <a class="btn-2 blue" href="/auctions/{$item->id}/">
                                place bid
                            </a>
                        {elseif $item->hide_place_bid != "Hide"}
                            <a class="btn-2 blue" href="/auctions/{$item->id}/">
                                place bid
                            </a>
                        {/if}
                        {if (($parameters.account_info->buyer_type == "Dealer" && $item->sell_to == 1) || $item->sell_to == 2) && $item->buy_now_price > 0 && $item->current_bid_price < $item->buy_now_price}
                            <form class="buy_now_form" method="POST" action="">
                                <p class="buy_now_form_err" style="display:none;color: red; font-weight: 400;text-align:center;"></p>
                                <input type="hidden" name="action" value="buy_now">
                                <input type="hidden" name="auction_id" value="{$item->id}">
                                <input type="hidden" name="buy_now_for_price" value="{$item->buy_now_price|money_format}">
                                <button class="btn-2 blue icon-btn buy_now_submit">
                                    buy now for ${$item->buy_now_price|money_format}
                                </button>
                            </form>
                        {/if}
                    {/if}
                </div>
            </div>
        {/foreach}
    {else}
        <div class="content">
            <p>You haven't watched any listings yet. You can get started by seeing what's currently being offered for sale.</p>
            <a href="/auctions/" class="btn-2 blue" title="Get Started">Get Started</a>
        </div>
    {/if}
{/strip}
