{strip}
{foreach from=$parameters.payments item=item}
    <div class="table-row fake-link" data-link="/auctions/{$item->auction_id}/bill/">
        <div class="cell" data-number="1"
             data-text="Car: Model & year">
            <div class="flex">
                <div class="img-holder" style="background-image: url('{if $item->auction_image}/site_media/{$item->auction_image}/m/{else}/images/default-car-image-small.png{/if}')"></div>
                <span class="el" data-sort="{$item->auction_year}">{$item->auction_year} - {$item->auction_make|escape} {$item->auction_model|escape} </span>
            </div>
        </div>
        <div class="cell" data-number="2" data-text="timestamp">
            <div class="el" data-sort="{$item->datetime|@strtotime}">{$item->datetime|date_format} | {$item->datetime|date_format:"%H:%M:%S %Z"}</div>
        </div>
        <div class="cell" data-number="3" data-text="buyer Fee">
            <div class="el" data-sort="{$item->buyer_fee}">
                ${$item->buyer_fee_formatted}
            </div>
        </div>
        <div class="cell" data-number="4"
             data-text="Amount">
            <div class="flex">
                <div class="el"
                     data-sort="{$item->sale_price}">
                    ${$item->sale_price_formatted}
                </div>
                <div class="ico">
                    <img class="svg-icon-inject" src="/images/icons/icon-view.svg" alt="" title="View" />
                </div>
            </div>
        </div>
    </div>
{/foreach}
{/strip}
