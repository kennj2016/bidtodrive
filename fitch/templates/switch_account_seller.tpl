{strip}
    {include file="includes/main/site_top.tpl"}
    <div class="sec-holder switch-account-form">
        {include file="includes/main/account_buyer_left.tpl"}
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
                                            <img class="svg-icon-inject" src="/images/icons/icon-myaccount.svg"
                                                 alt="Upgrade to a Seller account" title="Upgrade to a Seller account"/>
                                        </div>
                                        <span>Upgrade to a Seller account</span>
                                    </h4>
                                    <div class="subpage">
                                        <div class="field-block-1">
                                            <div class="holder" id="contact-form-wrap">
                                                <form action="" method="POST" class="form" id="switch_account_sellerx"
                                                      enctype="multipart/form-data">
                                                    <div class="field-block-1">
                                                        <div class="block-1"><p>Request to be Seller</p></div>
                                                        {if $parameters.message != ''}
                                                        <div class="alert alert-success" style="background:rgba(0,255,0,0.3);width:100%;border:1px soild #ccc;padding : 10px;">
                                                          <strong>Success!</strong> {$parameters.message}.
                                                        </div>
                                                        {/if}
                                                        <div class="block-2 block-2-dealers_license_issued_to">
                                                            <label>Dealers license issued to</label>
                                                            <input type="date"
                                                                   class="text dealers_license_issued_to"
                                                                   placeholder="dealers license issued to"
                                                                   name="dealers_license_issued_to" value="">
                                                        </div>
                                                        <div class="block-2 block-2-dealers_license_number">
                                                            <label>Dealers license number <span style="color: red">*</span></label>
                                                            <input required type="text"
                                                                   class="text"
                                                                   placeholder="dealers license number"
                                                                   name="dealers_license_number" value="">
                                                        </div>
                                                        <div class="block-2 block-2-dealers_license_state">
                                                            <label>Dealers license state</label>
                                                            <select name="dealers_license_state">
                                                                <option value="">none (default)</option>
                                                                <option value="AL" {if $parameters.user->dealers_license_state == 'AL'}selected{/if}>Alabama</option>
                                                                <option value="AK" {if $parameters.user->dealers_license_state == 'AK'}selected{/if}>Alaska</option>
                                                                <option value="AZ" {if $parameters.user->dealers_license_state == 'AZ'}selected{/if}>Arizona</option>
                                                                <option value="AR" {if $parameters.user->dealers_license_state == 'AR'}selected{/if}>Arkansas</option>
                                                                <option value="CA" {if $parameters.user->dealers_license_state == 'CA'}selected{/if}>California</option>
                                                                <option value="CO" {if $parameters.user->dealers_license_state == 'CO'}selected{/if}>Colorado</option>
                                                                <option value="CT" {if $parameters.user->dealers_license_state == 'CT'}selected{/if}>Connecticut</option>
                                                                <option value="DE" {if $parameters.user->dealers_license_state == 'DE'}selected{/if}>Delaware</option>
                                                                <option value="DC" {if $parameters.user->dealers_license_state == 'DC'}selected{/if}>District of Columbia</option>
                                                                <option value="FL" {if $parameters.user->dealers_license_state == 'FL'}selected{/if}>Florida</option>
                                                                <option value="GA" {if $parameters.user->dealers_license_state == 'GA'}selected{/if}>Georgia</option>
                                                                <option value="HI" {if $parameters.user->dealers_license_state == 'HI'}selected{/if}>Hawaii</option>
                                                                <option value="ID" {if $parameters.user->dealers_license_state == 'ID'}selected{/if}>Idaho</option>
                                                                <option value="IL" {if $parameters.user->dealers_license_state == 'IL'}selected{/if}>Illinois</option>
                                                                <option value="IN" {if $parameters.user->dealers_license_state == 'IN'}selected{/if}>Indiana</option>
                                                                <option value="IA" {if $parameters.user->dealers_license_state == 'IA'}selected{/if}>Iowa</option>
                                                                <option value="KS" {if $parameters.user->dealers_license_state == 'KS'}selected{/if}>Kansas</option>
                                                                <option value="KY" {if $parameters.user->dealers_license_state == 'KY'}selected{/if}>Kentucky</option>
                                                                <option value="LA" {if $parameters.user->dealers_license_state == 'LA'}selected{/if}>Louisiana</option>
                                                                <option value="ME" {if $parameters.user->dealers_license_state == 'ME'}selected{/if}>Maine</option>
                                                                <option value="MD" {if $parameters.user->dealers_license_state == 'MD'}selected{/if}>Maryland</option>
                                                                <option value="MA" {if $parameters.user->dealers_license_state == 'MA'}selected{/if}>Massachusetts</option>
                                                                <option value="MI" {if $parameters.user->dealers_license_state == 'MI'}selected{/if}>Michigan</option>
                                                                <option value="MN" {if $parameters.user->dealers_license_state == 'MN'}selected{/if}>Minnesota</option>
                                                                <option value="MS" {if $parameters.user->dealers_license_state == 'MS'}selected{/if}>Mississippi</option>
                                                                <option value="MO" {if $parameters.user->dealers_license_state == 'MO'}selected{/if}>Missouri</option>
                                                                <option value="MT" {if $parameters.user->dealers_license_state == 'MT'}selected{/if}>Montana</option>
                                                                <option value="NE" {if $parameters.user->dealers_license_state == 'NE'}selected{/if}>Nebraska</option>
                                                                <option value="NV" {if $parameters.user->dealers_license_state == 'NV'}selected{/if}>Nevada</option>
                                                                <option value="NH" {if $parameters.user->dealers_license_state == 'NH'}selected{/if}>New Hampshire</option>
                                                                <option value="NJ" {if $parameters.user->dealers_license_state == 'NJ'}selected{/if}>New Jersey</option>
                                                                <option value="NM" {if $parameters.user->dealers_license_state == 'NM'}selected{/if}>New Mexico</option>
                                                                <option value="NY" {if $parameters.user->dealers_license_state == 'NY'}selected{/if}>New York</option>
                                                                <option value="NC" {if $parameters.user->dealers_license_state == 'NC'}selected{/if}>North Carolina</option>
                                                                <option value="ND" {if $parameters.user->dealers_license_state == 'ND'}selected{/if}>North Dakota</option>
                                                                <option value="OH" {if $parameters.user->dealers_license_state == 'OH'}selected{/if}>Ohio</option>
                                                                <option value="OK" {if $parameters.user->dealers_license_state == 'OK'}selected{/if}>Oklahoma</option>
                                                                <option value="OR" {if $parameters.user->dealers_license_state == 'OR'}selected{/if}>Oregon</option>
                                                                <option value="PA" {if $parameters.user->dealers_license_state == 'PA'}selected{/if}>Pennsylvania</option>
                                                                <option value="RI" {if $parameters.user->dealers_license_state == 'RI'}selected{/if}>Rhode Island</option>
                                                                <option value="SC" {if $parameters.user->dealers_license_state == 'SC'}selected{/if}>South Carolina</option>
                                                                <option value="SD" {if $parameters.user->dealers_license_state == 'SD'}selected{/if}>South Dakota</option>
                                                                <option value="TN" {if $parameters.user->dealers_license_state == 'TN'}selected{/if}>Tennessee</option>
                                                                <option value="TX" {if $parameters.user->dealers_license_state == 'TX'}selected{/if}>Texas</option>
                                                                <option value="UT" {if $parameters.user->dealers_license_state == 'UT'}selected{/if}>Utah</option>
                                                                <option value="VT" {if $parameters.user->dealers_license_state == 'VT'}selected{/if}>Vermont</option>
                                                                <option value="VA" {if $parameters.user->dealers_license_state == 'VA'}selected{/if}>Virginia</option>
                                                                <option value="WA" {if $parameters.user->dealers_license_state == 'WA'}selected{/if}>Washington</option>
                                                                <option value="WV" {if $parameters.user->dealers_license_state == 'WV'}selected{/if}>West Virginia</option>
                                                                <option value="WI" {if $parameters.user->dealers_license_state == 'WI'}selected{/if}>Wisconsin</option>
                                                                <option value="WY" {if $parameters.user->dealers_license_state == 'WY'}selected{/if}>Wyoming</option>
                                                            </select>
                                                        </div>
                                                        <div class="block-2 block-2-dealers_license_issue_date">
                                                            <label>Dealers license issue date</label>
                                                            <input type="date"
                                                                   class="text"
                                                                   placeholder="dealers license issue date"
                                                                   name="dealers_license_issue_date" value="">
                                                        </div>
                                                        <div class="block-2 block-2-dealers_license_expiration_date">
                                                            <label>dealers license expiration date</label>
                                                            <input type="date"
                                                                   class="text"
                                                                   placeholder="dealers license expiration date"
                                                                   name="dealers_license_expiration_date" value="">
                                                        </div>
                                                        {*<div class="block-2 block-2-dealers_license_number">
                                                            <label>dealers license photo</label>
                                                            <input type="file"
                                                                   class="file"
                                                                   placeholder="dealers license number"
                                                                   name="dealers_license_photo" value="{$parameters.user->dealers_license_photo}">
                                                        </div>*}
                                                        <div class="block-2 block-2-dealers_license_number">
                                                            <label>Message</label>
                                                            <textarea placeholder="Message" name="upgrade_seller_note"></textarea>
                                                        </div>
                                                        <div class="block-1 flex-v-right"><input type="submit"
                                                                                                 class="submit btn-2 black"
                                                                                                 value="Submit">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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
            <iao-alert class="" id="iao1528365550338" close-on-click="false" fade-on-hover="false" mode="dark"
                       type="error" style="white-space:pre-wrap;word-wrap:break-word;" corners="">
                <div class="io-text">
                    <div class="holder">
                        <div class="label">
                            <span class="icon">
                                {literal}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta
                                                    xmlns:x="adobe:ns:meta/"
                                                    x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf
                                                        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description
                                                            rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta>
                                            <!--?xpacket end="w"?--></metadata><defs><style>.cls-1 {
                                                    fill-rule: evenodd;
                                                }</style></defs><path class="cls-1"
                                                                      d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z"
                                                                      transform="translate(-1404 -748)"></path></svg>
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
            <iao-alert class="" id="iao1528365550339" close-on-click="false" fade-on-hover="false" mode="dark"
                       type="success" style="white-space:pre-wrap;word-wrap:break-word;" corners="">
                <div class="io-text">
                    <div class="holder">
                        <div class="label">
                            <span class="icon">
                                {literal}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 30 25"><metadata><x:xmpmeta
                                                    xmlns:x="adobe:ns:meta/"
                                                    x:xmptk="Adobe XMP Core 5.6-c140 79.160451, 2017/05/06-01:08:21"><rdf:rdf
                                                        xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><rdf:description
                                                            rdf:about=""></rdf:description></rdf:rdf></x:xmpmeta>
                                            <!--?xpacket end="w"?--></metadata><defs><style>.cls-1 {
                                                    fill-rule: evenodd;
                                                }</style></defs><path class="cls-1"
                                                                      d="M1433.6,769.04l-12.3-19.777a2.744,2.744,0,0,0-4.62,0l-12.3,19.777a2.542,2.542,0,0,0-.04,2.633,2.726,2.726,0,0,0,2.35,1.327h24.6a2.726,2.726,0,0,0,2.35-1.327A2.542,2.542,0,0,0,1433.6,769.04Zm-1.66,1.7a0.749,0.749,0,0,1-.65.365h-24.6a0.749,0.749,0,0,1-.65-0.365,0.7,0.7,0,0,1,.01-0.725l12.3-19.777a0.764,0.764,0,0,1,1.28,0l12.3,19.777A0.7,0.7,0,0,1,1431.94,770.742ZM1419,755.787a1.15,1.15,0,0,0-1.32,1.072c0,2.089.25,5.092,0.25,7.182a0.887,0.887,0,0,0,1.07.773,0.948,0.948,0,0,0,1.05-.773c0-2.09.25-5.093,0.25-7.182A1.148,1.148,0,0,0,1419,755.787Zm0.02,10.238a1.353,1.353,0,1,0,0,2.705A1.353,1.353,0,1,0,1419.02,766.025Z"
                                                                      transform="translate(-1404 -748)"></path></svg>
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

<script type="text/javascript">
    {literal}
    $(function(){
        $("#switch_account_sellerx").validate({
            rules: {
                dealers_license_number: "required",

            },
            // messages: {
            //     dealers_license_number: "Vui lòng nhập họ",
            // }
        });
    });

    {/literal}
</script>
