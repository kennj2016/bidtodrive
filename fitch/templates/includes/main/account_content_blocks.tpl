{literal}
	<style type="text/css"> 
		.account-right-box .subpage .btn-2.black:hover{border:none;} 
	</style>
{/literal}
<div class="page {if $parameters.action == "account_content_blocks"}active{/if}">
    <h4 class="head-title">
        <div class="ico">
            <img class="svg-icon-inject" src="/images/icons/icon-mywatchedsellers.svg" alt="My content blocks" title="My content blocks"/>
        </div>
        <span>My content blocks</span>
    </h4>
    <div class="subpage">
        <div class="content-blocks-holder">
            <div class="content-blocks">
                <p class="cb-introductory-text">Content Blocks save you time by allowing you to use the same text on multiple auctions. You can create multiple versions of a content block (for example, several different sets of Terms & Conditions) and pick the appropriate one for each auction.</p>
            </div>
        </div>
        <div class="content-blocks-holder content-blocks-term-condition">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Terms & Conditions</h4>
                    <a class="add add_term_condition" href="#terms" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Terms & Conditions" title="Terms & Conditions" />
                        </div>
                    </a>
                </div>
                {if $parameters.content_blocks.terms}
                    {foreach from=$parameters.content_blocks.terms item=item}
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="save_term"/>
                                <input type="hidden" name="id" value="{$item->id}"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="{$item->title|escape}" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group">
                                    <label class="small">Enter Terms & Conditions</label>
                                    <textarea class="trumbowyg" name="description" cols="30">{$item->description|strip_tags|escape}</textarea>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="{$item->id}" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="{$item->id}" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    {/foreach}
                {/if}
            </div>
            <div id="terms"></div>
        </div>
        <div class="content-blocks-holder content-blocks-fee">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Additional Fees</h4>
                    <a class="add add_fee" href="#fees" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Additional Fees" title="Additional Fees"/>
                        </div>
                    </a>
                </div>
                {if $parameters.content_blocks.fees}
                    {foreach from=$parameters.content_blocks.fees item=item}
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="save_fee"/>
                                <input type="hidden" name="id" value="{$item->id}"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="{$item->title|escape}" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group">
                                    <label class="small">Enter Additional Fees</label>
                                    <textarea class="trumbowyg" name="description" cols="30">{$item->description|strip_tags|escape}</textarea>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="{$item->id}" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="{$item->id}" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    {/foreach}
                {/if}
            </div>
            <div id="fees"></div>
        </div>
        <div class="content-blocks-holder content-blocks-payment-pickup">
            <div class="content-blocks">
                <div class="title-box">
                    <h4 class="title">Payment/Pickup</h4>
                    <a class="add add_payment_pickup" href="#payment_pickup" title="Add new">
                        <span>Add new</span>
                        <div class="ico">
                            <img class="svg-icon-inject" src="/images/icons/plus.svg" alt="Payment/Pickup" title="Payment/Pickup"/>
                        </div>
                    </a>
                </div>
                {if $parameters.content_blocks.payment_pickup}
                    {foreach from=$parameters.content_blocks.payment_pickup item=item}
                        <div class="item_wrapper">
                            <form>
                                <input type="hidden" name="action" value="payment_pickup"/>
                                <input type="hidden" name="id" value="{$item->id}"/>
                                <div class="header-group">
                                    <label class="small">Title</label>
                                    <input type="text" name="title" value="{$item->title|escape}" />
                                    <span class="line"></span>
                                </div>
                                <div class="text-group select-3-payment-method">
                                    <label class="small">Payment Method</label>
                                    <select class="select-3 payment-select-custom-2" name="payment_method[]" multiple="multiple">
                                        <option value=""></option>
                                        {assign var=methods value=","|explode:$item->payment_method}
                                        {foreach name=payment_methods from=$web_config.payment_methods key=key item=method}
                                            <option value="{$key}"{if in_array($key, $methods)} selected="selected"{/if}>{$method}</option>
                                        {/foreach}
                                    </select>
                                    <div class="header-group">
                                        <label class="small">Pickup Window</label>
                                        <input type="text" name="pickup_window" value="{$item->pickup_window|escape}" />
                                    </div>
                                    <div class="text-group">
                                        <label class="small">Pickup Note</label>
                                        <textarea class="trumbowyg" name="pickup_note" cols="30">{$item->pickup_note|strip_tags|escape}</textarea>
                                    </div>
                                </div>
                                <div class="button-group">
                                    <a href="#" data-id="{$item->id}" data-type="save" class="btn-2 black" title="Save">Save</a>
                                    <a href="#" data-id="{$item->id}" data-type="delete" class="btn-2 blue" title="Delete">Delete</a>
                                </div>
                            </form>
                        </div>
                    {/foreach}
                {/if}
            </div>
            <div id="payment_pickup"></div>
        </div>
    </div>
</div>