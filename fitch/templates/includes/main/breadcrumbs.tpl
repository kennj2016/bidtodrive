{strip}
	{if $page->hasBreadcrumbs()}
		<div class="row flex no-gutters bg-grey">
			<div class="container">
				<div class="col-24">
					<div class="breadcrumbs">
						<p>
							<a href="/" class="home"><img src="/images/icons/icon-home.svg" alt="Homepage" title="Homepage"/></a>
							{foreach name=breadcrumbs from=$page->getBreadcrumbs() item=breadcrumb}
								{if $breadcrumb->url}<a href="{$breadcrumb->url}" title="{$breadcrumb->url}">{/if}
									{$breadcrumb->link|escape}
								{if $breadcrumb->url}</a>{/if}
							{/foreach}
						</p>
					</div>
				</div>
			</div>
		</div>
	{/if}
{/strip}