{strip}
    {include file="includes/admin/site_top.tpl"}

    <script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>
    <script src="/js/libs/jquery.maskedinput.min.js"></script>

    <form class="validate" action="" method="post">
        <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
        <input style="opacity: 0;position: absolute;" type="email" name="fakeemailremembered">
        <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
        <div class="section">

            <div class="section-title-box">
                {*<h3>{$parameters.header.title|escape}</h3>*}
                {if $parameters.header.return}
                    <a href="{$parameters.header.return|escape}" class="button1">
                        Cancel
                    </a>
                {/if}
                <input class="button1" type="submit" value="save" />
            </div>

            <div class="section">
                <div class="section-title-box">
                    <h3>
                        Status
                    </h3>
                </div>
                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Active
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <select name="status">
                                <option value="0">No</option>
                                <option value="1"{if $parameters.record->status} selected="selected"{/if}>Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        name<span class="text-red"> *</span>
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input class="input-text" type="text" placeholder="name" name="name" value="{$parameters.record->name|escape}" />
                    </div>
                </div>
            </div>

            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        email<span class="text-red"> *</span>
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input type="text" name="email" value="" style="display: none" /> 
                        <input class="input-text" type="text" placeholder="email" name="email" value="{$parameters.record->email|escape}" autocomplete="off" />
                        <input type="text" name="not-an-email" value="" style="display: none" />
                    </div>
                </div>
            </div>

            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        password{if !$parameters.record->password}<span class="text-red"> *</span>{/if}
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input class="input-text" type="password" placeholder="password" name="password" autocomplete="off"{if !$parameters.record->password} class="required"{/if} />
                    </div>
                </div>
            </div>

            {if $smarty.get.mode == 'administrators' && $parameters.record->is_admin <= $smarty.session.user->is_admin}
                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            admin permission
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <select name="is_admin">
                                <option value="1"{if $parameters.record->is_admin == 1} selected="selected"{/if}>Admin</option>
                                {if $smarty.session.user->is_admin == 2}
                                    <option value="2"{if $parameters.record->is_admin == 2} selected="selected"{/if}>Super Admin</option>
                                {/if}
                            </select>
                        </div>
                    </div>
                </div>
            {/if}

            {if $smarty.get.mode != 'administrators'}
                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            User Type
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <div class="input-text">
                                <div class="input-checkname-holder">
                                    <label id="user_type-buyer">
                                        <input name="user_type" type="radio" value="Seller"{if $parameters.record->user_type == "Seller"} checked="checked"{/if} />
                                        Seller
                                    </label>
                                    <label id="user_type-seller">
                                        <input name="user_type" type="radio" value="Buyer"{if $parameters.record->user_type == "Buyer"} checked="checked"{/if} />
                                        Buyer
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="form-field" id="buyer-type-div" style="display: none;">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        Upgrade to seller
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input class="input-text" type="text" name="upgrade_seller_note" value="{$parameters.record->upgrade_seller_note}" />
                    </div>
                </div>
            </div>

                <div class="form-field" id="buyer-type-div" style="display: none;">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Buyer Type
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <div class="input-text">
                                <div class="input-checkname-holder">
                                    <label id="buyer_type-individual">
                                        <input name="buyer_type" type="radio" value="Individual"{if $parameters.record->buyer_type == "Individual"} checked="checked"{/if} />
                                        Individual
                                    </label>
                                    <label id="buyer_type-dealer">
                                        <input name="buyer_type" type="radio" value="Dealer"{if $parameters.record->buyer_type == "Dealer"} checked="checked"{/if} />
                                        Dealer
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- BUYER INDIVIDUAL -->
                <div id="individual-type" style="display: none;">
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                drivers license number<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input class="input-text" type="text" placeholder="drivers license number" name="drivers_license_number" value="{$parameters.record->drivers_license_number|escape}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Drivers License State<span class="text-red"> *</span>
                            </div>
                        </div>
                        
                        <div class="form-field-input-wrap">
		                        <div class="form-field-input">
		                            <select name="drivers_license_state">
		                                <option value="">none (default)</option>
		                                {foreach from=$parameters.states key=value item=state}
		                                    <option value="{$value}"{if $parameters.record->drivers_license_state == $value} selected="selected"{/if}>{$state|escape}</option>
		                                {/foreach}
		                            </select>
		                        </div>
		                    </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                date of birth<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="date of birth" name="date_of_birth" value="{if $parameters.record->date_of_birth}{$parameters.record->date_of_birth|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                license issue date<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="license issue date" name="license_issue_date" value="{if $parameters.record->license_issue_date}{$parameters.record->license_issue_date|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                license expiration date<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="license expiration date" name="license_expiration_date" value="{if $parameters.record->license_expiration_date}{$parameters.record->license_expiration_date|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Drivers License Photo<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input data-site-media="licenses" name="drivers_license_photo" value="{$parameters.record->drivers_license_photo}"/>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- BUYER DEALER -->
                <div id="dealer-type" style="display: none;">
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                dealers license issued to<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="dealers license issued to" name="dealers_license_issued_to" value="{if $parameters.record->dealers_license_issued_to}{$parameters.record->dealers_license_issued_to|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                dealers license number<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input class="input-text" type="text" placeholder="dealers license number" name="dealers_license_number" value="{$parameters.record->dealers_license_number|escape}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Dealers License State<span class="text-red"> *</span>
                            </div>
                        </div>
                        
                        <div class="form-field-input-wrap">
		                        <div class="form-field-input">
		                            <select name="dealers_license_state">
		                                <option value="">none (default)</option>
		                                {foreach from=$parameters.states key=value item=state}
		                                    <option value="{$value}"{if $parameters.record->dealers_license_state == $value} selected="selected"{/if}>{$state|escape}</option>
		                                {/foreach}
		                            </select>
		                        </div>
		                    </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                dealers license issue date<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="dealers license issue date" name="dealers_license_issue_date" value="{if $parameters.record->dealers_license_issue_date}{$parameters.record->dealers_license_issue_date|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                dealers license expiration date<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input type="text" class="input-text datepicker" placeholder="dealers license expiration date" name="dealers_license_expiration_date" value="{if $parameters.record->dealers_license_expiration_date}{$parameters.record->dealers_license_expiration_date|date_format:"%Y-%m-%d"}{/if}" />
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Dealers License Photo<span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input data-site-media="licenses" name="dealers_license_photo" value="{$parameters.record->dealers_license_photo}"/>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- BUYER INDIVIDUAL OR BUYER DEALER NOTIFICATIONS -->
                <div id="buyer-notifications" style="display: none;">
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                buyer fee (in %)
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <input class="input-text" type="text" placeholder="buyer fee" name="buyer_fee" value="{if $parameters.record->buyer_fee == 0}{else}{$parameters.record->buyer_fee|escape}{/if}" />
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me of watched listings expiring
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_4">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_4 == 1} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when I win an auction
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_2">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_2} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify when me when I am outbid on an auction
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_7">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_7} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when a Watched Seller lists a new auction
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_8">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_8} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when I make a bid
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_18">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_18} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Warn me when my credit card is expiring
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_23">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_23} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <!-- SELLER -->
                <div id="seller-box" style="display: none;">

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when my listing is about to expire
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_9">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_9} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me if my reserve price is not met at an auction's conclusion
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_13">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_13} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when buyers make a bid on my auctions
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_12">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_12} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-field">
                        <div class="form-field-label-wrap">
                            <div class="form-field-label">
                                Notify me when an auction is successfully completed
                            </div>
                        </div>
                        <div class="form-field-input-wrap">
                            <div class="form-field-input">
                                <select name="notification_type_3">
                                    <option value="0">Off</option>
                                    <option value="1"{if $parameters.record->notification_type_3} selected="selected"{/if}>On</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Send All Notifications By
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <select name="notification_channel">
                                <option value=""></option>
                                <option value="sms"{if $parameters.record->notification_channel == "sms"} selected="selected"{/if}>Sms</option>
                                <option value="email"{if $parameters.record->notification_channel == "email"} selected="selected"{/if}>Email</option>
                                <option value="both"{if $parameters.record->notification_channel == "both"} selected="selected"{/if}>Both</option>
                                <option value="none"{if $parameters.record->notification_channel == "none"} selected="selected"{/if}>None</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Address
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <input type="text" class="input-text"  placeholder="address" name="address" value="{$parameters.record->address|escape}"/>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            City
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <input type="text" class="input-text"  placeholder="city" name="city" value="{$parameters.record->city|escape}"/>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            State
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <select name="state">
                                <option value="">none (default)</option>
                                {foreach from=$parameters.states key=value item=state}
                                    <option value="{$value}"{if $parameters.record->state == $value} selected="selected"{/if}>{$state|escape}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Zip Code
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <input type="text" class="input-text"  placeholder="zip code" name="zip" value="{$parameters.record->zip|escape}"/>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Mobile Number
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <input type="text" class="input-text phone_mask"  placeholder="mobile number" name="mobile_number" value="{$parameters.record->mobile_number|escape}"/>
                        </div>
                    </div>
                </div>

                <div class="form-field">
                    <div class="form-field-label-wrap">
                        <div class="form-field-label">
                            Profile Photo
                        </div>
                    </div>
                    <div class="form-field-input-wrap">
                        <div class="form-field-input">
                            <input data-site-media="users-images" name="profile_photo" value="{$parameters.record->profile_photo}"/>
                        </div>
                    </div>
                </div>
            {/if}

        </div>
    </form>

    {include file="includes/admin/site_bottom.tpl"}
{/strip}