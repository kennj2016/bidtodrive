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
                                    <div class="img-holder no-padding">
                                        <div class="holder no-border">
                                            {if $parameters.account_info->buyer_type == 'Dealer'}
                                                {assign var=buyerName value=`$parameters.account_info->name`}
                                            {else}
                                                {assign var=buyerName value=`$parameters.account_info->name`}
                                            {/if}
                                            <img src="/images/bg/bg-3.jpg" alt="img" title="{$buyerName}" />
                                            <div class="info">
                                                <span>welcome</span>
                                                {$buyerName}
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="name no-padding no-border">
                                        <span class="mobile-only">{$buyerName}</span>
                                        <div class="left-panel-close-button">
                                        </div>
                                    </h4>
                                    <div class="page-links-list">
                                        <a href="/account/buyer/bids/" title="My Bids" id="mode-bids" class="item btn activate-sticky-scroll {if $parameters.mode == "bids"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Bids" title="My Bids" />
                                            </div>
                                            <span>My Bids</span>
                                        </a>
                                        <a href="/account/buyer/watched-listings/" title="My watched listings" id="mode-watched-listings" class="item btn {if $parameters.mode == "watched_listings"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My watched listings" title="My watched listings" />
                                            </div>
                                            <span>My watched listings</span>
                                        </a>
                                        <a href="/account/buyer/watched-sellers/" title="My watched sellers" id="mode-watched-sellers" class="item btn {if $parameters.mode == "watched_sellers"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My watched sellers" title="My watched sellers" />
                                            </div>
                                            <span>My watched sellers</span>
                                        </a>
                                        <a href="/account/buyer/payments/" title="My Purchases" id="mode-payments" class="item btn activate-sticky-scroll {if $parameters.mode == "payments"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Purchases" title="My Purchases" />
                                            </div>
                                            <span>My Purchases</span>
                                        </a>
                                        <a href="/account/buyer/" title="My account information" class="item btn {if $parameters.mode != "payments" && $parameters.mode != "bids" && $parameters.mode != "watched_listings" && $parameters.mode != "watched_sellers" && $parameters.cmd != "account_buyer_billing_details" && $parameters.cmd != "account_buyer_notification_settings"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information"/>
                                            </div>
                                            <span>My account information</span>
                                        </a>
                                        <a href="/account/security-access/" title="Security & Access" class="item btn {if $parameters.cmd == "account_security_access"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-locked.svg" alt="Security & Access" title="Security & Access"/>
                                            </div>
                                            <span>Security & Access</span>
                                        </a>
                                        <a href="/account/billing-details/" title="Billing Details" class="item btn {if $parameters.cmd == "account_buyer_billing_details"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/credit-card.svg" alt="Billing Details" title="Billing Details"/>
                                            </div>
                                            <span>Billing Details</span>
                                        </a>
                                        <a href="/account/notification-settings/" title="Notification Settings" class="item btn {if $parameters.cmd == "account_buyer_notification_settings"}active{/if}">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/notification.svg" alt="Notification Settings" title="Notification Settings"/>
                                            </div>
                                            <span>Notification Settings</span>
                                        </a>
                                        <a href="/logout/" title="Sign Out" class="item">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-signout.svg" alt="" title="Sign Out" />
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
        <div class="baron-table active" id="sticky">
            <div class="baron__clipper">
                <div class="topScrollVisible baron__scroller" style="overflow-x:auto">
                    <div class="baron__bar"></div>
                    <div class="topScrollTableLength ">
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
                            <div class="account-right-box">
                                <div class="page {if $parameters.mode != "payments" && $parameters.mode != "bids" && $parameters.mode != "watched_listings" && $parameters.mode != "watched_sellers"}active{/if}">
                                    <h4 class="head-title button-add">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="My account information" title="My account information" />
                                        </div>
                                        <span>My account information</span>
                                        <div class="button-holder-box view-switcher">
                                            <div class="holder">
                                                <div class="button {if $parameters.account_info->buyer_type == "Individual"}active{/if}" data-number="1">individual</div>
                                                <div class="button {if $parameters.account_info->buyer_type == "Dealer"}active{/if}" data-number="2">dealer</div>
                                                <a id="request" class="popup visualhidden" href="#" title="My account information">request popup</a>
                                            </div>
                                        </div>
                                    </h4>
                                    <div id="complete-update-err" style="padding:10px 0 0 32px;font-size:14px;font-weight:600;color:#ff0000;"></div>
                                    <div id="update-form-thank" style="text-align: center;padding:25px 50px 0 50px;font-size: 30px;color: #0650cb;display:none;">Your profile was successfully updated!</div>
                                    <div id="update-wrap">
                                        <div class="subpage subpage-1" {if $parameters.account_info->buyer_type == "Dealer"}style="display: none"{/if}>
                                            <form action="#" class="form" id="buyer-individual-form" autocomplete="off">
                                                <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
                                                <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
                                                <input type="hidden" name="action" value="buyer-individual">
                                                <div class="field-block-1">
                                                    <div class="block-1">
                                                        <label>Personal Information</label>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Name</label>
                                                        <input type="text" class="text" placeholder="" name="name" value="{$parameters.account_info->name}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Email</label>
                                                        <input type="text" name="email" value="" style="display: none" />
                                                        <input type="text" class="text" placeholder="" name="email" value="{$parameters.account_info->email}"/>
                                                        <input type="text" name="not-an-email" value="" style="display: none" />
                                                    </div>
                                                    <div class="block-1 label-holder">
                                                        <label class="small">Address</label>
                                                        <input type="tel" class="text" placeholder="" name="address" value="{$parameters.account_info->address}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">City</label>
                                                        <input type="text" class="text" placeholder="" name="city" value="{$parameters.account_info->city}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">State</label>
                                                        <select name="state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}" {if $parameters.account_info->state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Zip</label>
                                                        <input type="tel" class="text" placeholder=""  name="zip" value="{$parameters.account_info->zip}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Mobile number</label>
                                                        <input type="tel" class="text phone_mask" placeholder="" name="mobile_number" value="{$parameters.account_info->mobile_number}"/>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Driver's License Information</label>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">DL Number</label>
                                                        <input type="tel" class="text" placeholder="" name="drivers_license_number" value="{$parameters.account_info->drivers_license_number}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">State</label>
                                                        <select name="drivers_license_state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}" {if $parameters.account_info->drivers_license_state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">Date of Birth</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="date_of_birth" value="{$parameters.account_info->date_of_birth|date_format:"%m.%d.%Y"}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">Issue Date</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="license_issue_date" value="{$parameters.account_info->license_issue_date|date_format:"%m.%d.%Y"}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">Expiration Date</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="license_expiration_date" value="{$parameters.account_info->license_expiration_date|date_format:"%m.%d.%Y"}"/>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Please attach a scanned (or photographed) copy of your Driver's License:</label>
                                                    </div>
                                                    <div class="block-1 drag-file-upload">
                                                        <div id="dropzone-drivers-license">
                                                            <div class="title-box">
                                                                <div>
                                                                    <strong>Upload</strong>
                                                                    <span>your files here</span>
                                                                    <span class="btn-2 blue">Choose File</span>
                                                                </div>
                                                            </div>
                                                            {if $parameters.account_info->drivers_license_photo_info}
                                                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete dz-preview-drivers_license_photo_info">
                                                                    <div class="dz-image">
                                                                        <img data-dz-thumbnail="" alt="{$parameters.account_info->drivers_license_photo_info->name_orig|escape}" title="{$parameters.account_info->drivers_license_photo_info->name_orig|escape}" src="/license/ml/{$parameters.account_info->drivers_license_photo_info->name_new}">
                                                                    </div>
                                                                    <div class="dz-details">
                                                                        <div class="dz-filename">
                                                                            <span data-dz-name="">{$parameters.account_info->drivers_license_photo_info->name_orig|escape}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dz-progress" style="display:none;">
                                                                        <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;display:none;"></span>
                                                                    </div>
                                                                    <div class="dz-success-mark popup" data-file_id="{$parameters.account_info->drivers_license_photo_info->name_new}">
                                                                        <svg version="1.1" width="20px" height="20px"
                                                                             id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" viewBox="0 0 52.669 52.669"
                                                                             style="enable-background:new 0 0 52.669 52.669;"
                                                                             xml:space="preserve">        <g>
                                                                                <g>
                                                                                    <path d="M33.463,42.496c-7.284,0-13.474-4.75-15.649-11.313H9.05v-3.232h8.045c-0.075-0.637-0.118-1.283-0.118-1.94            c0-0.879,0.071-1.742,0.204-2.585H9.05v-3.232h8.99c0.625-1.651,1.508-3.175,2.599-4.525H9.05v-3.232h15.075v-0.002              c2.656-1.833,5.873-2.909,9.337-2.909c2.106,0,4.119,0.401,5.972,1.124V2.415H0v41.374c0,3.556,2.909,6.465,6.465,6.465H32.97           c3.556,0,6.465-2.909,6.465-6.465v-2.417C37.582,42.095,35.569,42.496,33.463,42.496z"></path>
                                                                                </g>
                                                                            </g>
                                                                            <g>
                                                                                <g>
                                                                                    <path d="M44.488,33.36c1.405-2.104,2.226-4.631,2.226-7.35c0-7.319-5.933-13.252-13.253-13.252            c-7.321,0-13.253,5.933-13.253,13.252c0,7.319,5.931,13.253,13.253,13.253c2.965,0,5.693-0.985,7.9-2.63l8.109,8.109l3.199-3.2            L44.488,33.36z M33.462,36.031c-5.525,0-10.02-4.495-10.02-10.021c0-5.525,4.495-10.02,10.02-10.02            c5.525,0,10.02,4.495,10.02,10.02C43.482,31.535,38.988,36.031,33.462,36.031z"></path>
                                                                                </g>
                                                                            </g>    </svg>
                                                                        <title>Check</title>
                                                                        <defs></defs>
                                                                        <g id="Page-1" stroke="none" stroke-width="1"
                                                                             fill="none" fill-rule="evenodd"
                                                                             sketch:type="MSPage">
                                                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                                                    id="Oval-2"
                                                                                    stroke-opacity="0.198794158"
                                                                                    stroke="#747474"
                                                                                    fill-opacity="0.816519475"
                                                                                    fill="#FFFFFF"
                                                                                    sketch:type="MSShapeGroup"></path>
                                                                        </g>
                                                                    </div>
                                                                    <div class="dz-error-mark">
                                                                        <svg width="12px" height="12px" version="1.1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 21.9 21.9"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             enable-background="new 0 0 21.9 21.9">
                                                                            <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <input type="hidden" name="drivers_license_photo"
                                                                             value="{$parameters.account_info->drivers_license_photo}">
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Payment/Pickup Information</label>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Transporter</label>
                                                        <input type="text" class="text" name="pickup_transporter" value="{$parameters.account_info->pickup_transporter}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Address</label>
                                                        <input type="text" class="text" name="pickup_address" value="{$parameters.account_info->pickup_address}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup City</label>
                                                        <input type="text" class="text" name="pickup_city" value="{$parameters.account_info->pickup_city}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Pickup State</label>
                                                        <select name="pickup_state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}" {if $parameters.account_info->pickup_state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Zip</label>
                                                        <input type="tel" class="text" name="pickup_zip" value="{$parameters.account_info->pickup_zip}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Transporter Phone</label>
                                                        <input type="tel" class="text phone_mask" name="transporter_phone" value="{$parameters.account_info->transporter_phone}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Driver</label>
                                                        <input type="text" class="text" name="pickup_driver" value="{$parameters.account_info->pickup_driver}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Driver Phone</label>
                                                        <input type="tel" class="text phone_mask" name="driver_phone" value="{$parameters.account_info->driver_phone}"/>
                                                    </div>
                                                    <hr class="hr"/>
                                                    <div class="block-1 flex-h-left sumbit-info-btn">
                                                        <input type="button" class="submit-right btn-2 blue" id="update_individual_buyer_account" value="Update Information"/>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="subpage subpage-2"
                                             {if $parameters.account_info->buyer_type == "Individual"}style="display: none"{/if}>
                                            <form action="#" class="form" id="buyer-dealer-form" autocomplete="off">
                                                <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
                                                <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
                                                <input type="hidden" name="action" value="buyer-dealer"/>
                                                <div class="field-block-1">
                                                    <div class="block-1">
                                                        <label>Dealer Information</label>
                                                    </div>
                                                    <div class="block-1 label-holder">
                                                        <label class="small">Company Name</label>
                                                        <input type="text" class="text" placeholder="" name="name" value="{$parameters.account_info->name}"/>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Personal Information</label>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Name</label>
                                                        <input type="text" class="text" placeholder="" name="company_name" value="{$parameters.account_info->company_name}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Email</label>
                                                        <input type="text" name="email" value="" style="display: none" />
                                                        <input type="text" class="text" placeholder="" name="email" value="{$parameters.account_info->email}"/>
                                                        <input type="text" name="not-an-email" value="" style="display: none" />
                                                    </div>
                                                    <div class="block-1 label-holder">
                                                        <label class="small">Address</label>
                                                        <input type="tel" class="text" placeholder="" name="address" value="{$parameters.account_info->address}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">City</label>
                                                        <input type="text" class="text" placeholder="" name="city" value="{$parameters.account_info->city}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">State</label>
                                                        <select name="state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}" {if $parameters.account_info->state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Zip</label>
                                                        <input type="tel" class="text" placeholder=""  name="zip" value="{$parameters.account_info->zip}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Mobile number</label>
                                                        <input type="tel" class="text phone_mask" placeholder="" name="mobile_number" value="{$parameters.account_info->mobile_number}"/>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Dealers License Information</label>
                                                    </div>
                                                    <div class="block-1 label-holder">
                                                        <label class="small">Issued to</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="dealers_license_issued_to" value="{$parameters.account_info->dealers_license_issued_to|date_format:"%m.%d.%Y"}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">State</label>
                                                        <select name="dealers_license_state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}"
                                                                            {if $parameters.account_info->dealers_license_state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">License Number</label>
                                                        <input type="tel" class="text" placeholder="" name="dealers_license_number" value="{$parameters.account_info->dealers_license_number}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">Issue Date</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="dealers_license_issue_date" value="{$parameters.account_info->dealers_license_issue_date|date_format:"%m.%d.%Y"}"/>
                                                    </div>
                                                    <div class="block-2 label-holder">
                                                        <label class="small">Expiration Date</label>
                                                        <input type="tel" class="text date_mask" placeholder="" name="dealers_license_expiration_date" value="{$parameters.account_info->dealers_license_expiration_date|date_format:"%m.%d.%Y"}"/>
                                                    </div>

                                                    <div class="block-1">
                                                        <label>Upload Dealers License</label>
                                                    </div>
                                                    <div class="block-1 drag-file-upload">
                                                        <div id="dropzone-dealer-license">
                                                            <div class="title-box">
                                                                <div>
                                                                    <strong>Upload</strong>
                                                                    <span>your files here</span>
                                                                    <span class="btn-2 blue">Choose File</span>
                                                                </div>
                                                            </div>
                                                            {if $parameters.account_info->dealers_license_photo_info}
                                                                <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete dz-preview-dealers_license_photo_info">
                                                                    <div class="dz-image">
                                                                        <img data-dz-thumbnail="" title="{$parameters.account_info->dealers_license_photo_info->name_orig|escape}" alt="{$parameters.account_info->dealers_license_photo_info->name_orig|escape}" src="/license/ml/{$parameters.account_info->dealers_license_photo_info->name_new}">
                                                                    </div>
                                                                    <div class="dz-details">
                                                                        <div class="dz-filename">
                                                                            <span data-dz-name="">{$parameters.account_info->dealers_license_photo_info->name_orig|escape}</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="dz-progress" style="display:none;">
                                                                        <span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span>
                                                                    </div>
                                                                    <div class="dz-success-mark popup" data-file_id="{$parameters.account_info->dealers_license_photo_info->name_new}">
                                                                        <svg version="1.1" width="20px" height="20px"
                                                                             id="Capa_1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             x="0px" y="0px" viewBox="0 0 52.669 52.669"
                                                                             style="enable-background:new 0 0 52.669 52.669;"
                                                                             xml:space="preserve">        <g>
                                                                                <g>
                                                                                    <path d="M33.463,42.496c-7.284,0-13.474-4.75-15.649-11.313H9.05v-3.232h8.045c-0.075-0.637-0.118-1.283-0.118-1.94            c0-0.879,0.071-1.742,0.204-2.585H9.05v-3.232h8.99c0.625-1.651,1.508-3.175,2.599-4.525H9.05v-3.232h15.075v-0.002              c2.656-1.833,5.873-2.909,9.337-2.909c2.106,0,4.119,0.401,5.972,1.124V2.415H0v41.374c0,3.556,2.909,6.465,6.465,6.465H32.97           c3.556,0,6.465-2.909,6.465-6.465v-2.417C37.582,42.095,35.569,42.496,33.463,42.496z"></path>
                                                                                </g>
                                                                            </g>
                                                                            <g>
                                                                                <g>
                                                                                    <path d="M44.488,33.36c1.405-2.104,2.226-4.631,2.226-7.35c0-7.319-5.933-13.252-13.253-13.252            c-7.321,0-13.253,5.933-13.253,13.252c0,7.319,5.931,13.253,13.253,13.253c2.965,0,5.693-0.985,7.9-2.63l8.109,8.109l3.199-3.2            L44.488,33.36z M33.462,36.031c-5.525,0-10.02-4.495-10.02-10.021c0-5.525,4.495-10.02,10.02-10.02            c5.525,0,10.02,4.495,10.02,10.02C43.482,31.535,38.988,36.031,33.462,36.031z"></path>
                                                                                </g>
                                                                            </g>    </svg>
                                                                        <title>Check</title>
                                                                        <defs></defs>
                                                                        <g id="Page-1" stroke="none" stroke-width="1"
                                                                             fill="none" fill-rule="evenodd"
                                                                             sketch:type="MSPage">
                                                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                                                                    id="Oval-2"
                                                                                    stroke-opacity="0.198794158"
                                                                                    stroke="#747474"
                                                                                    fill-opacity="0.816519475"
                                                                                    fill="#FFFFFF"
                                                                                    sketch:type="MSShapeGroup"></path>
                                                                        </g>
                                                                    </div>
                                                                    <div class="dz-error-mark">
                                                                        <svg width="12px" height="12px" version="1.1"
                                                                             xmlns="http://www.w3.org/2000/svg"
                                                                             viewBox="0 0 21.9 21.9"
                                                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                             enable-background="new 0 0 21.9 21.9">
                                                                            <path d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <input type="hidden" name="dealers_license_photo"
                                                                             value="{$parameters.account_info->dealers_license_photo}">
                                                                </div>
                                                            {/if}
                                                        </div>
                                                    </div>
                                                    <div class="block-1">
                                                        <label>Payment/Pickup Information</label>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Transporter</label>
                                                        <input type="text" class="text" name="pickup_transporter" value="{$parameters.account_info->pickup_transporter}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Address</label>
                                                        <input type="text" class="text" name="pickup_address" value="{$parameters.account_info->pickup_address}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup City</label>
                                                        <input type="text" class="text" name="pickup_city" value="{$parameters.account_info->pickup_city}"/>
                                                    </div>
                                                    <div class="block-3 block-3-until-mob label-holder">
                                                        <label class="small">Pickup State</label>
                                                        <select name="pickup_state" class="text" placeholder="">
                                                            <option value=""></option>
                                                            {if $parameters.states}
                                                                {foreach from=$parameters.states item=item}
                                                                    <option value="{$item->abbr}" {if $parameters.account_info->pickup_state == $item->abbr}selected="selected"{/if}>{$item->name}</option>
                                                                {/foreach}
                                                            {/if}
                                                        </select>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Zip</label>
                                                        <input type="tel" class="text" name="pickup_zip" value="{$parameters.account_info->pickup_zip}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Transporter Phone</label>
                                                        <input type="tel" class="text phone_mask" name="transporter_phone" value="{$parameters.account_info->transporter_phone}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Pickup Driver</label>
                                                        <input type="text" class="text" name="pickup_driver" value="{$parameters.account_info->pickup_driver}"/>
                                                    </div>
                                                    <div class="block-3 label-holder">
                                                        <label class="small">Driver Phone</label>
                                                        <input type="tel" class="text phone_mask" name="driver_phone" value="{$parameters.account_info->driver_phone}"/>
                                                    </div>
                                                    <hr class="hr"/>
                                                    <div class="block-1 flex-h-left sumbit-info-btn">
                                                        <input type="button" class="submit-right btn-2 blue" id="update_dealer_buyer_account" value="Update Information"/>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- MY PAYMENTS -->
                                <div class="page {if $parameters.mode == "payments"}active{/if}">
                                    <h4 class="head-title button-add">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Purchases" title="My Purchases" />
                                        </div>
                                        <span>My Purchases</span>
                                        {if $parameters.payments}
                                        <div class="filter-add-btn">
                                          <form id="buyer-payments-sort" class="drop-filters">
                                            <div id="sort-dropdown">
                                              <select name="filter" class="select-3 select-filter-payments">
                                                <option value="">Filter By</option>
                                                <option value="paid" {if $smarty.request.sort == "paid"}selected=""{/if}>
                                                  paid
                                                </option>
                                                <option value="refunded" {if $smarty.request.sort == "refunded"}selected=""{/if}>
                                                  refunded
                                                </option>
                                              </select>
                                            </div>
                                          </form>
                                        </div>
                                        {/if}
                                    </h4>
                                    <br/>
                                    <br/>
                                    {if $parameters.payments}
                                        <div id="flag1"></div>
                                        <div class="baron-table">
                                            <div class="baron__clipper">
                                                <div class="topScrollVisible-inner baron__scroller" style="overflow-x:auto">
                                                    <div class="baron__bar"></div>
                                                    <div class="topScrollTableLength"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flag1"></div>
                                        <div class="baron-table">
                                            <div class="baron__clipper">
                                                <div class="payment-table-holder baron__scroller">
                                                    <div class="baron__bar"></div>
                                                    <form id="buyer-payments-order" class="payment-table-scroll-holder">
                                                        <div class="payment-table">
                                                                <div class="table-header">
                                                                    <div class="table-row">
                                                                        <input id="order-value" type="hidden" name="sort" value="" >
                                                                        <div class="cell" data-number="1">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-carmodel.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                                                                </span>
                                                                                <em>Car: Model & Year</em>
                                                                                <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Car: Model & Year" title="Car: Model & Year" />
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell" data-number="2">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-timestamp.svg" alt="TimeStamp" title="TimeStamp" />
                                                                                </span>
                                                                                <em>TimeStamp</em>
                                                                                <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="TimeStamp" title="TimeStamp" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="TimeStamp" title="TimeStamp" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="TimeStamp" title="TimeStamp" />
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell" data-number="3">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Buyer Fee" title="Buyer Fee"/>
                                                                                </span>
                                                                                <em>Buyer Fee</em>
                                                                                <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Buyer Fee" title="Buyer Fee"/>
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Buyer Fee" title="Buyer Fee" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Buyer Fee" title="Buyer Fee" />
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell" data-number="4">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-amount.svg" alt="Amount" title="Amount" />
                                                                                </span>
                                                                                <em>Amount</em>
                                                                                <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Amount" title="Amount" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Amount" title="Amount" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Amount" title="Amount" />
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="table-body" id="table-body-payments">
                                                                {include file="includes/main/buyer_payments.tpl"}
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flag2"></div>
                                    {else}
                                        <div class="content">
                                            <p>We don't have any payments yet. Go win some auctions!</p>
                                            <a href="/auctions/" class="btn-2 blue" title="Get Started">Get Started</a>
                                        </div>
                                    {/if}
                                </div>

                                <!-- MY WATCHED LISTINGS -->
                                <div class="page {if $parameters.mode == "watched_listings"}active{/if}">
                                    <h4 class="head-title">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My watched Listings" title="My watched Listings"/>
                                        </div>
                                        <span>My watched Listings</span>
                                    </h4>
                                    <div class="module-search-listing">
                                        <div class="content">
                                            <div class="listing-1 balancer gridview buyer-watched-listing">
                                                {include file="buyer_watched_listings.tpl"}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MY WATCHED SELLERS -->
                                <div class="page {if $parameters.mode == "watched_sellers"}active{/if}">
                                    <h4 class="head-title">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="My Watched Sellers" title="My Watched Sellers" />
                                        </div>
                                        <span>My Watched Sellers</span>
                                    </h4>
                                    <div class="module-search-listing">
                                        <div class="content">
                                            <div class="listing-1 balancer gridview">
                                            {if $parameters.buyer_watched_sellers}
                                                {foreach from=$parameters.buyer_watched_sellers item=item}
                                                    <div class="item">
                                                        <div class="img-holder border"
                                                             {if $item->profile_photo}style="background-image: url('/site_media/{$item->profile_photo}/md/')"{else}style="background-image: url('/images/default-user-image.png');"{/if}>
                                                            <div class="buyer-star-seller {if in_array($item->id, $parameters.buyer_favorites_sellers)} active{/if}" record-id="{$item->id}">
                                                                <img class="svg-icon-inject" src="/images/icons/star.svg" alt="Favorites Sellers" title="Favorites Sellers" />
                                                            </div>
                                                            {if $item->profile_photo}
                                                                <img src="/site_media/{$item->profile_photo}/md/" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}" />
                                                            {else}
                                                                <img src="/images/default-user-image.png" alt="{$item->year} {$item->make} {$item->model}" title="{$item->year} {$item->make} {$item->model}" />
                                                            {/if}
                                                            <div class="fake-link" data-link="/seller/{$item->url_title|escape}"></div>
                                                        </div>
                                                        <div class="text">
                                                            <div>
                                                                <a class="real-link" href="/seller/{$item->url_title|escape}">
                                                                    <h2 class="title"><span>{$item->name|escape}</span></h2>
                                                                </a>
                                                                <p>
                                                                    <span>{$item->city}{if $item->city}, {/if}{$item->state} </span>
                                                                    {if $item->distance != 0}<span
                                                                            class="mi"> {$item->distance|ceil}mi</span>{/if}
                                                                </p>
                                                                <p>{if $item->auctions != 0 || $item->auctions}<strong>
                                                                        Auctions: {$item->auctions}</strong>{/if}</p>
                                                            </div>
                                                            <a class="btn-2 blue" href="/seller/{$item->url_title|escape}">view listings</a>
                                                        </div>
                                                    </div>
                                                {/foreach}
                                            {else}
                                                <div class="content">
                                                    <p>You haven't watched any sellers yet. You can get started by seeing what's currently being offered for sale.</p>
                                                    <a href="/auctions/" class="btn-2 blue" title="Get Started">VIEW CURRENT AUCTIONS</a>
                                                </div>
                                            {/if}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MY BIDS -->
                                <div class="page {if $parameters.mode == "bids"}active{/if}">
                                    <h4 class="head-title button-add">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-mypayment.svg" alt="My Bids" title="My Bids" />
                                        </div>
                                        <span>My Bids</span>
                                    </h4>
                                    <br/>
                                    <br/>
                                    {if $parameters.bids}
                                        {if $parameters.bids.current}
                                            <h2 style="padding:20px 40px;">Current Auctions</h2>
                                            <div id="flag1"></div>
                                            <div class="baron-table">
                                                <div class="baron__clipper">
                                                    <div class="topScrollVisible-inner baron__scroller" style="overflow-x:auto">
                                                        <div class="baron__bar"></div>
                                                        <div class="topScrollTableLength"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flag1"></div>
                                            <div class="baron-table">
                                                <div class="baron__clipper">
                                                    <div class="payment-table-holder baron__scroller">
                                                        <div class="baron__bar"></div>
                                                        <div class="payment-table-scroll-holder">
                                                        <div class="payment-table">
                                                            <div class="table-header">
                                                                <div class="table-row">
                                                                    <div class="cell orderBnt" data-number="1">
                                                                        <div class="item">
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
                                                                    <div class="cell orderBnt" data-number="2">
                                                                        <div class="item">
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
                                                                    <div class="cell orderBnt" data-number="3">
                                                                        <div class="item">
                                                                            <span class="ico left">
                                                                                <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Bid" title="Bid" />
                                                                            </span>
                                                                            <em>Current Bid</em>
                                                                            <!-- <span class="ico right">
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Bid" title="Bid" />
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Bid" title="Bid" />
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Bid" title="Bid" />
                                                                            </span> -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="cell orderBnt" data-number="4">
                                                                        <div class="item">

                                                                            <em>Maximum Proxy</em>

                                                                        </div>
                                                                    </div>
                                                                    <div class="cell orderBnt" data-number="5">
                                                                        <div class="item">

                                                                            <em>Status</em>

                                                                        </div>
                                                                    </div>

                                                                    <div class="cell orderBnt" data-number="4">
                                                                        <div class="item">

                                                                            <em>Action</em>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="table-body">
                                                                {foreach from=$parameters.bids.current item=item}
                                                                    <div class="table-row " >
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="1" data-text="Car: Model & year">
                                                                            <div class="flex">
                                                                                <div class="img-holder" style="background-image: url('{if $item->auction_image}/site_media/{$item->auction_image}/bd/{else}/images/bg/bg-thumb.jpg{/if}')"></div>
                                                                                <span class="el" data-sort="{$item->year}">{$item->year} - {$item->make|escape} {$item->model|escape} </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="2" data-text="Date">
                                                                            <div class="el" data-sort="{$item->datetime_create|@strtotime}">{$item->datetime_create|date_format}</div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="3" data-text="Current Bid">
                                                                            <div class="el" data-sort="{$item->bid_price}">
                                                                                ${$item->bid_price|money_format}
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="4" data-text="Maximum Proxy">
                                                                            <div class="el">
                                                                                {if $item->bet_win_big != ""}
                                                                                    ${$item->bet_win_big|money_format}
                                                                                {/if}
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="5" data-text="Status">
                                                                            <div class="el">
                                                                                {if $item->bet_win == "Lost" || $item->bet_win == "Out Bid" }
                                                                                    <p style="color:red;margin: 0px;">{$item->bet_win}</p>
                                                                                {else}
                                                                                    <p style="color:green;margin: 0px;">{$item->bet_win}</p>
                                                                                {/if}
                                                                            </div>
                                                                        </div>

                                                                        <div class="cell" data-number="5" data-text="Action">
                                                                            <div class="el open-detail" rel="view-{$item->id}">
                                                                              <span class="describe btn-2 blue">
                                                                                  <strong class="val big" style="color:white">View All</strong>
                                                                              </span>
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


                                            {foreach from=$parameters.bids.current item=item1}
                                            <div class="table-view-all" id="view-{$item1->id}" >
                                                <span class="close">
                                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 21.9 21.9" enable-background="new 0 0 21.9 21.9" width="512px" height="512px" class="svg-icon-inject replaced-svg">
                                                    <path class="ic" d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z" fill="#FFFFFF"></path>
                                                  </svg>
                                                </span>
                                                <div class="baron-table">
                                                    <div class="baron__clipper">
                                                        <div class="payment-table-holder baron__scroller">
                                                            <div class="baron__bar"></div>
                                                            <div class="payment-table-scroll-holder">
                                                            <div class="payment-table">
                                                                <div class="table-header">
                                                                    <div class="table-row">
                                                                        <div class="cell orderBnt" data-number="1">
                                                                            <div class="item">
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
                                                                        <div class="cell orderBnt" data-number="2">
                                                                            <div class="item">
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
                                                                        <div class="cell orderBnt" data-number="3">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Bid" title="Bid" />
                                                                                </span>
                                                                                <em>Current Bid</em>
                                                                                <!-- <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Bid" title="Bid" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Bid" title="Bid" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Bid" title="Bid" />
                                                                                </span> -->
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <div class="table-body">
                                                                    {foreach from=$item1->list_detail item=item}
                                                                        <div class="table-row " >
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="1" data-text="Car: Model & year">
                                                                                <div class="flex">
                                                                                    <div class="img-holder" style="background-image: url('{if $item->auction_image}/site_media/{$item->auction_image}/bd/{else}/images/bg/bg-thumb.jpg{/if}')"></div>
                                                                                    <span {if $item->this == 1}style="color : green"{/if} class="el" data-sort="{$item->year}">{$item->year} - {$item->make|escape} {$item->model|escape} </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="2" data-text="Date">
                                                                                <div {if $item->this == 1}style="color : green"{/if} class="el" data-sort="{$item->datetime_create|@strtotime}">{$item->datetime_create|date_format}</div>
                                                                            </div>
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="3" data-text="Current Bid">
                                                                                <div {if $item->this == 1}style="color : green"{/if} class="el" data-sort="{$item->bid_price}">
                                                                                    ${$item->bid_price|money_format}
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

                                            </div>
                                            {/foreach}
                                        {/if}


                                        {if $parameters.bids.past}
                                            <h2 style="padding:20px 40px;">Past Auctions</h2>
                                            <div class="baron-table">
                                                <div class="baron__clipper">
                                                    <div class="topScrollVisible-inner baron__scroller" style="overflow-x:auto">
                                                        <div class="baron__bar"></div>
                                                        <div class="topScrollTableLength"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flag3"></div>
                                            <div class="baron-table">
                                                <div class="baron__clipper">
                                                    <div class="payment-table-holder baron__scroller">
                                                        <div class="baron__bar"></div>
                                                        <div class="payment-table">
                                                            <div class="table-header">
                                                                <div class="table-row">
                                                                    <div class="cell orderBnt" data-number="1">
                                                                        <div class="item">
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
                                                                    <div class="cell orderBnt" data-number="2">
                                                                        <div class="item">
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
                                                                    <div class="cell orderBnt" data-number="3">
                                                                        <div class="item">
                                                                            <span class="ico left">
                                                                                <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Bid" title="Bid" />
                                                                            </span>
                                                                            <em>Current Bid</em>
                                                                            <!-- <span class="ico right">
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Bid" title="Bid" />
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Bid" title="Bid" />
                                                                                <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Bid" title="Bid" />
                                                                            </span> -->
                                                                        </div>
                                                                    </div>
                                                                    <div class="cell orderBnt" data-number="4">
                                                                        <div class="item">

                                                                            <em>Maximum Proxy</em>

                                                                        </div>
                                                                    </div>
                                                                    <div class="cell orderBnt" data-number="5">
                                                                        <div class="item">

                                                                            <em>Status</em>

                                                                        </div>
                                                                    </div>
                                                                    <div class="cell orderBnt" data-number="4">
                                                                        <div class="item">

                                                                            <em>Action</em>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="table-body">
                                                                {foreach from=$parameters.bids.past item=item}
                                                                    <div class="table-row" data-link="/auctions/{$item->auction_id}/">
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="1"
                                                                             data-text="Car: Model & year">
                                                                            <div class="flex">
                                                                                <div class="img-holder" style="background-image: url('{if $item->auction_image}/site_media/{$item->auction_image}/bd/{else}/images/default-car-image-small.png{/if}')"></div>
                                                                                <span class="el" data-sort="{$item->year}">{$item->year} - {$item->make|escape} {$item->model|escape} </span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="2" data-text="Date">
                                                                            <div class="el" data-sort="{$item->datetime_create|@strtotime}">{$item->datetime_create|date_format}</div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="3" data-text="Current Bid">
                                                                            <div class="el" data-sort="{$item->bid_price}">
                                                                                ${$item->bid_price|money_format}
                                                                            </div>
                                                                        </div>

                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="4" data-text="Maximum Proxy">
                                                                            <div class="el">
                                                                                {if $item->bet_win_big != ""}
                                                                                    ${$item->bet_win_big|money_format}
                                                                                {/if}
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="5" data-text="Status">
                                                                            <div class="el">
                                                                                {if $item->bet_win == "Lost"}
                                                                                    <p style="color:red;margin: 0px;">{$item->bet_win}</p>
                                                                                {else}
                                                                                    <p style="color:green;margin: 0px;">{$item->bet_win}</p>
                                                                                {/if}
                                                                            </div>
                                                                        </div>
                                                                        <div class="cell" data-number="5" data-text="Action">
                                                                            {if $item->bet_win == "Won"}
                                                                                  <a href="/auctions/{$item->id}/bill/">
                                                                                    <span class="describe btn-2 blue">
                                                                                        <strong class="val big" style="color:white">Bill</strong>
                                                                                    </span>
                                                                                  </a>
                                                                            {/if}
                                                                            <div class="el open-detail"  rel="view-{$item->id}">
                                                                              <span class="describe btn-2 blue">
                                                                                  <strong class="val big" style="color:white">View All</strong>
                                                                              </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                {/foreach}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="flag4"></div>
                                            {foreach from=$parameters.bids.past item=item1}
                                            <div class="table-view-all" id="view-{$item1->id}" >
                                                <span class="close">
                                                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 21.9 21.9" enable-background="new 0 0 21.9 21.9" width="512px" height="512px" class="svg-icon-inject replaced-svg">
                                                    <path class="ic" d="M14.1,11.3c-0.2-0.2-0.2-0.5,0-0.7l7.5-7.5c0.2-0.2,0.3-0.5,0.3-0.7s-0.1-0.5-0.3-0.7l-1.4-1.4C20,0.1,19.7,0,19.5,0  c-0.3,0-0.5,0.1-0.7,0.3l-7.5,7.5c-0.2,0.2-0.5,0.2-0.7,0L3.1,0.3C2.9,0.1,2.6,0,2.4,0S1.9,0.1,1.7,0.3L0.3,1.7C0.1,1.9,0,2.2,0,2.4  s0.1,0.5,0.3,0.7l7.5,7.5c0.2,0.2,0.2,0.5,0,0.7l-7.5,7.5C0.1,19,0,19.3,0,19.5s0.1,0.5,0.3,0.7l1.4,1.4c0.2,0.2,0.5,0.3,0.7,0.3  s0.5-0.1,0.7-0.3l7.5-7.5c0.2-0.2,0.5-0.2,0.7,0l7.5,7.5c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3l1.4-1.4c0.2-0.2,0.3-0.5,0.3-0.7  s-0.1-0.5-0.3-0.7L14.1,11.3z" fill="#FFFFFF"></path>
                                                  </svg>
                                                </span>
                                                <div class="baron-table">
                                                    <div class="baron__clipper">
                                                        <div class="payment-table-holder baron__scroller">
                                                            <div class="baron__bar"></div>
                                                            <div class="payment-table-scroll-holder">
                                                            <div class="payment-table">
                                                                <div class="table-header">
                                                                    <div class="table-row">
                                                                        <div class="cell orderBnt" data-number="1">
                                                                            <div class="item">
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
                                                                        <div class="cell orderBnt" data-number="2">
                                                                            <div class="item">
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
                                                                        <div class="cell orderBnt" data-number="3">
                                                                            <div class="item">
                                                                                <span class="ico left">
                                                                                    <img class="svg-icon-inject" src="/images/icons/icon-buyerfee.svg" alt="Bid" title="Bid" />
                                                                                </span>
                                                                                <em>Current Bid</em>
                                                                                <!-- <span class="ico right">
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up-and-down.svg" alt="Bid" title="Bid" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-up.svg" alt="Bid" title="Bid" />
                                                                                    <img class="svg-icon-inject" src="/images/icons/sort-arrows-couple-pointing-down.svg" alt="Bid" title="Bid" />
                                                                                </span> -->
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>
                                                                <div class="table-body">
                                                                    {foreach from=$item1->list_detail item=item}
                                                                        <div class="table-row " >
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="1" data-text="Car: Model & year">
                                                                                <div class="flex">
                                                                                    <div class="img-holder" style="background-image: url('{if $item->auction_image}/site_media/{$item->auction_image}/bd/{else}/images/bg/bg-thumb.jpg{/if}')"></div>
                                                                                    <span class="el" data-sort="{$item->year}">{$item->year} - {$item->make|escape} {$item->model|escape} </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="2" data-text="Date">
                                                                                <div class="el" data-sort="{$item->datetime_create|@strtotime}">{$item->datetime_create|date_format}</div>
                                                                            </div>
                                                                            <div class="cell fake-link" data-link="/auctions/{$item->auction_id}/" data-number="3" data-text="Current Bid">
                                                                                <div class="el" data-sort="{$item->bid_price}">
                                                                                    ${$item->bid_price|money_format}
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

                                            </div>
                                            {/foreach}
                                        {/if}
                                    {else}
                                        <div class="content">
                                            <p>We don't have any payments yet. Go win some auctions!</p>
                                            <a href="/auctions/" class="btn-2 blue" title="Get Started">Get Started</a>
                                        </div>
                                    {/if}
                                </div>
                            </div>


                            {if $parameters.buyer_watched_listings}
                                <div class="row no-gutters">
                                    <div class="container">
                                        <div class="col-24">
                                            <div class="content">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            <div class="one-col-structure" {if !$parameters.payments || !$parameters.buyer_watched_sellers || !$parameters.buyer_watched_listings}style="display: none;"{/if}>
                                {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {include file="includes/main/popup_file_upload.tpl"}

            {include file="includes/main/popup_account_buyer_switch.tpl"}

            {include file="includes/main/popup_auction_bid_buy.tpl"}

        </div>
    </main>
    </div>
    </body>
    </html>
{/strip}
