{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/blog/posts/" class="button1">cancel</a>
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
						active
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
					title<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="title" name="title" value="{$parameters.record->title|escape}"/>
				</div>
			</div>
		</div>
				
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					category<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="category_id">
						<option value="0">select</option>
						{if $parameters.categories}
							{foreach from=$parameters.categories item=item}
								<option value="{$item->id}"{if $parameters.record->category_id == $item->id} selected="selected"{/if}>{$item->title|escape}</option>
							{/foreach}
						{/if}
					</select>
				</div>
			</div>
		</div>
    
    <div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						Image
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						<input data-site-media="news" name="image" value="{$parameters.record->image}"/>
					</div>
				</div>
			</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Date
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text datetimepicker" placeholder="Date" name="datetime_publish" value="{if $parameters.record->datetime_publish}{$parameters.record->datetime_publish|date_format:$web_config.admin_datetime_format}{else}{$smarty.now|date_format:$web_config.admin_datetime_format}{/if}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					author
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="author_id">
						<option value="0">select</option>
						{if $parameters.users}
							{foreach from=$parameters.users item=item}
								<option value="{$item->id}"{if $parameters.record->author_id == $item->id} selected="selected"{/if}>{$item->name|escape}</option>
							{/foreach}
						{/if}
					</select>
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					description<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text ckeditor" placeholder="description" name="description">{$parameters.record->description|escape}</textarea>
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