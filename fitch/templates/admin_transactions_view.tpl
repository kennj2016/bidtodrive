{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js?v=5"></script>

    <div class="bread-crumb-custom"><a href="/admin" style="color:#5c5c5c;">Administration</a> : <a href="/admin/transactions/" style="color:#5c5c5c;">Transactions</a> : View Transaction #{$parameters.record->id}</div>
    <div class="transaction-err" style="display:none;color: #ff0000;text-align: center;padding: 10px;background: #fff;font-size: 14px;margin-top: 10px;border: 1px solid #ededed;"></div>

    <div class="section">
        <div class="section-title-box">
            <a href="/admin/transactions/" class="button1">cancel</a>
        </div>
    </div>

    <div class="section">

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Auction Name
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->auction_name|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Name
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->buyer_name|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Email
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->buyer_email|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Phone
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->buyer_phone|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Address
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->buyer_address|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer City
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text" >{$parameters.record->buyer_city|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer State
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->buyer_state|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Zip
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->buyer_zip|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Seller Name
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->seller_name|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Seller Address
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->seller_address|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Seller Email
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->seller_email|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Sale Price
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">${$parameters.record->sale_price|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Buyer Fee
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">${$parameters.record->buyer_fee|escape}</div>
                </div>
            </div>
        </div>

        {if $parameters.record->status == "refunded"}
            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        Refund
                    </div>
                </div>
                <div class="form-field-input-wrap">
                    <div class="form-field-input">
                        <div class="input-text">${$parameters.record->refund_amount|escape}</div>
                    </div>
                </div>
            </div>
        {/if}

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Total
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">${math equation="x + y - z" x=$parameters.record->sale_price y=$parameters.record->buyer_fee format="%.2f" z=$parameters.record->refund_amount format="%.2f"}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Date
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->datetime|date_format} at {$parameters.record->datetime|date_format:"%I:%M:%S %p"}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Transporter
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->transporter|escape}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Purchasing Agreement
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->purchasing_agreement}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Terms & Conditions
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->terms_conditions}</div>
                </div>
            </div>
        </div>

        <div class="form-field">
            <div class="form-field-label-wrap">
                <div class="form-field-label">
                    Additional Fees
                </div>
            </div>
            <div class="form-field-input-wrap">
                <div class="form-field-input">
                    <div class="input-text">{$parameters.record->additional_fees}</div>
                </div>
            </div>
        </div>

    </div>

    <div class="section">
        <form class="validate" action="" method="post">
            <input type="hidden" name="action" value="refund" />
            <div class="form-field">
                <div class="form-field-label-wrap">
                    <div class="form-field-label">
                        refund
                    </div>
                </div>
                <div class="form-field-input-wrap" style="width: 25%;">
                    <input class="button1" type="submit" value="Refund" style="margin: 5px;" />
                </div>
                <div class="form-field-input-wrap" style="width: 50%;">
                    <div class="form-field-input">
                        <input name="refund_amount" placeholder="refund amount" value="" type="text" class="input-text" />
                    </div>
                </div>
            </div>
        </form>
    </div>


{include file="includes/admin/site_bottom.tpl"}
{/strip}
