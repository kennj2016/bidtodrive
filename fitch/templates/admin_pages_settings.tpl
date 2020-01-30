{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			{*<h3>{$parameters.header.title|escape}</h3>*}
			<a href="/admin/" class="button1">cancel</a>
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
					<input type="text" class="input-text"  placeholder="Title" name="title" value="{$parameters.record->title|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Description
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text ckeditor" placeholder="Description" name="description">{$parameters.record->description|escape}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Meta Title
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="Meta Title" name="meta_title" value="{$parameters.record->meta_title|escape}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Meta Keywords
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text" placeholder="Meta Keywords" name="meta_keywords">{$parameters.record->meta_keywords|escape}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Meta Description
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text" placeholder="Meta Description" name="meta_description">{$parameters.record->meta_description|escape}</textarea>
				</div>
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}