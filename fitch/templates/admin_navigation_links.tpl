{strip}

{foreach from=$records item=item}
	<li class="nav-item-link" data-link-fields='{ldelim}"title":"{$item->title}","link":"{$item->link}","is_external":"{$item->is_external}"{rdelim}'>
		<div>
			<span>{$item->title|escape}</span>
			<a class="btn-expand {if $item->items}active{else}hide{/if}" href="#"></a>
			<a class="btn-delete" href="#"></a>
			<a class="btn-edit" href="#"></a>
		</div>
		<ul class="subitems">
			{if $item->items}{include file="admin_navigation_links.tpl" records=$item->items}{/if}
		</ul>
	</li>
{/foreach}

{/strip}