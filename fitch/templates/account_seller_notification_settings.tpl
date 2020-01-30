{strip}
    {include file="includes/main/site_top.tpl"}
    <div class="sec-holder">

        {include file="includes/main/account_left.tpl"}

        <div class="sec-2">
            <div class="baron">
                <div class="baron__clipper">
                    <div class="baron__bar"></div>
                    <div class="baron__scroller">
                        <div class="content-box">
                            <div class="account-right-box">
                                <div class="page active">
                                    <h4 class="head-title">
                                        <div class="ico">
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="Notification Settings" title="Notification Settings" />
                                        </div>
                                        <span>Notification Settings</span>
                                    </h4>
                                    <div class="subpage">
                                        <div class="field-block-1">
                                            <form action="#" id="notification-form" class="form" autocomplete="off">
                                                <div class="flexbox full-width mob-block">
                                                    <div class="bigitem-flex label-holder">
                                                        <div class="setting">Notify me when my listing is about to expire</div>
                                                    </div>
                                                    <div class="smallitem-toggle flex-v-center flex-h-center">
                                                        <div class="toggle_radio no-borders">
                                                            <input type="radio" {if $parameters.user->notification_type_9 == 1}checked {/if} class="toggle_option first" id="notification_type_91" name="notification_type_9" value="1">
                                                            <label for="notification_type_91"><span>On</span></label>
                                                            <input type="radio" {if $parameters.user->notification_type_9 == 0}checked {/if} class="toggle_option second" id="notification_type_90" name="notification_type_9" value="0">
                                                            <label for="notification_type_90"><span>Off</span></label>
                                                            <div class="toggle_option_slider"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                
                                                <div class="flexbox full-width mob-block">
                                                    <div class="bigitem-flex label-holder">
                                                        <div class="setting">Notify me if my reserve price is not met at an auction's conclusion</div>
                                                    </div>
                                                    <div class="smallitem-toggle flex-v-center flex-h-center">
                                                        <div class="toggle_radio no-borders">
                                                            <input type="radio" {if $parameters.user->notification_type_13 == 1}checked{/if} class="toggle_option first" id="notification_type_131" name="notification_type_13" value="1">
                                                            <label for="notification_type_131"><span>On</span></label>
                                                            <input type="radio" {if $parameters.user->notification_type_13 == 0}checked{/if} class="toggle_option second" id="notification_type_130" name="notification_type_13" value="0">
                                                            <label for="notification_type_130"><span>Off</span></label>
                                                            <div class="toggle_option_slider"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <div class="flexbox full-width mob-block">
                                                    <div class="bigitem-flex label-holder">
                                                        <div class="setting">Notify me when buyers make a bid on my auctions</div>
                                                    </div>
                                                    <div class="smallitem-toggle flex-v-center flex-h-center">
                                                        <div class="toggle_radio no-borders">
                                                            <input type="radio" {if $parameters.user->notification_type_12 == 1}checked{/if} class="toggle_option first" id="notification_type_121" name="notification_type_12" value="1">
                                                            <label for="notification_type_121"><span>On</span></label>
                                                            <input type="radio" {if $parameters.user->notification_type_12 == 0}checked{/if} class="toggle_option second" id="notification_type_120" name="notification_type_12" value="0">
                                                            <label for="notification_type_120"><span>Off</span></label>
                                                            <div class="toggle_option_slider"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <div class="flexbox full-width mob-block">
                                                    <div class="bigitem-flex label-holder">
                                                        <div class="setting">Notify me when an auction is successfully completed</div>
                                                    </div>
                                                    <div class="smallitem-toggle flex-v-center flex-h-center">
                                                        <div class="toggle_radio no-borders">
                                                            <input type="radio" {if $parameters.user->notification_type_3 == 1}checked{/if} class="toggle_option first" id="notification_type_31" name="notification_type_3" value="1">
                                                            <label for="notification_type_31"><span>On</span></label>
                                                            <input type="radio" {if $parameters.user->notification_type_3 == 0}checked{/if} class="toggle_option second" id="notification_type_30" name="notification_type_3" value="0">
                                                            <label for="notification_type_30"><span>Off</span></label>
                                                            <div class="toggle_option_slider"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                
                                                <div class="block-1">
                                                    <label>Send All Notifications By</label>
                                                    <div class="single-select-box">
                                                        <div class="box">
                                                            <input type="radio" id="first_option" {if $parameters.user->notification_channel == "sms"}checked{/if} name="notification_channel" value="sms" />
                                                            <label for="first_option"><span>sms</span></label>
                                                        </div>
                                                        <div class="box">
                                                            <input type="radio" id="second_option" {if $parameters.user->notification_channel == "email"}checked{/if} name="notification_channel" value="email" />
                                                            <label for="second_option"><span>email</span></label>
                                                        </div>
                                                        <div class="box">
                                                            <input type="radio" id="third_option_1" {if $parameters.user->notification_channel == "both"}checked{/if} name="notification_channel" value="both" />
                                                            <label for="third_option_1"><span>both</span></label>
                                                        </div>
                                                        <div class="box">
                                                            <input type="radio" id="forth_option" {if $parameters.user->notification_channel == "none"}checked {/if} name="notification_channel" value="none" />
                                                            <label for="forth_option"><span>none</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="hr"/>
                                                <div class="block-1 flex-h-left">
                                                    <input type="button" style="margin: 0;" class="submit-right btn-2 blue" id="update_notification_settings" value="Update Notification Settings"/>
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
                            <div class="one-col-structure">
                                {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </main>
    </div>
    {if $parameters.has_error}
        <iao-alert-box position="bottom-right" style="z-index:998">
            <iao-alert-start></iao-alert-start>
            <iao-alert class="" id="iao1528365550338" close-on-click="false" fade-on-hover="false" mode="dark" type="error" style="white-space:pre-wrap;word-wrap:break-word;" corners="">
                <div class="io-text">
                    <div class="holder">
                        <div class="label">
                            <span class="icon">
                                {literal}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta><!--?xpacket end="w"?--></metadata><defs><style>.cls-1 {fill-rule: evenodd;}</style></defs><path class="cls-1" d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z" transform="translate(-1404 -748)"></path></svg>
                                {/literal}
                            </span>
                            <span class="alert-text">
                                <span>warning</span>
                            </span>
                        </div>
                        <div class="msg">
                            <p><span>{$parameters.status}</span></p>
                        </div>
                    </div>
                </div>
                <div class="io-close">
                    <iao-alert-close></iao-alert-close>
                </div>
            </iao-alert>
        </iao-alert-box>
    {/if}
    {if !$parameters.has_error && $parameters.status != ""}
        <iao-alert-box position="bottom-right" style="z-index:998">
            <iao-alert-start></iao-alert-start>
            <iao-alert class="" id="iao1528365550339" close-on-click="false" fade-on-hover="false" mode="dark" type="success" style="white-space:pre-wrap;word-wrap:break-word;" corners="">
                <div class="io-text">
                    <div class="holder">
                        <div class="label">
                            <span class="icon">
                                {literal}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta xmlns:x="adobe:ns:meta/" x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta><!--?xpacket end="w"?--></metadata><defs><style>.cls-1 {fill-rule: evenodd;}</style></defs><path class="cls-1" d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z" transform="translate(-1404 -748)"></path></svg>
                                {/literal}
                            </span>
                            <span class="alert-text">
                                <span>success</span>
                            </span>
                        </div>
                        <div class="msg">
                            <p><span>{$parameters.status}</span></p>
                        </div>
                    </div>
                </div>
                <div class="io-close">
                    <iao-alert-close></iao-alert-close>
                </div>
            </iao-alert>
        </iao-alert-box>
    {/if}
    </body>
    </html>
{/strip}