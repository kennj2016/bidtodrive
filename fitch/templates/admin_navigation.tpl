{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/jquery.mjs.nestedSortable.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form id="form-navigation" class="validate" action="" method="post">
	<div class="section">
		
		<div class="section-title-box">
			{if $parameters.header.return}
				<a href="{$parameters.header.return|escape}" class="button1">
					Cancel
				</a>
			{/if}
			<input class="button1" type="submit" value="save" />
			<a href="#" class="button1 btn-nav-add">add new {$admin_tools.tool_title_singular}</a>
		</div>
		
		<input type="hidden" name="navigation" value="" />
		
		<div class="nav-items">
			{if $parameters.records}
				{foreach name="records" from=$parameters.records item=item}
					<div class="nav-item">
						<div class="nav-item-wrapper">
							<div class="nav-item-header">
								<input type="text" name="title" value="{$item->title|escape}">
								<a class="btn-links" href="#"></a>
							</div>
							<div class="nav-item-content">
								<ul class="nav-item-links">
									{if $item->items}{include file="admin_navigation_links.tpl" records=$item->items}{/if}
								</ul>
							</div>
						</div>
						<a class="btn-nav-delete" href="#"><span></span></a>
					</div>
				{/foreach}
			{/if}
		</div>
		
	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}