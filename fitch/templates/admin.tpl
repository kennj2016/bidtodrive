{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/admin.js"></script>

<div class="grid{is_admin tool=999} sortable{/is_admin}">
	
	{if $parameters.header.dashboard->hasBlocks()}

		{assign var=blocks value=$parameters.header.dashboard->getBlocks()}
	
		<style type="text/css">
			{foreach name=blocks from=$blocks item=block}
				{if $block->icon}
					#block-icon-{$smarty.foreach.blocks.index}{ldelim}
						background-image:url(/img/admin/{if $block->custom_icon}custom/{/if}dashboard-icons/normal/{$block->icon}.png);
					{rdelim}
				{/if}
			{/foreach}
			@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi){ldelim} 
				{foreach name=blocks from=$blocks item=block}
					{if $block->icon}
						#block-icon-{$smarty.foreach.blocks.index}{ldelim}
							background-image:url(/img/admin/{if $block->custom_icon}custom/{/if}dashboard-icons/retina/{$block->icon}.png);
						{rdelim}
					{/if}
				{/foreach}
			{rdelim}
		</style>
		
		{foreach name=blocks from=$blocks item=block}
			{is_admin tool=$block->ids}
				<div class="box">
					<a href="{$block->tools[0]->action->url}" class="title">
						{$block->title|escape}
					</a>
					<div class="page-one">
						{if $block->icon}
							<div class="icon" id="block-icon-{$smarty.foreach.blocks.index}"></div>
						{/if}
					</div>
					<div class="page-two">
						<ul>
							{foreach from=$block->tools item=tool}
								{is_admin tool=$tool->id}
									<li>
										<a href="{$tool->action->url}" class="tool-title">
											{$tool->title|escape}
										</a>
										<div class="tool-buttons">
											{foreach from=$tool->actions item=action}
												<a href="{$action->url}" class="tool-button-{$action->type}"></a>
											{/foreach}
											{if count($tool->actions) < 2}
												<a href="javascript:void(0);" class="tool-button-none"></a>
											{/if}
										</div>
									</li>
								{/is_admin}
							{/foreach}
						</ul>
					</div>
				</div>
			{/is_admin}
			
		{/foreach}
	{/if}
	
	<div style="display:none;" id="notHavePermissions">
		<script type="text/javascript">
			$(function(){ldelim}
				if($('.grid .box').length) $('#notHavePermissions').remove();
				else $('#notHavePermissions').show();
			{rdelim});
		</script>
		{include file="includes/admin/message.tpl" message="<b>You do not have permissions to use any configuration tools. Please contact the site administrator.</b>"}
	</div>
	
</div>

{include file="includes/admin/site_bottom.tpl"}
{/strip}