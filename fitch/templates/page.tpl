{strip}
{include file="includes/main/site_top.tpl"}

	<div class="row no-gutters bg-image" {if $parameters.page->hero_image} style="background-image:url('/site_media/{$parameters.page->hero_image}');"{/if}>
		<div class="container">
			<div class="col-24 last first">
				<div class="module-hero-2">
					<div class="content">
						<h3 class="title">{$parameters.page->title|escape}</h3>
						<p>{$parameters.page->subtitle|escape}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	{include file="includes/main/breadcrumbs.tpl"}
	
	{if $parameters.page}
		{$parameters.page->body}
	{/if}

{include file="includes/main/site_bottom.tpl"}
{/strip}