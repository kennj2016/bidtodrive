{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			{*<h3>{$parameters.header.title|escape}</h3>*}
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
					Title
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="Title" name="title" value="{$parameters.record->title|escape}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Body
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="ckeditor" placeholder="Body" name="body">{$parameters.record->body|escape}</textarea>
				</div>
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}