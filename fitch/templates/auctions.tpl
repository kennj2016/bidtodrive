{strip}
{include file="includes/main/site_top.tpl"}

<div class="sec-holder">
    <div class="sec-1">
        <div class="baron">
            <div class="baron__clipper">
                <div class="baron__bar"></div>
                {include file="auctions_filters.tpl"}
            </div>
        </div>
    </div>
    <div class="sec-2">
        <div class="baron">
            <div class="baron__clipper">
                <div class="baron__bar"></div>
                <div class="baron__scroller search-list-container">
                    <div class="content-box">
                        <div class="tablet-left-panel-opener-box">
                            <div class="holder">
                                <div class="input-search">
                                    <input type="search" name="mobile_keyword" value="{$smarty.request.keyword}" placeholder="Search by keyword...">
                                </div>
                                <div class="filter-opener left-panel-opener-button">
                                    <div class="icon">
                                        <img class="svg-icon-inject" src="/images/icons/icons-30.svg" alt="Filter" title="Filter"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sep-tablet"></div>
                        <div class="top-controll-panel">
                            <div class="left">
                                <div class="result-name">
                                    {if $smarty.request.keyword}{$smarty.request.keyword}{else}All{/if} Auctions
                                </div>
                                <div class="result-detail">
                                    Search Results - <span>{$parameters.count_records} Listing{if $parameters.count_records > 1}s{/if}</span>
                                </div>
                            </div>
                            <div class="right">
                                <div class="btn gridview">
                                    <img class="svg-icon-inject" src="/images/icons/icon-grid-view.svg" alt="Grid View" title="Grid View"/>
                                </div>
                                <div class="btn listview active">
                                    <img class="svg-icon-inject" src="/images/icons/btn-grid.svg" alt="Listview View" title="Listview View"/>
                                </div>
                            </div>
                        </div>
                        <div class="module-search-listing">
                            <div class="content">
                                <div class="listing-1 balancer listview">
                                    {include file="auctions_list.tpl"}
                                </div>
                            </div>
                        </div>
                        {include file="includes/main/popup_auction_bid_buy.tpl"}
                        <div class="one-col-structure">
                            {include file="includes/main/site_bottom.tpl" skip_html_bottom=true}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>
</div>
</body>
</html>
{/strip}
