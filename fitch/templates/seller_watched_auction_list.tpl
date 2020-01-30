{strip}
{if $parameters.auctions}

    <div id="flag1"></div>
    <div class="baron-table">
        <div class="baron__clipper">
            <div class="payment-table-holder baron__scroller">
                <div class="baron__bar"></div>
                <div class="payment-table-scroll-holder" style="margin-bottom: 0px;">
                <div class="payment-table" style="width: calc(100% - 10px);margin: 0px 10px 0px 0px;">
                    <div class="table-header">
                        <div class="table-row">
                            <div class="cell" data-number="1">
                                <div class="item" style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">
                                    <span class="ico left">
                                        <img class="svg-icon-inject" src="/images/icons/icon-carmodel.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                    </span>
                                    <em>Car: Model & Year</em>
                                    <!-- <span class="ico right">
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                    </span> -->
                                </div>
                            </div>
                            <div class="cell" data-number="2">
                                <div class="item"  style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">
                                    <span class="ico left">
                                        <img class="svg-icon-inject" src="/images/icons/icon-timestamp.svg" alt="Date" title="Date" />
                                    </span>
                                    <em>Date</em>
                                    <!-- <span class="ico right">
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Date" title="Date" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Date" title="Date" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Date" title="Date" />
                                    </span> -->
                                </div>
                            </div>
                            <div class="cell" data-number="3">
                                <div class="item" style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">
                                    <span class="ico left">
                                        <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Bid" title="Bid" />
                                    </span>
                                    <em>Bid</em>
                                    <!-- <span class="ico right">
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Bid" title="Bid" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Bid" title="Bid" />
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Bid" title="Bid" />
                                    </span> -->
                                </div>
                            </div>
                            <div class="cell" data-number="4">
                                <div class="item" style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">

                                    <em>Price</em>

                                </div>
                            </div>
                            <!-- {if $item->auction_status != "Unsold" && $item->auction_status != "Canceled" && $item->auction_status != "Sold" }
                            <div class="cell orderBnt" data-number="5">
                                <div class="item" style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">

                                    <em>Status</em>

                                </div>
                            </div>
                            {/if} -->


                            <div class="cell" data-number="4">
                                <div class="item" style="width: 100%; max-width: 100%; padding: 0px; margin: 0px; display: flex; justify-content: center; justify-items: center; align-items: center;">

                                    <em>Action</em>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="table-body">

                        {foreach from=$parameters.auctions item=item name="auctions"}
                            <div class="table-row " data-auction-status="{$item->auction_status}" {if $smarty.foreach.auctions.last}data-load-more="1"{/if} >

                                <div class="cell"  data-number="1" >
                                    <div class="" style="display : flex ; justify-content: flex-start; flex-direction: row; align-items: center;">
                                          <div class="img-holder" {if $item->image}style="background-image: url('/site_media/{$item->image}/m/'); background-color: #000000;background-repeat: no-repeat;background-size: contain;width  :100px;height:100px;max-width : 100px;min-height:100px;flex: 1 0 0;"{else}style="width  :100px;height:100px;max-width : 100px;min-height:100px;background-image: url('/images/default-car-image.png') !important; flex: 1 0 0;"{/if}>
                                              {if $item->auction_status != "Completed" && $item->auction_status != "Expired" && $item->count_bids == 0}
                                                  <a class="auction-edit edit-btn alt" href="/auctions/{$item->id}/edit/" title="auction edit">
                                                      <img class="svg-icon-inject" src="/images/icons/checkbox-pen-outline.svg" alt="" />
                                                  </a>
                                              {/if}
                                              <a class="mobile-clickable-image" href="/auctions/{$item->id}/" style="display:none;" title="Auction Car"></a>
                                              {if $item->image}
                                                  <img src="/site_media/{$item->image}/m/" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                                              {else}
                                                  <img src="/images/default-car-image.png" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}"/>
                                              {/if}
                                              <a href="/auctions/{$item->id}/" title="{$item->year} {$item->make} {$item->model}"></a>
                                              <div class="arr"></div>
                                              {if $item->auction_status == "Completed"}
                                                  <div class="soldout">sold</div>
                                              {/if}

                                          </div>
                                          <a class="real-link" href="/auctions/{$item->id}/" style="flex: 2 0 0;">
                                              <h2 class="title" style="color: #0650cb;font-size: 18px;">{if $item->year}{$item->year}{/if}  <span>{$item->make} {$item->model}</span></h2>
                                          </a>
                                          <!-- <div class="subtitle">
                                              {if $item->mileage}
                                                  <strong class="miles">Mileage: {$item->mileage|money_format}</strong>
                                              {/if}
                                              {if $item->city || $item->state}
                                                  <strong>{$item->city}{if $item->city && $item->state}, {/if}{$item->state}</strong>
                                              {/if}
                                              {if $item->distance}
                                              <span class="mi">{$item->distance|money_format} mi</span>
                                              {/if}
                                          </div> -->
                                    </div>
                                </div>
                                <div style="padding-top:0px !important;" class="cell" data-number="2">
                                  {if $item->auction_status == "Expired"}
                                      <p>Expired: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                                  {/if}

                                  {if $item->auction_status == "Completed" || $item->auction_status == "Sold"}
                                      <p>Date: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                                  {/if}
                                  {if $item->auction_status == "Canceled"}
                                      <p>Ended: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>

                                  {else}
                                      {if $item->auction_status == "Active" && $smarty.now < $item->expiration_date|strtotime}
                                          {if $item->auction_status != "Completed" && $item->auction_status != "Expired"}
                                              {if $item->count_down}
                                                  {if $item->count_down > 0}<div  class="date-stamp timer" {if $item->count_down_red}style="    font-size: 18px;color:red;"{else}style="    font-size: 18px;"{/if} data-started="" data-left="{$item->count_down}"></div>{/if}
                                              {else}
                                                  <div class="date-stamp timer" {if $item->count_down_red}style="color:red;font-size: 18px;"{else}style="    font-size: 18px;"{/if} data-started="" data-format="date" data-left="{$item->expiration_date_main}"></div>
                                              {/if}
                                          {/if}
                                      {/if}
                                  {/if}

                                </div>

                                <div style="padding-top:0px !important;" class="cell" data-number="3" >
                                    <div class="el" >

                                            <p>Bids: {$item->count_bids}</p>

                                    </div>
                                </div>

                                <div style="padding-top:0px !important;" class="cell " data-number="4" >
                                    <div class="el">
                                        {if $item->auction_status == "Completed" || $item->auction_status == "Sold"}
                                            <p class="mark">Winning Bid: ${$item->current_bid_price|money_format}</p>
                                        {else}
                                            {if $item->auction_status != "Canceled" && $item->auction_status != "Expired"}
                                                <p>Current Bid: {if $item->current_bid_price == 0}<span style="color: red">${$item->starting_bid_price+50|money_format}</span> {else}<span style="{if $item->current_bid_price >= $item->reserve_price}color: rgb(83, 192, 11){else}color: red{/if}">${$item->current_bid_price|money_format}</span>{/if}</p>
                                                {if $item->current_bid_price < $item->buy_now_price && $item->buy_now_price > 0}
                                                    <p>Buy Now: ${$item->buy_now_price|money_format}</p>
                                                {else}
                                                    <p>Buy Now: N/A</p>
                                                {/if}
                                            {else}
                                                <p>Max Bid: ${$item->current_bid_price|money_format}</p>
                                            {/if}
                                        {/if}
                                    </div>
                                </div>

                                <!-- <div style="padding-top:0px !important;" class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="5" >
                                    <div class="el">
                                        {if $item->auction_status == "Canceled"}
                                            Unsold
                                        {else}
                                            {$item->auction_status}
                                        {/if}
                                    </div>
                                </div> -->


                                <div style="padding-top:0px !important;" class="cell" data-number="5" >
                                    {if $item->auction_status != "Completed" && $item->auction_status != "Expired" && $item->count_bids == 0}
                                        <div style="margin-right: 10px;" class="btn-2 blue fake-link" data-link="/auctions/{$item->id}/edit/">edit</div>
                                    {/if}
                                    {if $item->auction_status == "Expired"}
                                        {if $item->count_bids > 0}
                                            <p class="mark bid-not-green">Final Bid: ${$item->current_bid_price|money_format}</p>
                                            <p>Bids: {$item->count_bids}</p>
                                        {/if}
                                        <p>Expired: {$item->expiration_date|date_format:"%b %d, %Y %I:%M:%S %Z"}</p>
                                        <div class="date-stamp error">Expired</div>
                                    {/if}
                                    {if $item->auction_status == "Canceled" || $item->auction_status == "Expired"}
                                        <a  style="margin-right: 10px;"  class="btn-2 blue" id="auction-relist" data-id="{$item->id}" href="/auctions/{$item->id}/relist/">relist</a>

                                    {/if}
                                    {if $item->show_accept == 1 && $item->auction_status == "Canceled"}
                                    <a  style="margin-right: 10px;"  class="btn-2 blue" id="auction-relist" data-id="{$item->id}" href="javascript:acceptAuction({$item->id} , '${$item->higher_price|money_format}');">accept highest bid ${$item->higher_price|money_format}</a>
                                    {/if}
                                    {if $item->auction_status == "Sold" && $item->buyer != 0}
                                    <a  style="margin-right: 10px;"  class="btn-2 blue" id="auction-relist" data-id="{$item->id}" href="/auctions/{$item->id}/bill/">View invoice</a>
                                    {/if}

                                </div>

                                <input type="hidden" id="auction-id-{$item->id}" data-id="{$item->id}">
                                <input type="hidden" id="vin-number-{$item->id}" data-vin_number="{$item->vin_number}">
                                <input type="hidden" id="make-{$item->id}" data-make="{$item->make}">
                                <input type="hidden" id="model-{$item->id}" data-model="{$item->model}">
                                <input type="hidden" id="year-{$item->id}" data-year="{$item->year}">
                                <input type="hidden" id="engine-{$item->id}" data-engine="{$item->engine}">
                                <input type="hidden" id="number_of_cylinders-{$item->id}" data-number_of_cylinders="{$item->number_of_cylinders}">
                                <input type="hidden" id="number_of_doors-{$item->id}" data-number_of_doors="{$item->number_of_doors}">
                                <input type="hidden" id="trim-{$item->id}" data-trim="{$item->trim}">
                                <input type="hidden" id="trim2-{$item->id}" data-trim2="{$item->trim2}">
                                <input type="hidden" id="fuel_type-{$item->id}" data-fuel_type="{$item->fuel_type}">
                                <input type="hidden" id="fuel_type-{$item->id}" data-fuel_type="{$item->fuel_type}">
                                <input type="hidden" id="options-{$item->id}" data-options="{$item->options}">
                                <input type="hidden" id="mpg-{$item->id}" data-mpg="{$item->mpg}">
                                <input type="hidden" id="image-{$item->id}" data-image="{$item->image}">


                            </div>


                        {/foreach}

                        {foreach from=$parameters.auctions item=item}
                        <div class="table-view-all" id="view-buyer-{$item->id}" >
                            <span class="close" onclick="close_popup_view_buyer();">
                              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 21.9 21.9" enable-background="new 0 0 21.9 21.9" width="512px" height="512px" class="svg-icon-inject replaced-svg">
                                <path class="ic" d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z" fill="#FFFFFF"></path>
                              </svg>
                            </span>
                            <div class="baron-table">
                                <div class="baron__clipper" style="height:100% !important;">
                                    <div class="payment-table-holder baron__scroller">
                                        <div class="baron__bar"></div>
                                        <div class="payment-table-scroll-holder">
                                        <div class="payment-table">
                                            <div class="table-header">
                                                <div class="table-row">
                                                    <div class="cell orderBnt" data-number="1">
                                                        <div class="item">
                                                            <em>Buyer Name</em>
                                                        </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer Email</em>
                                                      </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer Phone</em>
                                                      </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer Address</em>
                                                      </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer City</em>
                                                      </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer State</em>
                                                      </div>
                                                    </div>
                                                    <div class="cell orderBnt" data-number="1">
                                                      <div class="item">
                                                          <em>Buyer Zip</em>
                                                      </div>
                                                    </div>






                                                </div>
                                            </div>
                                            <div class="table-body">

                                                    <div class="table-row" >
                                                        <div class="cell fake-link" data-number="1" data-text="Buyer Name">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_name}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link" data-number="1" data-text="Buyer Email">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_email}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link" data-number="1" data-text="Buyer Phone">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_phone}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link"  data-number="1" data-text="Buyer Address">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_address}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link"  data-number="1" data-text="Buyer City">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_city}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link"  data-number="1" data-text="Buyer State">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_state}</p>
                                                            </div>
                                                        </div>
                                                        <div class="cell fake-link"  data-number="1" data-text="Buyer Name">
                                                            <div class="flex">
                                                                <p>{$item->buyer->buyer_zip}</p>
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
                        {/foreach}

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div id="flag2"></div>

{else}
  <div class="no-sellers-auctions">
        <p>You haven't created any auctions yet. You can get started by creating an auction here.</p>
        <div class="btn-2 blue fake-link" data-link="/auctions/create/">Create Auction</div>
    </div>
{/if}
{/strip}
