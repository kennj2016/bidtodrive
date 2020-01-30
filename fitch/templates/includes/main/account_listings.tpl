<div id="seller-my-listing" class="page active" {if $parameters.action == "edit_auction" || $parameters.action == "relist_auction" || $parameters.action == "create_auction" || $parameters.action == "account_content_blocks" || $parameters.action == "account_info"}style="display:none;"{/if}>
	<h4 class="head-title button-add">
		<div class="ico">
			<img class="svg-icon-inject" src="/images/icons/icon-mywatchedlisting.svg" alt="my watched listing" title="my watched listing"/>
		</div>
		<span>My listings</span>
		<form id="seller-watched-listings-sort" class="drop-filters">
		    <input type="hidden" id="auction_status_filter" name="auction_status" value="">
			<div id="sort-dropdown">
				<select name="sort" class="select-3" id="sort-filter">
					<option value="">Sort By</option>
					<option value="1" {if $smarty.request.sort == "1"}selected=""{/if}>
						Auction End Time (Closest)
					</option>
					<option value="2" {if $smarty.request.sort == "2"}selected=""{/if}>
						Distance (Closest)
					</option>
					<option value="3" {if $smarty.request.sort == "3"}selected=""{/if}>
						Mileage (Low to High)
					</option>
					<option value="4" {if $smarty.request.sort == "4"}selected=""{/if}>
						Mileage (High to Low)
					</option>
					<option value="5" {if $smarty.request.sort == "5"}selected=""{/if}>
						Vehicle Year (Most Recent)
					</option>
					<option value="6" {if $smarty.request.sort == "6"}selected=""{/if}>
						Vehicle Year (Oldest)
					</option>
					<option value="7" {if $smarty.request.sort == "7"}selected=""{/if}>
						Price (Low to High)
					</option>
					<option value="8" {if $smarty.request.sort == "8"}selected=""{/if}>
						Price (High to Low)
					</option>
				</select>
			</div>
		</form>
	</h4>
	{if $parameters.auctions_statuses}
		<div class="top-controll-panel" style="border-top:none;">
			<div class="left">
				<div class="result-detail">
				    <form id="auctions-statuses-form">
    					<div id="auctions-statuses-filter">
    					    <input type="hidden" id="auction_status" name="auction_status" value="">
							<a title="total" href="javascript:void(0);" data-auction-status-filter="total" data-auction-status-count="{$parameters.auctionsStatusesTotal}">Total: {$parameters.auctionsStatusesTotal}</a> |
							{ $countSold = 0; }
    						{foreach name=statuses from=$parameters.auctions_statuses key=status item=count}
    							<a title="{$status}" href="javascript:void(0);" data-auction-status-filter="{$status}" data-auction-status-count="{$count}">{$count} {if $status == "Canceled"}Unsold{else}{$status}{/if}</a>{if !$smarty.foreach.statuses.last} | {/if}
    						{/foreach}
							 <!-- | <a title="Unsold" href="javascript:void(0);" data-auction-status-filter="Unsold" data-auction-status-count="{$parameters.countUnSold}">{$parameters.countUnSold} Unsold</a> -->
    					</div>
    				</form>
				</div>
			</div>
		</div>
	{/if}

	<div id="module-search-listing" class="module-search-listing">
		<div class="content">
			<!-- <h4 class="title-action" style="margin:0px 0px 10px 10px"></h4> -->
			<div class="listing-1 balancer gridview">

				{include file="seller_watched_auction_list.tpl"}
			</div>
		</div>
	</div>
</div>
