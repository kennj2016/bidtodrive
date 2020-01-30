{strip}

{assign var="DELIM" value=" : "}
<div class="bread-crumb">
	{assign var=url value="/admin"}
	<a href="{$url}">Administration</a>
	{assign var=parent value=$admin_tools.parent_breadcrumbs}
	{if $parent}
		{foreach from=$parent item=item}
			{assign var=url value="`$url`/`$item.url`"}
			{$DELIM}<a href="{$url}/">{$item.title|escape}</a>
		{/foreach}
	{/if}
	{if $admin_tools.current_breadcrumb}
		{$DELIM}{$admin_tools.current_breadcrumb|escape}
	{/if}
</div>

{/strip}