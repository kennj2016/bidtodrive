{strip}

{if $tabs && is_array($tabs)}
	<ul class="tabs">
		{foreach from=$tabs item=item}
			<li{if $item->active} class="active"{/if}>
				<a href="{$item->url}">{$item->title}</a>
			</li>
		{/foreach}
	</ul>
{/if}

{/strip}