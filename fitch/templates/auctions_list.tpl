{strip}
    {if $parameters.records}
        {assign var="user" value=""}
        {if $parameters.user}
            {assign var="user" value=$parameters.user}
        {elseif $smarty.session.user}
            {assign var="user" value=$smarty.session.user}
        {/if}
        {foreach from=$parameters.records item=item name="auctions"}
            <div class="item auction-id-{$item->id} {if count($parameters.records) == 1} add-height{/if}"  data-auction-status="{$item->auction_status}" data-auction-id="{$item->id}" {if $smarty.foreach.auctions.last}data-load-more="1"{/if}>
                <div class="img-holder" {if $item->image}style="background-image: url('/site_media/{$item->image}/bd/');background-color: #fff;background-repeat: no-repeat;background-size: contain; display: flex; align-items: center; justify-content: center; justify-items: center;min-height: 207px;"{else}style="min-height: 207px;background-image: url('/images/default-car-image.png') !important; display: flex; align-items: center; justify-content: center; justify-items: center;"{/if}>
                    <span class="absolute-year">{$item->year}</span>
                    {if $item->auction_status == "Active" && $smarty.now < $item->expiration_date|strtotime}
                        {if $user && $user->user_type == 'Buyer'}
                            <div class="star {if in_array($item->id, $parameters.user_favs)}active{/if}" record-id="{$item->id}">
                                <img class="svg-icon-inject" src="/images/icons/star.svg" alt="user favs" title="user favs"/>
                            </div>
                        {/if}
                    {/if}
                    {if !isset($smarty.session.user)}
                        <a class="fake-link mobile-clickable-image" href="/login/?redirect=/auctions/{$item->id}/" style="display:none;" title="{$item->year} {$item->make} {$item->model}"></a>
                    {else}
                        <a class="fake-link mobile-clickable-image" href="/auctions/{$item->id}/" style="display:none;" title="{$item->year} {$item->make} {$item->model}"></a>
                    {/if}
                    {if $item->image}
                        <img style="width: auto !important;" onerror="this.onerror=null; this.src='/images/default-car-image.png'" src="/site_media/{$item->image}/bd/" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                    {else}
                        <img style="width: auto !important;" style="margin-top:20px;" src="/images/default-car-image.png" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                    {/if}
                    {if !isset($smarty.session.user)}
                        <a class="fake-link" href="/login/?redirect=/auctions/{$item->id}/" title="{$item->year} {$item->make} {$item->model}"></a>
                    {else}
                        <a class="fake-link" href="/auctions/{$item->id}/" title="{$item->year} {$item->make} {$item->model}"></a>
                    {/if}
                    <div class="arr"></div>
                </div>
                <div class="text">
                    <div class="">
                        {if !isset($smarty.session.user)}
                            <a class="real-link" href="/login/?redirect=/auctions/{$item->id}/" title="Auction Details"><h2 class="title" style="color: #0650cb;">
                        {else}
                            <a class="real-link" href="/auctions/{$item->id}/" title="Auction Details"><h2 class="title" style="color: #0650cb;">
                        {/if}
                            {if $item->year}{$item->year}{/if} <span>{$item->make} {$item->model}</span>

                        </h2></a>
                        <div class="subtitle">
                            {if $item->mileage}
                                <strong class="miles">Mileage: {$item->mileage|money_format}</strong>
                            {/if}
                            {if $item->city || $item->state}
                                <strong>{$item->city}{if $item->city && $item->state}, {/if}{$item->state}</strong>
                            {/if}
                            {if $item->distance_from_buyer_to_seller && $user->user_type == 'Buyer'}
                                <strong>({$item->distance_from_buyer_to_seller|ceil} miles)</strong>
                            {/if}
                        </div>
                        {if $item->auction_status == "Sold"}
                            <p class="mark">Winning Bid: ${$item->current_bid_price|money_format}</p>
                        {else}
                            {if $item->auction_status != "Canceled" && $item->auction_status != "Expired"}
                                <p>{if $item->current_bid_price == 0}Starting Bid: ${$item->starting_bid_price|money_format}{/if}</p>
                                {if $item->current_bid_price < $item->buy_now_price && $item->buy_now_price != 0}
                                    <p class="buy-it-now-mention">Buy Now: ${$item->buy_now_price|money_format}</p>
                                {/if}
                            {/if}
                        {/if}
                        {if $item->auction_status == "Sold"}
                            <p>Date: {$item->auction_completion_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                            <div class="date-stamp bigger" data-started="">{$item->auction_status}</div>
                        {/if}
                        <!-- {$item->expiration_date} -->
                        {if $item->auction_status == "Canceled"}
                            <!-- <p>Cancellation date: {$item->auction_completion_date|date_format:"%D"}</p> -->
                            <div class="date-stamp error">{$item->auction_status}</div>
                        {else}
                            {if $item->auction_status == "Active" && $smarty.now < $item->expiration_date|strtotime}
                                {if $item->count_down}
                                    {if $item->count_down > 0}<div class="date-stamp timer" {if $item->count_down_red}style="color:red;"{/if} data-started="" data-left="{$item->count_down}"></div>{/if}
                                {else}
                                    {if $item->auction_status != "Sold" }
                                    <div class="date-stamp timer" {if $item->count_down_red}style="color:red;"{/if} data-started="" data-format="date" data-left="{$item->expiration_date_main}"></div>
                                    {/if}
                                {/if}
                            {/if}
                        {/if}
                        {if $item->auction_status == "Expired"}
                            <p>Expired: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                            <div class="date-stamp error">Expired</div>
                        {/if}
                    </div>
                    {if $user && $item->auction_status == "Active" && $smarty.now < $item->expiration_date|strtotime}
                        {if ($user->user_type == "Buyer" || $item->user_id != $user->id) && $item->auction_status == "Active" && $item->expiration_date_main > 0}
                            {if $user && $user->user_type == 'Buyer'}
                                {*{if $item->hide_place_bid == "Hide" || $user->buyer_type == "Individual" && $item->sell_to == 1}*}
                                {if $item->hide_place_bid == "Hide" && $item->sell_to == 1}
                                    <div id="hide_place_bid" class="btn-2 blue">DEALER ONLY AUCTION</div>
                                {elseif $item->hide_place_bid != "Hide"}
                                    <a class="btn-2 blue" href="/auctions/{$item->id}/">place bid {if $item->current_bid_price == 0}${$item->starting_bid_price+50|money_format}{else}${$item->current_bid_price+50|money_format}{/if} </a>
                                {/if}

                                {if $item->auction_status == "Active" && (($item->sell_to == 1) || $item->sell_to == 2) && $item->buy_now_price > 0 && $item->current_bid_price < $item->buy_now_price}
                                    <form class="buy_now_form" method="POST" action="">
                                        <p class="buy_now_form_err" style="display:none;color: red; font-weight: 400;text-align:center;"></p>
                                        <input type="hidden" name="action" value="buy_now">
                                        <input type="hidden" name="auction_id" value="{$item->id}">
                                        <input type="hidden" name="buy_now_for_price" value="{$item->buy_now_price|money_format}">
                                        <!-- {if $flag_discount == 2} -->
                                        <button class="btn-2 blue icon-btn buy_now_submit">
                                            buy now for ${$item->buy_now_price|money_format}
                                        </button>
                                        <!-- {else}
                                          <button class="btn-2 blue icon-btn buy_now_submit">
                                              buy now discount <del style="color:red">${$item->this_price|money_format} </del> ${$item->buy_now_price|money_format}
                                          </button>
                                        {/if} -->

                                    </form>
                                {/if}
                            {/if}

                        {/if}
                    {/if}
                    {if !isset($smarty.session.user)}
                        <div class="btn-2 blue fake-link" data-link="/login/?redirect=/auctions/{$item->id}/">Login to view</div>
                    {/if}
                </div>
            </div>
        {/foreach}
    {else}
        <h3>No records found matching your search criteria.</h3>
    {/if}
{/strip}
{if $parameters.count_pages}
    <div class="row flex no-gutters">
        <div class="container flex-h-center">
            <div class="col-24">
                <div class="pagination pagination-custom">
                    <div class="container">
                        <a data-page="{$parameters.page-1}" href="{if $parameters.page == 1}#{else}/auctions?page={$parameters.page-1}{/if}" title="prev" class="prev {if $parameters.page == 1}disabled{/if}">
                            <img class="svg-icon-inject" src="/images/icons/left-arrow.svg" alt="Prev Article" title="Prev Article" />
                        </a>
                        <input readonly="" type="text" class="number" value="{$parameters.page}"/>
                        <a data-page="{$parameters.page+1}" title="next" href="{if $parameters.page == $parameters.count_pages}#{else}/auctions?page={$parameters.page+1}{/if}" class="next {if $parameters.page == $parameters.count_pages}disabled{/if}">
                            <img class="svg-icon-inject" src="/images/icons/right-arrow.svg" alt="Next Article" alt="Next Article"/>
                        </a>
                        <span class="of">
                <span>of</span>
                <mark>{$parameters.count_pages}</mark>
                </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}
