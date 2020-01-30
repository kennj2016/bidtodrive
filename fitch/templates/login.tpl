{strip}
{include file="includes/main/site_top.tpl"}

    <div class="row no-gutters bg-image full-height overflow">
        <div class="container full-height">
            <div class="col-24 full-height">
                <div class="module-login">
                    <span class="tint"></span>
                    <div class="honeycomb"></div>
                    <div class="content">
                        <div class="box-holder">
                            <div class="sign"></div>
                            <div class="left">
                                <div class="holder">
                                    <h3 class="title">bid to drive</h3>
                                    {if $parameters.page->left_title}<p class="subtitle">{$parameters.page->left_title|escape}</p>{/if}
                                    {if $parameters.page->left_description}<p>{$parameters.page->left_description|escape}</p>{/if}
                                </div>
                            </div>
                            <div class="right">
                                <div class="holder">
                                    <div class="module-tab-2 break skin-1-alt color-1">
                                        <div class="content">
                                            <div class="tab-index">
                                                <div class="list">
                                                    <a class="item fake-tab active" href="/login/" title="login">login</a>
                                                    {*<a class="item fake-tab" href="/register/" title="register">register</a>*}
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-item active">
                                                    {include file="includes/main/tablogin.tpl"}
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
        </div>
    </div>

{include file="includes/main/site_bottom.tpl"}
{/strip}