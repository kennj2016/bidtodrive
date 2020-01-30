{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate autosave" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			{*<h3>{$parameters.header.title|escape}</h3>*}
			{if $parameters.header.return}
				<a href="{$parameters.header.return|escape}" class="button1">
					Cancel
				</a>
			{/if}
			{include file="includes/admin/revisions_action.tpl"}
		</div>
		
		<div class="section">
			<div class="section-title-box">
				<h3>
					Status
				</h3>
			</div>
			<div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						Active
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						<select name="status">
							<option value="0">No</option>
							<option value="1"{if $parameters.record->status} selected="selected"{/if}>Yes</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Title<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input name="title" placeholder="Title" value="{$parameters.record->title|escape}" type="text" class="input-text" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Subtitle
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input name="subtitle" placeholder="subtitle" value="{$parameters.record->subtitle|escape}" type="text" class="input-text" />
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
					<textarea class="input-text ckeditor" placeholder="Body" name="body">{$parameters.record->body|escape}</textarea>
				</div>
			</div>
		</div>

		{include file="includes/admin/metadata_fields.tpl"}
		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

{include file="includes/admin/site_bottom.tpl"}
{/strip}