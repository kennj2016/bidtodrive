{strip}
{include file="includes/main/site_top.tpl"}

	<div class="row no-gutters bg-image hexagon" {if $parameters.settings->hero_image}style="background-image:url(/site_media/{$parameters.settings->hero_image}/);"{/if}>
		<div class="container">
			<div class="col-24">
				<div class="module-hero-2 alt">
					<div class="content">
							{if $parameters.settings->hero_title}<h3 class="title">{$parameters.settings->hero_title|escape}</h3>{/if}
							{if $parameters.settings->hero_subtitle}<p>{$parameters.settings->hero_subtitle|escape}</p>{/if}
						</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row no-gutters">
		<div class="container full-width">
			<div class="col-24">
				<div class="module-about-1">
					<div class="content container">
						<div class="box">
							<div class="item">
								<h2 class="title">bid on cars</h2>
								{if $parameters.settings->intro_title}<h5 class="subtitle">{$parameters.settings->intro_title|escape}</h5>{/if}
								{if $parameters.settings->intro_subtitle}<p>{$parameters.settings->intro_subtitle|escape}</p>{/if}
							</div>
							<div class="honey"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row no-gutters">
		<div class="container full-width">
			<div class="col-24">
				<div class="module-about-2">
					<div class="content container">
						<div class="left">
							<div>
								{if $parameters.settings->key_features_title}<h3 class="title">{$parameters.settings->key_features_title}</h3>{/if}
								{if $parameters.settings->key_features_intro_text}<p>{$parameters.settings->key_features_intro_text}</p>{/if}
							</div>
						</div>
						<div class="right">
							<span class="bg" {if $parameters.settings->key_features_background_image}style="background-image:url(/site_media/{$parameters.settings->key_features_background_image}/);"{/if}></span>
							{if $parameters.settings->buckets}
								{foreach from=$parameters.settings->buckets item=item}
									<div class="item">
										<div class="ico">
												<img src="/site_media/{$item->icon}/" class="svg-icon-inject" alt="{$item->title|escape}" title="{$item->title|escape}">
										</div>
										{if $item->title}<h5>{$item->title|escape}</h5>{/if}
										{if $item->subtitle}<p>{$item->subtitle|escape}</p>{/if}
										{if $item->button_url && $item->button_text}<a href="{$item->button_url}" title="{$item->button_text|escape}"><span class="btn-2 blue">{$item->button_text|escape}</span></a>{/if}
									</div>
								{/foreach}
							{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
								<div class="row no-gutters overflow">
										<div class="container full-width">
												<div class="col-24">
														<div class="module-about-3">
																<div class="content container">
																		<h2 class="title">How it works</h2>
																		<div class="holder">
																			{if $parameters.settings->steps}
																				{foreach from=$parameters.settings->steps key=index item=item name=count}
																					<div class="item">																						
																						<span class="number">0{$smarty.foreach.count.index+1}</span>
																						{if $item->icon}
																							<div class="ico">
																								<img src="/site_media/{$item->icon}/" class="svg-icon-inject" alt="{$item->title|escape}" title="{$item->title|escape}">
																							</div>
																						{/if}
																						{if $item->title}<h5 class="subtitle">{$item->title|escape}</h5>{/if}
																						{if $item->description}<p>{$item->description}</p>{/if}
																					</div>
																				{/foreach}
																			{/if}
																		</div>
																</div>
														</div>
												</div>
										</div>
								</div>
	<div class="row no-gutters">
		<div class="container">
			<div class="col-24">
				<div class="module-about-4">
					<div class="content">
						<div class="img-holder" {if $parameters.settings->leadership_image}style="background-image:url(/site_media/{$parameters.settings->leadership_image}/);"{/if}>
						</div>
						<div class="text">
							<div>
								{if $parameters.settings->leadership_title}<h2 class="title">{$parameters.settings->leadership_title}</h2>{/if}
								{$parameters.settings->leadership_description}
								<span class="sign"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

{include file="includes/main/site_bottom.tpl"}
{/strip}