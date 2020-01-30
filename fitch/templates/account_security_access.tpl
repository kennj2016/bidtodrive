{strip}
    {include file="includes/main/site_top.tpl"}
    <div class="sec-holder">
        {if $parameters.user->user_type == "Seller"}
            {include file="includes/main/account_left.tpl"}
        {else}
            {include file="includes/main/account_buyer_left.tpl"}
        {/if}
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
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg" alt="Security & Access" title="Security & Access" />
                                        </div>
                                        <span>Security & Access</span>
                                    </h4>
                                    <div class="subpage">
                                        <form action="" method="post" class="form" autocomplete="off">
                                            <input style="opacity: 0;position: absolute;" type="text" name="fakeusernameremembered">
                                            <input style="opacity: 0;position: absolute;" type="password" name="fakepasswordremembered">
                                            <div class="field-block-1">
                                                <div class="bigitem-3 label-holder">
                                                    <label class="small">Current Password</label>
                                                    <input type="password" name="old_password" placeholder="" class="text" />
                                                </div>
                                                <div class="bigitem-3 label-holder">
                                                    <label class="small">New Password</label>
                                                    <input type="password" name="new_password" placeholder="" class="text" />
                                                </div>
                                                <div class="bigitem-3 label-holder">
                                                    <label class="small">Confirm New Password</label>
                                                    <input type="password" name="confirm_password" placeholder="" class="text"  />
                                                </div>
                                                <hr class="hr"/>
                                                <div class="block-1 flex-h-left">
                                                    <input type="submit" class="submit-right btn-2 blue" value="Update Password"/>
                                                </div>
                                            </div>
                                        </form>
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