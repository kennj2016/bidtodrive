{strip}
{include file="includes/admin/site_top.tpl"}

<form action="" method="post">
	<div class="section">
		
		<div class="section-title-box">
			{*<h3>{$parameters.header.title|escape}</h3>*}
			{if $parameters.header.return}
				<a href="{$parameters.header.return|escape}" class="button1">
					Cancel
				</a>
			{/if}
			<input class="button1" type="submit" value="save" />
		</div>
		
		{if $parameters.tools}
			{foreach from=$parameters.tools item=item}
				<div class="form-field">
					<div class="form-field-label-wrap">
						<div class="form-field-label">
							{$item->title|escape}
						</div>
					</div>
					<div class="form-field-input-wrap">
						<div class="form-field-input">
							<div class="input-text">
								<input type="checkbox" name="permissions[]"{if in_array($item->id, $parameters.record->permissions)} checked="checked"{/if} value="{$item->id}" />
							</div>
						</div>
					</div>
				</div>
			{/foreach}
		{/if}
		
	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}