{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>

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
		
		{assign var=value value=$parameters.record->value}
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					{$parameters.record->title|escape}
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					{if $parameters.record->type eq "bool"}
						<div class="input-text">
							<input type="checkbox" name="value"{if $value} checked="checked"{/if} />
						</div>
					{elseif $parameters.record->type eq "text"}
						<textarea class="input-text {if $parameters.record->id == 10 || $parameters.record->id == 11}ckeditor{/if}" name="value">{$value|escape}</textarea>
					{elseif $parameters.record->type eq "file"}
						<input data-site-media="site-vars" name="value" value="{$value|escape}"/>
					{elseif $parameters.record->type eq "date"}
						<input class="input-text datepicker" name="value" value="{$value|date_format:$web_config.admin_date_format}"/>
					{elseif $parameters.record->type eq "datetime"}
						<input class="input-text datetimepicker" name="value" value="{$value|date_format:$web_config.admin_datetime_format}"/>
					{elseif $parameters.record->type eq "time"}
						<input class="input-text timepicker" name="value" value="{$value|date_format:$web_config.admin_time_format}"/>
					{else}
						<input class="input-text" type="text" name="value" value="{$value|escape}" />
					{/if}
				</div>
			</div>
		</div>
		
	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}