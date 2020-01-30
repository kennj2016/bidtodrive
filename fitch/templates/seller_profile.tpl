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
												<img class="svg-icon-inject" src="/images/icons/icons-30.svg" alt="filter" title="filter"/>
											</div>
										</div>
									</div>
								</div>
								<div class="sep-tablet"></div>
								<div class="seller-profile-module">
									<div class="img-holder" {if $parameters.record->profile_photo}style="background-image: url('/site_media/{$parameters.record->profile_photo}/m');"{else}style="background-image: url('/images/default-user-image.png');"{/if}>
										{if $smarty.session.user && $parameters.user->user_type == 'Buyer'}
											<div class="star-seller{if in_array($parameters.record->id, $parameters.user_fav_sellers)} active{/if}" record-id="{$parameters.record->id}">
												<img class="svg-icon-inject" src="/images/icons/star.svg" alt="star" title="star"/>
											</div>
										{/if}
									</div>
									<div class="text">
										<h2	class="title">{$parameters.record->name|escape}</h2>
										{if $parameters.record->city|escape}
										<div class="place">
											<div class="ico">
												<img class="svg-icon-inject" src="/images/icons/icon-loc-filled.svg" alt="{$parameters.record->name|escape}" title="{$parameters.record->name|escape}"/>
											</div>
											<span>{$parameters.record->city|escape}{if $parameters.record->state}, {$parameters.record->state|escape}{/if}</span>
										</div>
										{/if}
										{if $parameters.record->distance}
											<div class="away">
												<div class="ico">
													<img class="svg-icon-inject" src="/images/icons/icon-miles.svg" alt="distance" title="distance"/>
												</div>
												<span>{$parameters.record->distance|ceil} miles away</span>
											</div>
										{/if}
									</div>
								</div>
								<div class="top-controll-panel">
									<div class="left">
										<!--<div class="result-name">
											{if $smarty.request.keyword}{$smarty.request.keyword}{else}All{/if} Auctions
										</div>-->
										<div class="result-detail">
											{$parameters.record->name}'s Auctions
											{if $parameters.auctions_statuses}
												<br />
												<div id="auctions-statuses-filter">
													{foreach name=statuses from=$parameters.auctions_statuses key=status item=count}
														{if $status == 'Active'}
															<a href="javascript:void(0);" title="auction status filter" data-auction-status-filter="{$status}">{$count} {$status}</a>{if !$smarty.foreach.statuses.last}  {/if}
														{/if}
													{/foreach}
												</div>
											{/if}
										</div>
									</div>
									<div class="right">
										<div class="btn gridview ">
											<img class="svg-icon-inject" src="/images/icons/icon-grid-view.svg" alt="gridview" title="gridview"/>
										</div>
										<div class="btn listview active">
											<img class="svg-icon-inject" src="/images/icons/btn-grid.svg" alt="listview" title="listview"/>
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