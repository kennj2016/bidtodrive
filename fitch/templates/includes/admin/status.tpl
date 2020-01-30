{strip}

{if $parameters.status}

	{if $parameters.has_error}
		{assign var=type value="error"}
		{assign var=fixed value=1}
	{else}
		{assign var=type value="success"}
		{assign var=fixed value=0}
	{/if}
	
	{assign var=status value=$parameters.status|trim|escape|nl2br}
	{include file="includes/admin/message.tpl" type=$type message="<b>`$status`</b>" fixed=$fixed}
	
{/if}

{/strip}