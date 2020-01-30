{strip}
    {include file="includes/admin/site_top.tpl"}

    <script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

    <form class="validate" action="" method="post">
        <div class="section">

            <div class="section-title-box">
                <a href="/admin/email_templates/" class="button1">cancel</a>
                {include file="includes/admin/revisions_action.tpl"}
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
                            active
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
                        template name<span class="text-red"> *</span>
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input type="text" class="input-text" placeholder="name" name="name" value="{$parameters.record->name|escape}"/>
                    </div>
                </div>
            </div>

            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        Subject<span class="text-red"> *</span>
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <input type="text" class="input-text" placeholder="Subject" name="subject" value="{$parameters.record->subject|escape}"/>
                    </div>
                </div>
            </div>

            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        body<span class="text-red"> *</span>
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-label" style="font-size: 14px;padding: 10px;">
                        <span style="font-weight: 600;">Available Variables:</span> {if $parameters.record->id != 24}%NAME%, %EMAIL%{/if}
                        {if $parameters.record->id == 1}
                            , %LINK%
                        {elseif $parameters.record->id == 4}
                            , %AUCTION TITLE%, %RELIST_LINK%, %LINK ACCEPT HIGHEST BID%
                        {elseif $parameters.record->id == 5}
                            , %MAKE%, %MODEL%, %YEAR%, %FINAL_BID%, %BUYER_FEE%, %TOTAL_PRICE%, %SELLER_NAME%, %SELLER_ADDRESS%, %SELLER_CITY%, %SELLER_STATE%, %SELLER_ZIP%, %SELLER_EMAIL%, %SELLER_PHONE%, %BILL_OF_SALE_LINK%
                        {elseif $parameters.record->id == 6}
                            , %MAKE%, %MODEL%, %YEAR%, %BUY_NOW_PRICE%, %BUYER_NAME%, %BUYER_ADDRESS%, %BUYER_CITY%, %BUYER_STATE%, %BUYER_ZIP%, %BUYER_EMAIL%, %BUYER_PHONE%, %BILL_OF_SALE_LINK%
                        {elseif $parameters.record->id == 7}
                            , %MAKE%, %MODEL%, %YEAR%, %BUY_NOW_PRICE%, %SELLER_NAME%, %SELLER_ADDRESS%, %SELLER_CITY%, %SELLER_STATE%, %SELLER_ZIP%, %SELLER_EMAIL%, %SELLER_PHONE%, %BILL_OF_SALE_LINK%
                        {elseif $parameters.record->id == 8}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 9}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %PREVIOUS_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 10}
                            , %MAKE%, %MODEL%, %YEAR%, %SELLER_NAME%, %STARTING_BID%, %BUY_NOW_PRICE%, %EXPIRATION_DATE%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 11}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 12}
                            , %MAKE%, %MODEL%, %YEAR%, %FINAL_BID%, %BUYER_NAME%, %BUYER_ADDRESS%, %BUYER_CITY%, %BUYER_STATE%, %BUYER_ZIP%, %BUYER_EMAIL%, %BUYER_PHONE%, %BILL_OF_SALE_LINK%
                        {elseif $parameters.record->id == 13}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 16}
                            , %MAKE%, %MODEL%, %YEAR%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 17}
                            , %MAKE%, %MODEL%, %YEAR%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 18}
                            , %MAKE%, %MODEL%, %YEAR%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 19}
                            , %MAKE%, %MODEL%, %YEAR%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 14}
                            , %TYPE_OF_LICENSE%, %LICENSE_EXPIRATION_DATE%
                        {elseif $parameters.record->id == 15}
                            , %TYPE_OF_LICENSE%, %LICENSE_EXPIRATION_DATE%
                        {elseif $parameters.record->id == 16}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 17}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 20}
                            , %MAKE%, %MODEL%, %YEAR%, %AUCTION_LINK%, %RELIST_LINK%, %ACCEPT_HIGHEST_BID_LINK%
                        {elseif $parameters.record->id == 21}
                            , %MAKE%, %MODEL%, %YEAR%, %CURRENT_BID%, %AUCTION_LINK%
                        {elseif $parameters.record->id == 22}
                            , %MAKE%, %MODEL%, %YEAR%, %BUYER_NAME%, %SELLER_NAME%, %WINNING_BID%, %BUYER_FEE%, %AUCTION_ID%, %AUCTION_LINK%, %TIME_OF_FAILURE%
                        {elseif $parameters.record->id == 23}
                            , %MAKE%, %MODEL%, %YEAR%, %BUYER_NAME%, %SELLER_NAME%, %WINNING_BID%, %BUYER_FEE%, %AUCTION_ID%, %AUCTION_LINK%, %TIME_OF_FAILURE%
                        {elseif $parameters.record->id == 24}
                            , %MAKE%, %MODEL%, %YEAR%, %BUYER_NAME%, %SELLER_NAME%, %WINNING_BID%, %BUYER_FEE%, %AUCTION_ID%, %AUCTION_LINK%, %TIME_OF_FAILURE%
                        {elseif $parameters.record->id == 25}
                            , %CC_EXPIRATION_DATE%, %CC_LAST_FOUR_DIGITS%
                        {elseif $parameters.record->id == 26}
                            , %CC_EXPIRATION_DATE%, %CC_LAST_FOUR_DIGITS%
                        {/if}
                    </div>
                    <div class="form-field-input">
                        <textarea class="input-text ckeditor" placeholder="body" name="body">{$parameters.record->body}</textarea>
                    </div>
                </div>
            </div>

            {include file="includes/admin/admin_creators.tpl"}

        </div>
    </form>

    {include file="includes/admin/revisions.tpl" id=$smarty.get.id}

    {include file="includes/admin/site_bottom.tpl"}
{/strip}