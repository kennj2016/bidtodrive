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
                                    <a href="/account/listings/" class="item btn {if !($parameters.cmd == "auctions_edit" || $parameters.action == "create" || $parameters.action == "account_info" || $parameters.action == "account_content_blocks" || $parameters.cmd == "account_security_access")}active{/if}" id="my-listings-btn" title="My listings">
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
        <div class="loadding_">
          <div class="loader loader--style1" title="0">
                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                  s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                  c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                  C22.32,8.481,24.301,9.057,26.013,10.047z" fill="#fff">
                  <animateTransform attributeType="xml"
                    attributeName="transform"
                    type="rotate"
                    from="0 20 20"
                    to="360 20 20"
                    dur="0.5s"
                    repeatCount="indefinite"/>
                  </path>
                </svg>
            </div>
        </div>
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
                                        {if $parameters.action == "edit"}
                                        {if $parameters.record->make != "" || $parameters.record->model != ""}
                                        Edit {$parameters.record->make} {$parameters.record->model}{if $parameters.record->year != ""} - {$parameters.record->year}{/if}
                                        {else}
                                        Edit Auction
                                        {/if}
                                        {elseif $parameters.action == "relist"}
                                        Relist Auction
                                        {else}
                                        Create Auction
                                        {/if}
                                    </span>
                                </h4>
                                {if $parameters.has_license_error}
                                    <div class="content content-license-expired">
                                        <div class="listing-1 balancer gridview">
                                            <div class="content last first">
                                              <p>{$parameters.license_status}</p>
                                            </div>
                                        </div>
                                    </div>
                                {else}
                                    {if !$parameters.has_error}
                                    <div id="auction_steps" class="subpage no-padding">
                                        <div class="module-steps">
                                            <div class="item first-item active" data-number="1">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="" title="Price"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="Price" title="Price"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>Price</span>
                                                </div>
                                            </div>
                                            <div class="item second-item" data-number="2">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="VIN Specs" title="VIN Specs"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="VIN Specs" title="VIN Specs"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>VIN Specs</span>
                                                </div>
                                            </div>
                                            <div class="item third-item" data-number="3">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="More Specs" title="More Specs"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="More Specs" title="More Specs"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>More Specs</span>
                                                </div>
                                            </div>
                                            <div class="item fourth-item" data-number="4">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="Terms" title="Terms"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="Terms" title="Terms"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>Terms</span>
                                                </div>
                                            </div>
                                            <div class="item fifth-item" data-number="5">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="Confirm" title="Confirm"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="Confirm" title="Confirm"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>Photos</span>
                                                </div>
                                            </div>
                                            <div class="item sixth-item" data-number="6">
                                                <div class="icon-holder">
                                                    <span class="ico ico-step">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-wheel.svg" alt="Confirm" title="Confirm"/>
                                                    </span>
                                                    <span class="ico ico-done">
                                                        <img class="svg-icon-inject" src="/images/icons/icon-circle-check.svg" alt="Confirm" title="Confirm"/>
                                                    </span>
                                                </div>
                                                <div class="text">
                                                    <span>Confirm</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inner-subpage-box">
                                            <div class="sub-sub-page active" data-number="1" id="step-1-tab">
                                                <div class="module-create-edit">
                                                    <form action="" class="form" id="step-1">
                                                        <input type="hidden" name="step" value="1">
                                                        <div class="field-block-1">
                                                            <div class="block-1">
                                                                <h4 class="step-title">Price</h4>
                                                                <p>Get started by entering pricing details and the VIN number of the car that you are selling</p>
                                                            </div>
                                                            <div class="block-4 label-holder price-field" id="reserve_price">
                                                                <label class="small">Reserve Price <span class="auction-required-field"> *</span></label>
                                                                <input required type="tel" class="text custom-number" name="reserve_price" value="{$parameters.record->reserve_price}"/>
                                                            </div>
                                                            <div class="block-4 label-holder price-field" id="starting_bid_price">
                                                                <label class="small">Starting Bid Price<span class="auction-required-field"> *</span></label>
                                                                <input required type="tel" class="text custom-number" name="starting_bid_price" value="{$parameters.record->starting_bid_price}"/>
                                                                <span class="icon" id="err-starting_bid_price" style="display: none;">
                                                                    <img class="svg-icon-inject" src="/images/icons/icon-exclamation.svg" alt="Starting Bid Price" title="Starting Bid Price"/>
                                                                </span>
                                                            </div>
                                                            <div class="block-4 label-holder price-field" id="buy_now_price">
                                                                <label class="small">Buy Now Price </label>
                                                                <input type="tel" class="text custom-number" name="buy_now_price" value="{if $parameters.record->buy_now_price > 0}{$parameters.record->buy_now_price}{else}{/if}"/>
                                                            </div>
                                                            <div class="block-4 label-holder"  id="auctions_length">
                                                                <label class="small">Auction Length<span class="auction-required-field"> *</span></label>
                                                                <select class="select-3" name="auctions_length">
                                                                    <option value="60" {if $parameters.record->auctions_length == 60}selected="selected"{/if}>1 Hour</option>
                                                                    <option value="1" {if $parameters.record->auctions_length == 1}selected="selected"{/if}>1 Day</option>
                                                                    <option value="3" {if $parameters.record->auctions_length == 3}selected="selected"{/if}>3 Days</option>
                                                                    <option value="5" {if $parameters.record->auctions_length == 5}selected="selected"{/if}>5 Days</option>
                                                                </select>
                                                                <span class="icon" id="err-auctions_length" style="display: none;">
                                                                    <img class="svg-icon-inject" src="/images/icons/icon-exclamation.svg" alt="Auction Length" title="Auction Length"/>
                                                                </span>
                                                            </div>

                                                            <div class="block-1 label-holder">
                                                                <label class="small">VIN Number<span class="auction-required-field"> *</span></label>
                                                                <input type="text" class="text" name="vin_number" value="{$parameters.record->vin_number}"/>
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <a style="display:none" title="Next" href="javascript:void(0);" class="btn-2 blue submit-right always-right" id="step-1-submit">next</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sub-sub-page" data-number="2" id="step-2-tab">
                                                <div class="module-create-edit">
                                                    <form action="#" class="form" id="step-2">
                                                        <input type="hidden" name="step" value="2">
                                                        <div class="field-block-1">
                                                            <div class="block-1">
                                                                <h4 class="step-title">VIN Specs</h4>
                                                                <p>Please confirm these specifications that we have looked up from VIN number records</p>
                                                            </div>
                                                            <div class="block-1 label-holder">
                                                                <label class="small">VIN Number</label>
                                                                <input disabled type="text" id="s2-vin_number" class="text" name="s2_vin_number" disabled="disabled" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Make</label>
                                                                <input type="text" id="s2-make" class="text" name="s2_make" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->make}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Model</label>
                                                                <input type="text" id="s2-model" class="text" name="s2_model" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->model}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Year</label>
                                                                <input type="tel" id="s2-year" class="text" name="s2_year" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->year}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Engine</label>
                                                                <input type="text" id="s2-engine" class="text" name="s2_engine" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->engine}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small"># of Cylinders</label>
                                                                <input type="tel" id="s2-cylinders" class="text" name="s2_number_of_cylinders" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->number_of_cylinders}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Number of Doors</label>
                                                                <input type="tel" id="s2-number_of_doors" class="text" name="s2_number_of_doors" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->number_of_doors}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Trim</label>
                                                                <input type="text" id="s2-trim" class="text" name="s2_trim" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->trim}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Trim 2</label>
                                                                <input type="text" id="s2-trim2" class="text" name="s2_trim2" {if $parameters.action != "create"}disabled="disabled"{/if} value="{$parameters.record->trim2}"/>
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <div class="full-width">
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-left always-left switchSubSubPage" id="first-preview" data-number="2" title="previous">previous</a>
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-right always-right" data-number="2" id="step-2-submit" title="next">next</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sub-sub-page" data-number="3" id="step-3-tab">
                                                <div class="module-create-edit">
                                                    <form action="" class="form" id="step-3">
                                                        <input type="hidden" name="step" value="3">
                                                        <div class="field-block-1">
                                                            <div class="block-1">
                                                                <h4 class="step-title">More Specs</h4>
                                                                <p>Add in any other details about the car that buyers may find useful</p>
                                                            </div>
                                                            <div class="block-3 label-holder not-visible-multiple-select-items">
                                                                <label class="small">Exterior Color</label>
                                                                <select id="color-selectize-2" name="s3_color">
                                                                    <option value=""></option>
                                                                    {foreach from=$parameters.exterior_colors key=key item=item}
                                                                    <option value="{$key}" {if $parameters.record->color == $key} selected="selected"{/if}>{$item}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder not-visible-multiple-select-items">
                                                                <label class="small">Interior Color</label>
                                                                <select id="custom-color-selectize-2" name="s3_interior_color">
                                                                    <option value=""></option>
                                                                    {foreach from=$parameters.interior_colors key=key item=item}
                                                                    <option value="{$key}" {if $parameters.record->interior_color == $key} selected="selected"{/if}>{$item}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Condition</label>
                                                                <select class="select-3" name="s3_auction_condition">
                                                                    <option value=""></option>
                                                                    <option value="Runs & Drives" {if $parameters.record->auction_condition == "Runs & Drives"}selected="selected"{/if}>Runs & Drives</option>
                                                                    <option value="Must be towed"{if $parameters.record->auction_condition == "Must be towed"}selected="selected"{/if}>Must be towed</option>
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Mileage<span class="auction-required-field"> *</span></label>
                                                                <input type="tel" class="text custom-number" name="s3_mileage" value="{$parameters.record->mileage}"/>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Title Status</label>
                                                                <select class="select-3" name="s3_title_status">
                                                                    <option value="Clean">Clean</option>
                                                                    {foreach from=$parameters.title_statuses key=key item=item}
                                                                    <option value="{$key}" {if $parameters.record->title_status == {$key}}selected="selected"{/if}>{$item}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Title Wait Time</label>
                                                                <select class="select-3" name="s3_title_wait_time">
                                                                    <option value=""></option>
                                                                    <option value="Title Available" {if $parameters.record->title_wait_time == "Title Available"}selected="selected"{/if}>Title Available</option>
                                                                    <option value="Up to 30 Days"{if $parameters.record->title_wait_time == "Up to 30 Days"}selected="selected"{/if}>Up to 30 Days</option>
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Transmission</label>
                                                                <select class="select-3" name="s3_transmission">
                                                                    <option value=""></option>
                                                                    <option value="Automatic" {if $parameters.record->transmission == "Automatic"}selected="selected"{/if}>Automatic</option>
                                                                    <option value="Manual"{if $parameters.record->transmission == "Manual"}selected="selected"{/if}>Manual</option>
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Sell to Dealers Only?</label>
                                                                <select class="select-3" name="s3_sell_to">
                                                                    <option value=""></option>
                                                                    <option value="1" {if $parameters.record->sell_to == 1}selected="selected"{/if}>Dealers Only</option>
                                                                    <option value="2" {if $parameters.record->sell_to == 2}selected="selected"{/if}>Anyone</option>
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Drive Type</label>
                                                                <select class="select-3" name="s3_drive_type">
                                                                    <option value=""></option>
                                                                    {foreach name=drive_types from=$web_config.drive_types key=key item=driveType}
                                                                        <option value="{$key}"{if $key == $parameters.record->drive_type} selected="selected"{/if}>{$driveType}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                            <div class="block-3 label-holder">
                                                                <label class="small">Fuel Type</label>
                                                                <select class="select-3" name="s3_fuel_type">
                                                                    <option value=""></option>
                                                                    {foreach name=fuel_types from=$web_config.fuel_types key=key item=fuelType}
                                                                        <option value="{$key}"{if $key == $parameters.record->fuel_type} selected="selected"{/if}>{$fuelType}</option>
                                                                    {/foreach}
                                                                </select>
                                                            </div>
                                                            <div class="block-1 label-holder">
                                                                <label class="small">Description</label>
                                                                <textarea class="trumbowyg" cols="30" rows="10" name="s3_desciption">{$parameters.record->description}</textarea>
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <div class="full-width">
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-left always-left switchSubSubPage" data-number="3" id="second-preview" title="previous">previous</a>
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-right always-right" data-number="3" id="step-3-submit" title="next">next</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sub-sub-page" data-number="4" id="step-4-tab">
                                                <div class="module-create-edit">
                                                    <form action="" class="form" id="step-4">
                                                        <input type="hidden" name="step" value="4">
                                                        <div class="field-block-1">
                                                            <div class="block-1">
                                                                <h4 class="step-title">Terms & Photos</h4>
                                                            </div>
                                                            <div class="block-1">
                                                                <label>Terms & Conditions</label>
                                                            </div>
                                                            <div class="block-1 label-holder">
                                                                <label class="small">Select from your Content Blocks</label>
                                                                <select id="terms_condition-select" class="select-3 terms_condition-select" name="s4_terms_condition_id">
                                                                    <option value="0">{$parameters.default_terms_conditions->title|escape}</option>
                                                                    {if $parameters.content_blocks.terms}
                                                                    {foreach from=$parameters.content_blocks.terms item=item}
                                                                    <option value="{$item->id}" {if $parameters.record->terms_condition_id == $item->id}selected="selected"{/if}>{$item->title|escape}</option>
                                                                    {/foreach}
                                                                    {/if}
                                                                </select>
                                                            </div>
                                                            <a href="javascript:void(0);" class="btn-2 blue remove-selection term" title="Remove Selection">Remove Selection</a>
                                                            <div class="terms_condition-box-write">
                                                                <div class="block-1">
                                                                    <label>Or write new Terms & Conditions now</label>
                                                                </div>
                                                                <div class="block-1 label-holder">
                                                                    <label class="small">Enter Terms & Conditions</label>
                                                                    <textarea id="terms-conditions" class="trumbowyg" cols="30" rows="10" name="s4_terms_condition">{$parameters.record->terms_conditions}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="block-1">
                                                                <a href="javascript:void(0);" class="btn-2 blue clear-selection-btn" id="terms-conditions-clear" style="display:none;" title="Clear Selection">Clear Selection</a>
                                                            </div>
                                                            <div class="block-1">
                                                                <label>Additional Fees</label>
                                                            </div>
                                                            <div class="block-1 label-holder">
                                                                <label class="small">Select from your Content Blocks</label>
                                                                <select id="additional-fees-select" class="select-3 additional-fees-select" name="s4_additional_fees_id">
                                                                    <option value="0">{$parameters.default_additional_fees->title|escape}</option>
                                                                    {if $parameters.content_blocks.fees}
                                                                    {foreach from=$parameters.content_blocks.fees item=item}
                                                                    <option value="{$item->id}" {if $parameters.record->additional_fees_id == $item->id}selected=selected{/if}>{$item->title|escape}</option>
                                                                    {/foreach}
                                                                    {/if}
                                                                </select>
                                                            </div>
                                                            <a href="javascript:void(0);" class="btn-2 blue remove-selection fees" title="Remove Selection">Remove Selection</a>
                                                            <div class="additional-fees-box-write">
                                                                <div class="block-1">
                                                                    <label>Or add any new information here about additional fees applicable to this auction</label>
                                                                </div>
                                                                <div class="block-1 label-holder">
                                                                    <label class="small">Enter Additional Fees</label>
                                                                    <textarea id="additional-fees" class="trumbowyg" cols="30" rows="10" name="s4_additional_fees">{$parameters.record->additional_fees}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="block-1">
                                                                <a href="javascript:void(0);" class="btn-2 blue clear-selection-btn" id="additional-fees-clear" style="display:none;" title="Clear Selection">Clear Selection</a>
                                                            </div>
                                                            <div class="block-1">
                                                                <label>Payment and Pickup Information</label>
                                                            </div>
                                                            {if $parameters.payment_pickup_block}
                                                                <div class="block-1 label-holder">
                                                                    <label class="small">Select an Option</label>
                                                                    <select id="payment-pickup-select" class="select-3 payment-pickup-select" name="s4_payment_pickup_id">
                                                                        <option value=""></option>
                                                                        {foreach from=$parameters.payment_pickup_block item=item}
                                                                        <option value="{$item->id}" {if $parameters.record->payment_pickup_id == $item->id}selected=selected{/if}>{$item->title|escape}</option>
                                                                        {/foreach}
                                                                    </select>
                                                                </div>
                                                            {/if}
                                                            <a href="javascript:void(0);" class="btn-2 blue remove-selection pickup" title="Remove Selection">Remove Selection</a>
                                                            <div class="payment-pickup-box-write">
                                                                {if $parameters.payment_pickup_block}
                                                                <div class="block-1">
                                                                    <label>Or add new payment and pickup information for this auction below</label>
                                                                </div>
                                                                {/if}
                                                                <div style="display: flex;">
                                                                    <div class="block-3 label-holder select-3-payment-method">
                                                                        <label class="small">Payment Method</label>
                                                                        <select class="select-3 payment-select-custom-2" name="s4_payment_method[]" multiple>
                                                                            <option value=""></option>
                                                                            {foreach name=payment_methods from=$web_config.payment_methods key=key item=method}
                                                                                <option value="{$key}">{$method}</option>
                                                                            {/foreach}
                                                                        </select>
                                                                   </div>
                                                                   <div class="block-3 label-holder">
                                                                       <label class="small">Pickup Window</label>
                                                                       <input type="text" class="text" name="s4_pickup_window" value="{$parameters.record->pickup_window}"/>
                                                                   </div>
                                                                </div>
                                                                <div class="block-1 label-holder">
                                                                    <label class="small">Pickup Note</label>
                                                                    <textarea class="trumbowyg" cols="30" rows="10" name="s4_pickup_note">{$parameters.record->pickup_note}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="block-1">
                                                                <a href="javascript:void(0);" class="btn-2 blue clear-selection-btn" id="payment-pickup-clear" style="display:none;" title="Clear Selection">Clear Selection</a>
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <div class="full-width">
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-left always-left switchSubSubPage" data-number="4" id="third-preview" title="previous">previous</a>
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-right always-right" data-number="4" id="step-4-submit" title="next">next</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sub-sub-page" data-number="5" id="step-5-tab">
                                                <div class="module-create-edit">
                                                    <form action="" class="form" id="step-5">
                                                        <input type="hidden" name="step" value="5">
                                                        <div class="field-block-1">
                                                            <div class="block-1">
                                                                <h4 class="step-title">Photos</h4>
                                                            </div>
                                                            <div class="block-1">
                                                                <label>
                                                                    Add Photos of Your Car Below
                                                                </label>
                                                            </div>
                                                            <div class="block-1 drag-file-upload">
                                                                <div id="dropzoneMulty">
                                                                    <div class="title-box">
                                                                        <div>
                                                                            <strong>Drag & Drop</strong>
                                                                            <span>Image Files Here</span>
                                                                            <span class="btn-2 blue">Upload</span>
                                                                        </div>
                                                                    </div>
                                                                    {if $parameters.record->photos}
                                                                    <div id="preview-wrapper">
                                                                        {foreach name=photos from=$parameters.record->photos item=photo}
                                                                        <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete dz-preview-image_info">
                                                                            <div class="dz-image">
                                                                                <img data-dz-thumbnail="" alt="{$photo->title|escape}" src="/site_media/{$photo->photo}" title="{$photo->title|escape}" />
                                                                            </div>
                                                                            <div class="dz-details">
                                                                                <div class="dz-filename">
                                                                                    <span data-dz-name="">{$photo->title|escape}</span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="dz-progress">
                                                                                <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%; display: none;"></span>
                                                                            </div>
                                                                            <!-- <div class="dz-success-mark popup" data-file_id="{$photo->photo}">
                                                                                <svg version="1.1" width="20px" height="20px" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 52.669 52.669" style="enable-background:new 0 0 52.669 52.669;" xml:space="preserve">        <g>  <g>   <path d="M33.463,42.496c-7.284,0-13.474-4.75-15.649-11.313H9.05v-3.232h8.045c-0.075-0.637-0.118-1.283-0.118-1.94            c0-0.879,0.071-1.742,0.204-2.585H9.05v-3.232h8.99c0.625-1.651,1.508-3.175,2.599-4.525H9.05v-3.232h15.075v-0.002              c2.656-1.833,5.873-2.909,9.337-2.909c2.106,0,4.119,0.401,5.972,1.124V2.415H0v41.374c0,3.556,2.909,6.465,6.465,6.465H32.97           c3.556,0,6.465-2.909,6.465-6.465v-2.417C37.582,42.095,35.569,42.496,33.463,42.496z"></path>            </g>            </g>            <g>            <g>            <path d="M44.488,33.36c1.405-2.104,2.226-4.631,2.226-7.35c0-7.319-5.933-13.252-13.253-13.252            c-7.321,0-13.253,5.933-13.253,13.252c0,7.319,5.931,13.253,13.253,13.253c2.965,0,5.693-0.985,7.9-2.63l8.109,8.109l3.199-3.2            L44.488,33.36z M33.462,36.031c-5.525,0-10.02-4.495-10.02-10.021c0-5.525,4.495-10.02,10.02-10.02            c5.525,0,10.02,4.495,10.02,10.02C43.482,31.535,38.988,36.031,33.462,36.031z"></path></g></g></svg>
                                                                            </div> -->
                                                                            <div class="dz-error-mark">
                                                                                <svg width="12px" height="12px" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21.9 21.9" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 21.9 21.9">
                                                                                    <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
                                                                                </svg>
                                                                            </div>
                                                                            <input type="hidden" name="photos[{$photo->photo}]" value="{$photo->title}">
                                                                        </div>
                                                                        {/foreach}
                                                                    </div>
                                                                    {/if}
                                                                </div>
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <div class="full-width">
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-left always-left switchSubSubPage" data-number="5" id="fourth-preview" title="previous">previous</a>
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-right always-right" data-number="5" id="step-5-submit" title="next">next</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="sub-sub-page" data-number="6" id="step-6-tab">
                                                <div class="module-create-edit">
                                                    <form action="" class="form" id="step-6">
                                                        <input type="hidden" name="step" value="6">
                                                        <div class="field-block-1">
                                                            <div class="block-1" >
                                                                <h4 class="step-title">Confirm</h4>
                                                                <p>Please confirm that all of the details for your auction are correct. You can go back by clicking the "Previous" button if you need to edit anything. You will not be able to edit your auction once you receive your first bid</p>
                                                            </div>
                                                            <div class="block-4 label-holder colored-label">
                                                                <label class="small">Reserve Price</label>
                                                                <input type="text" id="s5_reserve_price" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-4 label-holder colored-label">
                                                                <label class="small">Starting Bid Price</label>
                                                                <input type="text" id="s5_starting_bid_price" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-4 label-holder colored-label">
                                                                <label class="small">Buy Now Price</label>
                                                                <input type="text" id="s5_buy_now_price" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-4 label-holder colored-label">
                                                                <label class="small">Auction Length</label>
                                                                <input type="text" id="s5_auction_length" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-1 label-holder colored-label">
                                                                <label class="small">VIN Number</label>
                                                                <input type="text" id="s5_vin_number" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Make</label>
                                                                <input type="text" id="s5_make" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Model</label>
                                                                <input type="text" id="s5_model" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Year</label>
                                                                <input type="text" id="s5_year" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Engine</label>
                                                                <input type="text" id="s5_engine" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small"># of Cylinders</label>
                                                                <input type="text" id="s5_number_of_cylinders" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Transmission</label>
                                                                <input type="text" id="s5_transmission" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Number of Doors</label>
                                                                <input type="text" id="s5_number_of_doors" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Exterior Color</label>
                                                                <div id="s5_color" class="performance-box" contenteditable="false"></div>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Interior Color</label>
                                                                <div id="s5_interior_color" class="performance-box" contenteditable="false"></div>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Condition</label>
                                                                <input type="text" id="s5_auction_condition" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Mileage</label>
                                                                <input type="text" id="s5_mileage" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Fuel Type</label>
                                                                <input type="text" id="s5_fuel_type" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Title Status</label>
                                                                <input type="text" id="s5_title_status" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Title Wait Time</label>
                                                                <input type="text" id="s5_title_wait_time" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-2 label-holder colored-label">
                                                                <label class="small">Sell to Dealers Only?</label>
                                                                <input type="text" id="s5_sell_to" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-2 label-holder colored-label">
                                                                <label class="small">Drive Type</label>
                                                                <input type="text" id="s5_drive_type" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-1 label-holder colored-label">
                                                                <label class="small">Description</label>
                                                                <div id="s5_description" class="performance-box performance-box-custom" contenteditable="false"> </div>
                                                            </div>
                                                            <div class="block-1 label-holder colored-label">
                                                                <label class="small">Terms & Conditions</label>
                                                                <div id="s5_terms_conditions" class="performance-box performance-box-custom" contenteditable="false"></div>
                                                            </div>
                                                            <div class="block-1 label-holder colored-label">
                                                                <label class="small">Additional Fees</label>
                                                                <div id="s5_additional_fees" class="performance-box performance-box-custom" contenteditable="false"></div>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Payment Method</label>
                                                                <input type="text" id="s5_payment_method" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Pickup Window</label>
                                                                <input type="text" id="s5_pickup_window" class="text" disabled placeholder="" value=""/>
                                                            </div>
                                                            <div class="block-3 label-holder colored-label">
                                                                <label class="small">Pickup Note</label>
                                                                <div id="s5_pickup_note" class="performance-box performance-box-custom" contenteditable="false"></div>
                                                            </div>
                                                            <div class="image-list">
                                                                {foreach from=$parameters.record->photos item=item}
                                                                <div class="img" style="background-image: url('/site_media/{$item->photo}')">
                                                                    <img src="/site_media/{$item->photo}" alt="{$item->title}" title="{$item->title}"/>
                                                                </div>
                                                                {/foreach}
                                                            </div>
                                                            <div class="block-1 flex-h-left abs">
                                                                <div class="full-width">
                                                                    <a href="javascript:void(0);" class="btn-2 blue submit-left always-left switchSubSubPage" data-number="6" id="fifth-preview" title="Previous">previous</a>
                                                                    <a href="javascript:void(0);" class="btn-2 green submit-right always-right" id="step-6-submit" title="{if $parameters.action == "edit_auction"}Update Auction{else}Post Auction{/if}">{if $parameters.action == "edit_auction"}Update Auction{else}Post Auction{/if}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="container">
                                            <div class="col-24">
                                                <div class="content">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {else}
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
                                                                <p><span>{$parameters.status}</span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </iao-alert>
                                            </iao-alert-box>
                                        </div>
                                    </div>
                                    {/if}
                                {/if}
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
