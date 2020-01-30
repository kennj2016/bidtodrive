{strip}
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBAhlahwSmFj9_IMX1Bg5rURA5tYC3Q5kQ"></script>
    <script>
        var models = {if $parameters.filters.model_json}{$parameters.filters.model_json}{else}null{/if};
    </script>
    <div class="baron__scroller">
        <div class="content-box">
            <div class="search-float-panel">
                <div class="cpt-filter search-fixed">
                    <div class="container">
                        <form class="form" id="auction_search_form">
                            <div class="block-2 blog-search">
                                <input type="search" name="keyword" value="{$smarty.request.keyword}" placeholder="Search by keyword...">
                                <input id="where-val" type="hidden" name="where_val" value="">
                            </div>
                            <div class="filter-box-opener">
                                <div class="icon">
                                    <img class="svg-icon-inject" src="/images/icons/icons-30.svg" alt="filter" title="filter"/>
                                </div>
                            </div>
                            <div class="block-2 filter-box">
                                <div class="closer">
                                    <div>
                                        <span class="name">Filter Search</span>
                                        <div class="icon close left-panel-close-button">
                                            <img class="svg-icon-inject" src="/images/icons/icon-close.svg" alt="close" title="close"/>
                                        </div>
                                    </div>
                                </div>
                                {if !($parameters.cmd == "seller_profile")}
                                    <div class="block-1 ico-input">
                                        <input type="search" name="seller_name" value="{$smarty.request.seller_name}" placeholder="Search by seller...">
                                    </div>
                                {else}
                                    <input type="hidden" name="seller_id" value="{$parameters.record->id}">
                                {/if}
                                <div class="block-1 sort-dropdown">
                                    <select name="sort" class="select-3">
                                        <option value="">Sort By</option>
                                        <option value="1" {if $smarty.request.sort == "1"}selected=""{/if}>Auction End Time (Closest)</option>
                                        <option value="2" {if $smarty.request.sort == "2"}selected=""{/if}>Distance (Closest)</option>
                                        <option value="3" {if $smarty.request.sort == "3"}selected=""{/if}>Mileage (Low to High)</option>
                                        <option value="4" {if $smarty.request.sort == "4"}selected=""{/if}>Mileage (High to Low)</option>
                                        <option value="5" {if $smarty.request.sort == "5"}selected=""{/if}>Vehicle Year (Most Recent)</option>
                                        <option value="6" {if $smarty.request.sort == "6"}selected=""{/if}>Vehicle Year (Oldest)</option>
                                        <option value="7" {if $smarty.request.sort == "7"}selected=""{/if}>Price (Low to High)</option>
                                        <option value="8" {if $smarty.request.sort == "8"}selected=""{/if}>Price (High to Low)</option>
                                    </select>
                                    <div class="ico">
                                        <img class="svg-icon-inject" src="/images/icons/sort-arrows.svg" alt="Sort" title="Sort"/>
                                    </div>
                                </div>
                                <div class="block-1">
                                    <div class="toggle-block slide">
                                        <div class="opener">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/icon-location.svg" alt="Location" title="Location"/>
                                            </div>
                                            Location
                                            <span class="arrow"></span>
                                        </div>
                                        <div class="slide">
                                            <div class="block-1">
                                                <label>Enter Zipcode/City</label>
                                                <input name="city_zip" value="{$smarty.request.city_zip}" type="text"/>
                                            </div>
                                            <div class="block-1">
                                                <label>Enter state</label>
                                                <select name="state" class="select-3">
                                                    <option value=""></option>
                                                    {if $parameters.filters.states}
                                                        {foreach from=$parameters.filters.states item=item}
                                                            <option value="{$item->abbr}" {if $item->abbr == $smarty.request.state}selected=""{/if}>{$item->name}({$item->abbr})</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <label>Search Radius (in miles)</label>
                                                <select name="miles" class="select-3">
                                                    <option value=""></option>
                                                    {if $parameters.filters.miles}
                                                        {foreach from=$parameters.filters.miles item=item}
                                                            <option value="{$item}" {if $item == $smarty.request.miles}selected=""{/if}>{$item}</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <div class="mini-cta use_location">
                                                    <span>use my location</span>
                                                    <img src="/images/icons/icon-location-blue.svg" alt="use my location" title="use my location">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-1">
                                    <div class="toggle-block slide">
                                        <div class="opener">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/controls.svg" alt="Filters" title="Filters"/>
                                            </div>
                                            Filters
                                            <span class="arrow"></span>
                                        </div>
                                        <div class="slide">
                                            <div class="block-1">
                                                <label>Vehicle Make</label>
                                                <select name="make" class="select-3 make">
                                                    <option></option>
                                                    {if $parameters.filters.make}
                                                        {foreach from=$parameters.filters.make item=item}
                                                            <option {if $smarty.request.make == $item.name}selected=""{/if} value="{$item.name}">{$item.name|lower|ucfirst}({$item.count})</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <label>Vehicle Model</label>
                                                <select name="model" class="select-3 model">
                                                    <option value=""></option>
                                                    {if $parameters.filters.model}
                                                        {foreach from=$parameters.filters.model item=item key=key}
                                                            <option {if $smarty.request.model == $key}selected=""{/if} value="{$key}" data-make="{$item.make}">{$item.name|lower|ucfirst}({$item.count})</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <div class="val-box">
                                                    <label>Vehicle Year</label>
                                                    <div class="fake-input">
                                                        <input type="hidden" name="year_from" value="" id="input-number3-hidden"/>
                                                        <input class="no-style-input class1" type="decimal" name="year_from_visible" value="{$smarty.request.year_from}" step="1" min="1960" max="{$smarty.now|date_format:"%Y"}" id="input-number3"/>
                                                        <span class="dash">-</span>
                                                        <input type="hidden" name="year_to" value="" id="input-number4-hidden"/>
                                                        <input class="no-style-input class2" type="decimal" name="year_to_visible" value="{$smarty.request.year_to}" step="1" min="1960" max="{$smarty.now|date_format:"%Y"}" id="input-number4"/>
                                                    </div>
                                                </div>
                                                <div id="yearrange" data-from="{$parameters.filters.year.min}" data-to="{$parameters.filters.year.max}"></div>
                                            </div>
                                            <div class="block-1">
                                                <div class="val-box">
                                                    <label>Price Range</label>
                                                    <div class="fake-input">
                                                        <input type="hidden" name="price_from" value="" id="input-number1-hidden"/>
                                                        <span>$</span> <input class="no-style-input class1" name="price_from_visible" value="{$smarty.request.price_from}" type="decimal" step="1" min="0" max="200000" id="input-number1"/>
                                                        <span class="dash">-</span>
                                                        <input type="hidden" name="price_to" value="" id="input-number2-hidden"/>
                                                        <span>$</span> <input class="no-style-input class2" name="price_to_visible" value="{$smarty.request.price_to}" type="decimal" step="1" min="0" max="200000" id="input-number2"/>
                                                    </div>
                                                </div>
                                                <div id="pricerange" data-from="{$parameters.filters.price.min}" data-to="{$parameters.filters.price.max}"></div>
                                            </div>
                                            <div class="block-1">
                                                <input id="buy_it_now_only"{if $smarty.request.buy_it_now_only == 1} checked="checked"{/if} name="buy_it_now_only" type="checkbox" value="1" />
                                                <label class="check-label" for="buy_it_now_only">Buy It Now Vehicles Only</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="block-1">
                                    <div class="toggle-block slide last">
                                        <div class="opener">
                                            <div class="ico">
                                                <img class="svg-icon-inject" src="/images/icons/controls.svg" alt="Advanced Filters" title="Advanced Filters"/>
                                            </div>
                                            Advanced Filters
                                            <span class="arrow"></span>
                                        </div>
                                        <div class="slide p-bot-0">
                                            <div class="block-1">
                                                <div class="val-box">
                                                    <label>Mileage</label>
                                                    <div class="fake-input">
                                                        <input type="hidden" name="mileage_from" value="" id="input-number5-hidden"/>
                                                        <input class="no-style-input class1" type="decimal" name="mileage_from_visible" value="{$smarty.request.mileage_from}" step="1" min="0" max="200000" id="input-number5"/>
                                                        <span class="dash">-</span>
                                                        <input type="hidden" name="mileage_to" value="" id="input-number6-hidden"/>
                                                        <input class="no-style-input class2" type="decimal" name="mileage_to_visible" value="{$smarty.request.mileage_to}" step="1" min="0" max="200000" id="input-number6"/>
                                                    </div>
                                                </div>
                                                <div id="milesrange" data-from="{$parameters.filters.mileage.min}" data-to="{$parameters.filters.mileage.max}"></div>
                                            </div>
                                            <div class="block-1 not-visible-multiple-select-items">
                                                <label>Color</label>
                                                <select id="color-selectize" multiple="multiple" name="colors[]">
                                                    {if $parameters.filters.color}
                                                        {foreach from=$parameters.filters.color item=item key=key}
                                                            <option {if $smarty.request.color && $key && in_array($key, $smarty.request.color)}selected=""{/if} value="{$key}" >{$item.name} ({$item.count})</option>
                                                        {/foreach}
                                                    {/if}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <label># of engine cylinders</label>
                                                <select name="number_of_cylinders" class="select-3">
                                                    <option value=""></option>
                                                    {foreach from=$parameters.filters.number_of_cylinders item=item}
                                                        <option value="{$item}" {if $smarty.request.number_of_cylinders == $item}selected=""{/if}>{$item}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <label>Transmission Type</label>
                                                <select name="transmission" class="select-3">
                                                    <option value=""></option>
                                                    <option value="Manual" {if $smarty.request.transmission == "Manual"}selected=""{/if}>Manual</option>
                                                    <option value="Automatic" {if $smarty.request.transmission == "Automatic"}selected=""{/if}>Automatic</option>
                                                </select>
                                            </div>
                                            <div class="block-1">
                                                <label>Title Type</label>
                                                <select name="title_wait_times" class="select-3">
                                                    <option value=""></option>
                                                    {foreach from=$parameters.filters.title_wait_times item=item key=key }
                                                        <option value="{$item}" {if $smarty.request.title_wait_times == $item} selected="selected"{/if}>{$item}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed-search-options">
        <a href="#" class="btn-2 blue apply_filters_button" title="Apply">Apply</a>
        <a href="#" class="btn-2 black clear_filters_button" title="Clear Filters">Clear Filters</a>
    </div>
{/strip}
