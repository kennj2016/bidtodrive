{strip}
{include file="includes/admin/site_top.tpl"}

	<form class="validate" action="" method="post">

		<div class="section">

		<div class="section-title-box">
			{if $parameters.header.return}
				<a href="{$parameters.header.return|escape}" class="button1">
					Cancel
				</a>
			{/if}
			<input class="button1" type="submit" name="submit" value="Save" />
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Text<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text" placeholder="text" name="text">{$parameters.record|escape}</textarea>
				</div>
			</div>
		</div>

	</div>
	</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}