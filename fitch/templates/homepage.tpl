{strip}
{include file="includes/main/site_top.tpl"}

    <div class="row flex no-gutters bg-image" {if $parameters.settings->hero_image}style="background-image:url(/site_media/{$parameters.settings->hero_image}/);"{/if}>
        <div class="container full-width">
            <div class="col-24">
                <div class="module-hero-1">
                    <div class="content">
                        <div class="left">
                            <div class="holder">
                                <div class="text">
                                    <div class="logo">
                                        <svg version="1.1" id="Logos" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 220 230" style="enable-background:new 0 0 220 230;" xml:space="preserve">
                                            {literal}
                                            <style type="text/css">
                                                .st0{fill:#0650CB;}
                                                .st1{fill:none;}
                                                .st2{fill:#161616;}
                                            </style>
                                            {/literal}
                                            <g>
                                                <g>
                                                    <path class="st0" d="M160.9,113.9c17.1-7.6,24-21.3,24-35.6c0-37.1-27.1-53.5-63.5-53.5c-29.2,0-58.5,0-87.4,0v31.6h34.2h2.6h50.6
                                                        c22.1,0,29,14.2,29,22.6c0,10.5-7.1,19.8-29,19.8"></path>
                                                </g>
                                                <g>
                                                    <path class="st1" d="M143.5,135.7c-6.8-3.3-15.3-4.4-22.3-4.4H68v45.6h53.2c7,0,15.5-1.2,22.3-4.4c6.8-4.1,11.9-10.3,12.2-18.4
                                                        C155.4,146,150.3,139.8,143.5,135.7z"></path>
                                                    <path class="st2" d="M190.2,153.1c0-41.1-30.8-54.3-69-54.3c-16.9,0-33.8,0-50.6,0c-12.3,0-24.5,0-36.8,0v0v110.3v0
                                                        c12.3,0,24.6,0,36.8,0h50.6c38.2,0,69-13.2,69-54.3c0-0.3,0-0.6,0-0.9C190.2,153.7,190.2,153.4,190.2,153.1z M143.5,172.4
                                                        c-6.8,3.3-15.3,4.4-22.3,4.4H68v-45.6h53.2c7,0,15.5,1.2,22.3,4.4c6.8,4.1,11.9,10.3,12.2,18.4
                                                        C155.4,162.1,150.3,168.3,143.5,172.4z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <h1 class="title">BID TO DRIVE</h1>
                                    {if $parameters.settings->hero_title}<h4 class="sub-title">{$parameters.settings->hero_title|escape}</h4>{/if}
                                    {if $parameters.settings->hero_subtitle}<p>{$parameters.settings->hero_subtitle|escape}</p>{/if}
                                    {if $parameters.auctions}
                                        <div class="current">
                                            <em class="number">{$parameters.upcoming_auctions_count} </em>
                                            <div class="hold">
                                                <p>Active and or upcoming auctions.</p>
                                                <a href="/auctions/" class="btn-2 black" title="check it out">check it out</a>
                                            </div>
                                        </div>
                                    {/if}
                                </div>
                                <div class="stripes"></div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="top-pat"></div>
                            <div class="holder">
                                <div class="search">
                                    <form class="form" method="post" action="/auctions/">
                                        <div class="hold">
                                            <input type="text" class="text" id="keyword" name="keyword" placeholder="Search for auctions..." />
                                        </div>
                                        <span><em>OR</em></span>
                                        <a href="/register/" class="btn-2 red" title="Sign Up">Sign Up</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-t-24">
                <div class="module-1 bg-black" {if $parameters.settings->hero_image}style="background:url(/site_media/{$parameters.settings->buyer_cta_background_image}/) no-repeat 50% 50% / cover;"{/if}>
                    <div class="content">
                        {if $parameters.settings->buyer_cta_icon}
                            <div class="icon">
                                {*<img class="svg-icon-inject" src="/site_media/{$parameters.settings->buyer_cta_icon}" alt="{$parameters.settings->buyer_cta_title|escape}" title="{$parameters.settings->buyer_cta_title|escape}"/>*}
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve" class="svg-icon-inject replaced-svg">
<g>
    <g>
        <path d="M424.3,302.5V55.3c0-13.2-10.1-23.4-23.2-23.4H300.3c0-8.6-7-15.6-15.5-15.6H176.4c-8.5,0-15.5,7-15.5,15.6H60.2    C47.1,32,37,42.1,37,55.3v404.9c0,13.2,10.1,23.4,23.2,23.4h302.1c55.8,0,100.7-45.2,100.7-101.2C463,349.8,447.9,321,424.3,302.5    z M300.3,47.5H401c4.6,0,7.7,3.1,7.7,7.8v237.2c-4.9-2.6-10.1-4.8-15.5-6.5V78.7c0-8.6-7-15.6-15.5-15.6h-77.5V47.5z M176.4,32    h108.4v46.7H176.4V32z M176.4,94.3h108.4c8.5,0,15.5-7,15.5-15.6h77.5v203.7c-1.1-0.2-2.2-0.3-3.3-0.4c-0.1,0-0.2,0-0.2,0    c-0.9-0.1-1.7-0.2-2.6-0.3c-0.2,0-0.4,0-0.7-0.1c-0.7-0.1-1.5-0.1-2.2-0.2c-0.3,0-0.5,0-0.8-0.1c-0.7,0-1.4-0.1-2.1-0.1    c-0.3,0-0.5,0-0.8,0c-1,0-1.9,0-2.9,0c-55.8,0-100.7,45.2-100.7,101.2c0,1.1,0,2.1,0.1,3.2c0,0.2,0,0.3,0,0.5    c0.7,18.7,6.3,36.1,15.7,50.9H83.5V78.7h77.5C160.9,87.2,167.9,94.3,176.4,94.3z M60.2,468c-4.6,0-7.7-3.1-7.7-7.8V55.3    c0-4.7,3.1-7.8,7.7-7.8h100.7v15.6H83.5c-8.5,0-15.5,7-15.5,15.6v358.2c0,8.6,7,15.6,15.5,15.6h206.1c5.7,5.9,12,11.2,19,15.6    H60.2z M362.3,468c-24.6,0-46.7-10.4-62.2-27c-0.3-0.6-0.7-1.3-1.3-1.8c-13.1-14.6-20.7-33.3-21.6-52.9c0,0,0-0.1,0-0.1    c-0.1-1.3-0.1-2.6-0.1-3.8c0-47.5,38-85.7,85.2-85.7c1,0,2,0,3,0.1c0.1,0,0.2,0,0.3,0c0.2,0,0.4,0,0.7,0c0.7,0,1.3,0.1,2,0.1    c0.6,0,1.2,0.1,1.8,0.1c0.1,0,0.2,0,0.2,0c4.3,0.4,8.6,1.3,13,2.7c0.9,0.3,1.8,0.4,2.7,0.2c8.1,2.4,16,6,23.5,10.9    c23,15.3,38,41.5,38,71.4C447.5,429.9,409.6,468,362.3,468z M413.4,338c-3.9-3.1-8.5-2.3-10.8,1.6l-43.4,62.3L329,376.9    c-3.1-3.1-8.5-2.3-10.8,0.8c-3.1,3.1-2.3,8.6,0.8,10.9l37.2,30.4c0.8,0.8,3.1,1.6,4.6,1.6c0,0,0.8,0,0.8,0.8    c2.3,0,3.9-1.6,5.4-3.1l48-69.3C418.1,345,417.3,340.3,413.4,338z M126.8,179.1c-11.6,0-20.1,9.3-20.1,20.2v30.4    c0,11.7,8.5,20.2,20.1,20.2h11.8c3.5,13.4,15.6,23.4,30,23.4c14.4,0,26.5-10,30-23.4h63.9c3.5,13.4,15.6,23.4,30,23.4    c14.4,0,26.5-10,30-23.4h11.8c11.6,0,20.1-8.6,20.9-20.2v-30.4c0-11.7-9.3-20.2-20.1-20.2h-16.5l-30-42.1    c-4.6-7-12.4-10.9-20.9-10.9h-33.5c-1.1-0.5-2.3-0.8-3.7-0.8c-1.4,0-2.6,0.3-3.7,0.8h-33.5c-8.5,0-16.3,3.9-20.9,10.9l-30,42.1    H126.8z M168.7,257.8c-8.5,0-15.5-7-15.5-15.6c0-8.6,7-15.6,15.5-15.6c8.5,0,15.5,7,15.5,15.6    C184.2,250.8,177.2,257.8,168.7,257.8z M292.6,257.8c-8.5,0-15.5-7-15.5-15.6c0-8.6,7-15.6,15.5-15.6c8.5,0,15.5,7,15.5,15.6    C308.1,250.8,301.1,257.8,292.6,257.8z M238.4,141H267c3.9,0,7,1.6,8.5,3.9l24.2,34.3h-61.4V141z M184.2,144.9    c2.3-2.3,5.4-3.9,8.5-3.9h30.2v38.2h-62.2L184.2,144.9z M315.8,195.5c1.3,0,2.5-0.3,3.5-0.8h15.9c2.3,0,4.6,2.3,4.6,4.7v30.4    c0,2.3-2.3,4.7-4.6,4.7h-12.4c-3.9-13.2-13.9-23.4-28.7-23.4c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.7,0c-14.4,0-26.5,10-30,23.4h-63    c-3.9-13.2-15.5-23.4-30.2-23.4c-0.1,0-0.3,0-0.4,0c-0.1,0-0.2,0-0.4,0c-14.4,0-26.5,10-30,23.4h-11.8c-2.3,0-4.6-2.3-4.6-4.7    v-30.4c0-2.3,2.3-4.7,4.6-4.7H142c1,0.5,2.2,0.8,3.5,0.8H315.8z M230.6,312.3H114.5c-4.6,0-7.7,3.1-7.7,7.8c0,4.7,3.1,7.8,7.7,7.8    h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,315.4,235.3,312.3,230.6,312.3z M230.6,351.2H114.5c-4.6,0-7.7,3.1-7.7,7.8    c0,4.7,3.1,7.8,7.7,7.8h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,354.3,235.3,351.2,230.6,351.2z M230.6,390.2H114.5    c-4.6,0-7.7,3.1-7.7,7.8c0,4.7,3.1,7.8,7.7,7.8h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,393.3,235.3,390.2,230.6,390.2z"></path>
    </g>
</g>
</svg>
                            </div>
                        {/if}
                        {if $parameters.settings->buyer_cta_title}<h3>{$parameters.settings->buyer_cta_title|escape}</h3>{/if}
                        {if $parameters.settings->buyer_cta_subtitle}<p>{$parameters.settings->buyer_cta_subtitle}</p>{/if}
                        {if $parameters.settings->buyer_cta_button_text}
                            <a href="/register/buyer/" id="buyer_cta" class="btn-1" title="{$parameters.settings->buyer_cta_button_text|escape}">{$parameters.settings->buyer_cta_button_text|escape}</a>
                        {/if}
                        <div class="icon stripes">
                            <img class="svg-icon-inject" src="/images/icons/icon-mark.svg" alt="{$parameters.settings->buyer_cta_title|escape}" title="{$parameters.settings->buyer_cta_title|escape}"/>
                        </div>
                    </div>
                </div>
                <div class="module-1 bg-blue" {if $parameters.settings->seller_cta_background_image}style="background:url(/site_media/{$parameters.settings->seller_cta_background_image}/) no-repeat 50% 50% / cover;"{/if}>
                    <div class="content">
                        {if $parameters.settings->seller_cta_icon}
                            <div class="icon">
                                {*<img class="svg-icon-inject" src="/site_media/{$parameters.settings->seller_cta_icon}" alt="{$parameters.settings->seller_cta_title|escape}" title="{$parameters.settings->seller_cta_title|escape}" />*}
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 500 500" style="enable-background:new 0 0 500 500;" xml:space="preserve" class="svg-icon-inject replaced-svg">
<g>
    <g>
        <path d="M424.3,302.5V55.3c0-13.2-10.1-23.4-23.2-23.4H300.3c0-8.6-7-15.6-15.5-15.6H176.4c-8.5,0-15.5,7-15.5,15.6H60.2    C47.1,32,37,42.1,37,55.3v404.9c0,13.2,10.1,23.4,23.2,23.4h302.1c55.8,0,100.7-45.2,100.7-101.2C463,349.8,447.9,321,424.3,302.5    z M300.3,47.5H401c4.6,0,7.7,3.1,7.7,7.8v237.2c-4.9-2.6-10.1-4.8-15.5-6.5V78.7c0-8.6-7-15.6-15.5-15.6h-77.5V47.5z M176.4,32    h108.4v46.7H176.4V32z M176.4,94.3h108.4c8.5,0,15.5-7,15.5-15.6h77.5v203.7c-1.1-0.2-2.2-0.3-3.3-0.4c-0.1,0-0.2,0-0.2,0    c-0.9-0.1-1.7-0.2-2.6-0.3c-0.2,0-0.4,0-0.7-0.1c-0.7-0.1-1.5-0.1-2.2-0.2c-0.3,0-0.5,0-0.8-0.1c-0.7,0-1.4-0.1-2.1-0.1    c-0.3,0-0.5,0-0.8,0c-1,0-1.9,0-2.9,0c-55.8,0-100.7,45.2-100.7,101.2c0,1.1,0,2.1,0.1,3.2c0,0.2,0,0.3,0,0.5    c0.7,18.7,6.3,36.1,15.7,50.9H83.5V78.7h77.5C160.9,87.2,167.9,94.3,176.4,94.3z M60.2,468c-4.6,0-7.7-3.1-7.7-7.8V55.3    c0-4.7,3.1-7.8,7.7-7.8h100.7v15.6H83.5c-8.5,0-15.5,7-15.5,15.6v358.2c0,8.6,7,15.6,15.5,15.6h206.1c5.7,5.9,12,11.2,19,15.6    H60.2z M362.3,468c-24.6,0-46.7-10.4-62.2-27c-0.3-0.6-0.7-1.3-1.3-1.8c-13.1-14.6-20.7-33.3-21.6-52.9c0,0,0-0.1,0-0.1    c-0.1-1.3-0.1-2.6-0.1-3.8c0-47.5,38-85.7,85.2-85.7c1,0,2,0,3,0.1c0.1,0,0.2,0,0.3,0c0.2,0,0.4,0,0.7,0c0.7,0,1.3,0.1,2,0.1    c0.6,0,1.2,0.1,1.8,0.1c0.1,0,0.2,0,0.2,0c4.3,0.4,8.6,1.3,13,2.7c0.9,0.3,1.8,0.4,2.7,0.2c8.1,2.4,16,6,23.5,10.9    c23,15.3,38,41.5,38,71.4C447.5,429.9,409.6,468,362.3,468z M413.4,338c-3.9-3.1-8.5-2.3-10.8,1.6l-43.4,62.3L329,376.9    c-3.1-3.1-8.5-2.3-10.8,0.8c-3.1,3.1-2.3,8.6,0.8,10.9l37.2,30.4c0.8,0.8,3.1,1.6,4.6,1.6c0,0,0.8,0,0.8,0.8    c2.3,0,3.9-1.6,5.4-3.1l48-69.3C418.1,345,417.3,340.3,413.4,338z M126.8,179.1c-11.6,0-20.1,9.3-20.1,20.2v30.4    c0,11.7,8.5,20.2,20.1,20.2h11.8c3.5,13.4,15.6,23.4,30,23.4c14.4,0,26.5-10,30-23.4h63.9c3.5,13.4,15.6,23.4,30,23.4    c14.4,0,26.5-10,30-23.4h11.8c11.6,0,20.1-8.6,20.9-20.2v-30.4c0-11.7-9.3-20.2-20.1-20.2h-16.5l-30-42.1    c-4.6-7-12.4-10.9-20.9-10.9h-33.5c-1.1-0.5-2.3-0.8-3.7-0.8c-1.4,0-2.6,0.3-3.7,0.8h-33.5c-8.5,0-16.3,3.9-20.9,10.9l-30,42.1    H126.8z M168.7,257.8c-8.5,0-15.5-7-15.5-15.6c0-8.6,7-15.6,15.5-15.6c8.5,0,15.5,7,15.5,15.6    C184.2,250.8,177.2,257.8,168.7,257.8z M292.6,257.8c-8.5,0-15.5-7-15.5-15.6c0-8.6,7-15.6,15.5-15.6c8.5,0,15.5,7,15.5,15.6    C308.1,250.8,301.1,257.8,292.6,257.8z M238.4,141H267c3.9,0,7,1.6,8.5,3.9l24.2,34.3h-61.4V141z M184.2,144.9    c2.3-2.3,5.4-3.9,8.5-3.9h30.2v38.2h-62.2L184.2,144.9z M315.8,195.5c1.3,0,2.5-0.3,3.5-0.8h15.9c2.3,0,4.6,2.3,4.6,4.7v30.4    c0,2.3-2.3,4.7-4.6,4.7h-12.4c-3.9-13.2-13.9-23.4-28.7-23.4c-0.3,0-0.6,0-0.8,0c-0.2,0-0.5,0-0.7,0c-14.4,0-26.5,10-30,23.4h-63    c-3.9-13.2-15.5-23.4-30.2-23.4c-0.1,0-0.3,0-0.4,0c-0.1,0-0.2,0-0.4,0c-14.4,0-26.5,10-30,23.4h-11.8c-2.3,0-4.6-2.3-4.6-4.7    v-30.4c0-2.3,2.3-4.7,4.6-4.7H142c1,0.5,2.2,0.8,3.5,0.8H315.8z M230.6,312.3H114.5c-4.6,0-7.7,3.1-7.7,7.8c0,4.7,3.1,7.8,7.7,7.8    h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,315.4,235.3,312.3,230.6,312.3z M230.6,351.2H114.5c-4.6,0-7.7,3.1-7.7,7.8    c0,4.7,3.1,7.8,7.7,7.8h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,354.3,235.3,351.2,230.6,351.2z M230.6,390.2H114.5    c-4.6,0-7.7,3.1-7.7,7.8c0,4.7,3.1,7.8,7.7,7.8h116.2c4.6,0,7.7-3.1,7.7-7.8C238.4,393.3,235.3,390.2,230.6,390.2z"></path>
    </g>
</g>
</svg>
                            </div>
                        {/if}
                        {if $parameters.settings->seller_cta_title}<h3>{$parameters.settings->seller_cta_title|escape}</h3>{/if}
                        {if $parameters.settings->seller_cta_subtitle}<p>{$parameters.settings->seller_cta_subtitle|escape}</p>{/if}
                        {if $parameters.settings->seller_cta_button_text}
                            <a href="/register/" id="seller_cta" class="btn-1" title="{$parameters.settings->seller_cta_button_text}">{$parameters.settings->seller_cta_button_text}</a>
                        {/if}
                        <div class="icon stripes">
                            <img class="svg-icon-inject" src="/images/icons/icon-mark.svg" alt="{$parameters.settings->seller_cta_title|escape}" title="{$parameters.settings->seller_cta_title|escape}" />
                        </div>
                    </div>
                </div>
                <div class="module-slides">
                    <div class="slider-for">
                        {foreach from=$parameters.settings->repeating_fieldgroups item=item}
                            <div class="slide">
                                <div class="img" style="background-image: url('/site_media/{$item->background_image}');"></div>
                            </div>
                        {/foreach}
                    </div>
                    <div class="content">
                        <h3 class="title">How It Works</h3>
                        <div class="slides slider-nav" id="slide-how-it-work">
                            {foreach from=$parameters.settings->repeating_fieldgroups item=item}
                                <div class="slide">
                                    <div class="icon">
                                        <img class="svg-icon-inject" style="height:auto !important" onerror="this.onerror=null; this.src='/images/how-it-works-icon.png'" src="/site_media/{$item->icon}" alt="{$item->title|escape}" title="{$item->title|escape}" />
                                    </div>
                                    {if $item->title}<h2 class="name">{$item->title|escape}</h2>{/if}
                                    {if $item->subtitle}<p>{$item->subtitle}</p>{/if}
                                </div>
                            {/foreach}
                        </div>
                        <div class="stripes-2"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-t-24">
                <div class="module-spacer-1">
                    <div class="comb-pattern"></div>
                </div>
                <div class="module-current">
                    <div class="content">
                        <h3 class="title">{$item->year} {$item->make|escape} {$item->model|escape}</h3>
                        {if $parameters.settings->current_auctions_subtitle}<p>{$parameters.settings->current_auctions_subtitle|escape}</p>{/if}
                        {if $parameters.auctions}
                            <div class="list" id="auctions-list">
                                {foreach name=auctions from=$parameters.auctions item=item}
                                    <div class="item">
                                        <div class="img-frame">
                                            {if $item->image}
                                                <img onerror="this.onerror=null; this.src='/images/default-car-image.png'" src="/site_media/{$item->image}/m/" alt="Auction Car Photo" title="Auction Car Photo"/>
                                            {else}
                                                <div class="no-auction-photo-homepage">
                                                    <img class="svg-icon-inject" src="/images/default-car-image.png" alt="Auction Car Photo" title="Auction Car Photo" />
                                                </div>
                                            {/if}
                                        </div>
                                        <div class="text">
                                            <h4 class="name" style="color: #0650cb;">

                                                    {if !isset($smarty.session.user)}
                                                        <a href="/login/?redirect=/auctions/{$item->id}/" title="{$item->make|escape} {$item->model|escape}">{$item->make|escape} {$item->model|escape} </a>
                                                    {else}
                                                        <a href="/auctions/{$item->id}" title="{$item->make|escape} {$item->model|escape}">{$item->make|escape} {$item->model|escape} </a>
                                                    {/if}



                                            </h4>
                                            {if $item->current_bid_price}
                                                <span class="bid">Current Bid: ${$item->current_bid_price|money_format}</span>
                                            {/if}
                                            <em class="timer" data-started="" data-left="{$item->time_end}"></em>
                                            {if !isset($smarty.session.user)}
                                                <a href="/login/?redirect=/auctions/{$item->id}/" class="btn-2 blue" title="details">Login to view</a>
                                            {else}
                                                <a href="/auctions/{$item->id}/" class="btn-2 blue" title="details">details</a>
                                            {/if}
                                        </div>
                                    </div>
                                {/foreach}
                            </div>
                            <a href="/auctions/" class="btn-2 black" title="view all">view all</a>
                        {/if}
                    </div>
                </div>
            </div>
        </div>
    </div>
{include file="includes/main/site_bottom.tpl"}
{/strip}
