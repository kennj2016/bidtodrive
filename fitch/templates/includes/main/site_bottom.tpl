{strip}
    {if !$skip_html_bottom}
        </main>
    {/if}
    {if $parameters.cmd == "contact" || $parameters.cmd == "login" || $parameters.cmd == "forgot_password" || $parameters.cmd == "register" || $parameters.cmd == "reset_password"}
        <footer class="footer row flex no-gutters short">
            <div class="container">
                <div class="col-24 last first">
                    <p class="copy">Bid to Drive &copy; {$smarty.now|date_format:"%Y"}</p>
                </div>
            </div>
        </footer>
    {else}
        {if $parameters.cmd != "auctions" && $parameters.cmd != "auctions_edit" && $parameters.cmd != "account" && $parameters.cmd != "account_security_access" && $parameters.cmd != "account_seller_notification_settings" && $parameters.cmd != "account_buyer" && $parameters.cmd != "account_buyer_billing_details" && $parameters.cmd != "account_buyer_notification_settings" && $parameters.cmd != "accept_highest_bid"}
        <footer class="footer row flex no-gutters">
            <div class="container">
                {if $parameters.cmd == "homepage"}
                    <div class="col-12 col-t-24">
                        <div class="part-1" id="footer-contact-form-wrap">
                            <form action="" class="form" id="footer-contact-form">
                                <div class="field-block-1">
                                    <div class="block-1">
                                        {if $page->siteVar("footer_contact_form_title")}<h4>{$page->siteVar("footer_contact_form_title")}</h4>{/if}
                                        {if $page->siteVar("footer_contact_form_subtitle")}<p>{$page->siteVar("footer_contact_form_subtitle")}</p>{/if}
                                    </div>
                                    <div class="block-2 block-2-name">
                                        <input type="text" class="text" placeholder="Name" name="name" id="ff-contact-name" />
                                    </div>
                                    <div class="block-2 block-2-email">
                                        <input type="text" class="text" placeholder="Email" name="email" id="ff-contact-email" />
                                    </div>
                                    {assign var=reasons value=$page->getAllContactReasons()}
                                    {if $reasons}
                                        <div class="block-1">
                                            <select name="contact_reason">
                                                <option value="">Reason for Contacting Us</option>
                                                {foreach from=$reasons item=item}
                                                    <option value="{$item->title}">{$item->title|escape}</option>
                                                {/foreach}
                                            </select>
                                        </div>
                                    {/if}
                                    <div class="block-1 block-1-message">
                                        <textarea cols="" rows="" placeholder="Message..." name="message" id="ff-contact-message"></textarea>
                                    </div>
                                    <div class="block-1 flex-h-right">
                                        <input type="submit" class="submit btn-2 blue contact-form-send-click" value="Submit" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div id="footer-contact-form-thank" style="display:none;">
                            <h2 class="header-title">Thank You!</h2>
                            <h2 class="header-title">Your message was submitted successfully.</h2>
                        </div>
                    </div>
                {/if}
                <div class="col-12 col-t-24">
                    <div class="spacer"></div>
                    <div class="part-2">
                        <ul class="social">
                            {if $page->siteVar("facebook_url")}<li><a href="{$page->siteVar("facebook_url")}" target="_blank" title="facebook"><img class="svg-icon-inject" src="/images/icons/icon-facebook.svg" alt="facebook" title="facebook"/></a></li>{/if}
                            {if $page->siteVar("instagram_url")}<li><a href="{$page->siteVar("instagram_url")}" target="_blank" title="instagram"><img class="svg-icon-inject" src="/images/icons/icon-instagram.png" alt="instagram" title="instagram"/></a></li>{/if}
                            {if $page->siteVar("youtube_url")}
                            <li><a href="{$page->siteVar("youtube_url")}" target="_blank" title="youtube">
                              <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                              	 viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve">
                              <g>
                              	<g>
                              		<path d="M207.5,301.2c35-18.2,69.7-36.2,104.8-54.4c-35.1-18.4-69.9-36.5-104.8-54.7V301.2z M250,16.4
                              			C121.1,16.4,16.6,121,16.6,250c0,129,104.5,233.6,233.4,233.6c128.9,0,233.4-104.6,233.4-233.6C483.4,121,378.9,16.4,250,16.4z
                              			 M409,328c-4,17.5-18.4,30.5-35.6,32.4C332.5,365,291.2,365,250,365c-41.2,0-82.6,0-123.4-4.6C109.3,358.5,95,345.5,91,328
                              			c-5.7-25-5.7-52.3-5.7-78s0.1-53,5.8-78c4-17.5,18.4-30.5,35.6-32.4c40.9-4.6,82.2-4.6,123.4-4.6c41.2,0,82.5,0,123.4,4.6
                              			c17.3,1.9,31.6,14.9,35.6,32.4c5.7,25,5.7,52.3,5.7,78S414.8,303,409,328z"/>
                              	</g>
                              </g>
                              </svg>

                            </a></li>{/if}
                        </ul>
                        <div class="hold">
                            <div class="logo">
                                <img class="svg-icon-inject" src="/images/icons/logo.svg" alt="Logo Icon" title="Logo Icon"/>
                            </div>
                            <div class="stripes"></div>
                            <p>Bid to Drive &copy; {$smarty.now|date_format:"%Y"}</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        {/if}
    {/if}

    {user_uid assign="user_uid"}
    {assign var=version value=$smarty.now|date_format:"%Y%m%d%H%M%S"}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>
    <script src="/js/libs/jquery-ui.min.js"></script>
    <script src="/js/libs/modernizr-2.6.2.min.js"></script>
    <script src="/js/libs/ScrollToPlugin.min.js"></script>
    <script src="/js/libs/TweenMax.min.js"></script>
    <script src="/js/libs/selectize.js"></script>
    <script src="/js/libs/slick.js"></script>
    <script src="/js/libs/jquery.validate.min.js"></script>
    <script src="/js/libs/openclose.js"></script>
    <script src="/js/libs/baron.js"></script>
    <script src="/js/libs/nouislider.js"></script>
    <script src="/js/libs/fileuploader.js"></script>
    <script src="/js/libs/jquery-backward-timer.min.js"></script>
    <script src="/js/libs/dropzone.js"></script>
    <script src="/js/libs/jquery-clickout.min.js"></script>
    <script src="/js/libs/jquery.visible.js"></script>
    <script src="/js/libs/autosize.min.js"></script>
    <script src="/js/libs/jquery.cookie.js"></script>
    <script src="/js/libs/autonumeric.js"></script>
    <script src="/js/main/iao-alert-custom.jquery.js"></script>
    <script src="/js/main/main.js?v={$version}"></script>
    <script src="/js/main/custom.js?v={$version}"></script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b716453594c1a33"></script>

    <script src="/js/libs/slick-lightbox.min.js"></script>
    <script src="/js/libs/slick-lightbox.js"></script>
    <script type="text/javascript" src="/fitch/resources/fancybox/lib/jquery.mousewheel.pack.js"></script>

    <script src="/js/libs/swipebox/js/jquery.swipebox.js"></script>
    <link rel="stylesheet" href="/js/libs/swipebox/css/swipebox.css">
    <!-- realtime -->
    <script src="http://bidtodrive.kennjdemo.com:3000/socket.io/socket.io.js"></script>
    <script src="/js/main/realtime.js"></script>
    <!-- end realtime -->
    <!-- update notification manual -->
    <script src="/js/main/notification-manual.js"></script>
    <!-- end notification manual -->
    <!-- update check vin number -->
    <script src="/js/main/api_check_vin_number.js"></script>
    <!-- end check vin number -->
    <!-- add uship api -->
    {*<script src="/js/main/uship.js"></script>*}
    <!-- end uship api -->
    <script>
        var pageCMD = '{$parameters.cmd}';
    </script>

    {if $user_uid != ""}
        <script>
            var uid = '{$user_uid}';
        </script>
        <script src="/js/main/notifications.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "homepage"}
        <script src="/js/libs/jquery.countdown.min.js"></script>
        <script src="/js/main/homepage.js"></script>
    {/if}
    {if $parameters.cmd == "contact"}
        <script src="/js/main/contact.js"></script>
    {/if}
    {if $parameters.cmd == "login"}
        <script src="/js/main/login.js"></script>
    {/if}
    {if $parameters.cmd == "forgot_password"}
        <script src="/js/main/forgot_password.js"></script>
    {/if}
    {if $parameters.cmd == "news"}
        <script src="/js/main/news.js"></script>
    {/if}
    {if $parameters.cmd == "auctions" || $parameters.cmd == "seller_profile"}
        <script src="/js/main/auctions.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "register"}
        <script src="/js/libs/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <script type="text/javascript">Stripe.setPublishableKey('{$web_config.stripe.public_key|escape}');</script>
        <script src="/js/main/register.js"></script>
    {/if}
    {if $parameters.cmd == "reset_password"}
        <script src="/js/main/reset_password.js"></script>
    {/if}
    {if $parameters.cmd == "account_buyer"}
        <script src="/js/libs/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <script type="text/javascript">Stripe.setPublishableKey('{$web_config.stripe.public_key|escape}');</script>
        <script src="/js/main/account_buyer.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "account"}
        <script src="/fitch/resources/trumbowyg/trumbowyg.min.js"></script>
        <link rel="stylesheet" href="/fitch/resources/trumbowyg/ui/trumbowyg.min.css">
        <script src="/js/libs/autosize.min.js"></script>
        <script src="/js/libs/jquery.maskedinput.min.js"></script>
        <script src="/js/main/account.js?v=3"></script>
        <script src="/js/main/account_content_blocks.js?v=3"></script>
    {/if}
    {if $parameters.cmd == "auctions_edit"}
        <script>
            var paymentMethods = {$parameters.payment_methods};
            var interiorColors = {$parameters.interior_colors_js};
            var exteriorColors = {$parameters.exterior_colors_js};
        </script>
        <script src="/fitch/resources/trumbowyg/trumbowyg.min.js"></script>
        <link rel="stylesheet" href="/fitch/resources/trumbowyg/ui/trumbowyg.min.css">
        <script src="/js/libs/autosize.min.js"></script>
        <script src="/js/libs/jquery.maskedinput.min.js"></script>
        <script src="/js/main/auctions_edit.js?v={$version}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
    {/if}
    {if $parameters.cmd == "auctions_details"}
        <script>
            var swipeboxItems = {$parameters.swipebox_items};
        </script>
        <script src="/js/libs/jquery.maskedinput.min.js"></script>
        <script src="/js/libs/autosize.min.js"></script>
        <script src="/js/main/auctions_details.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "account_buyer_billing_details"}
        <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
        <script type="text/javascript">Stripe.setPublishableKey('{$web_config.stripe.public_key|escape}');</script>
        <script src="/js/main/account_buyer_billing_details.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "account_buyer_notification_settings"}
        <script src="/js/main/account_buyer_notification_settings.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "account_seller_notification_settings"}
        <script src="/js/main/account_seller_notification_settings.js?v={$version}"></script>
    {/if}
    {if $parameters.cmd == "auctions_details_bill"}
        <script>
            var swipeboxItems = {$parameters.swipebox_items};
        </script>
    {/if}

    </div>
    {if !$skip_html_bottom}
        {include file="includes/main/html_bottom.tpl"}
    {/if}
{/strip}
