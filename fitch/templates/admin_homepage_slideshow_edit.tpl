{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

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
					<input type="text" class="input-text"  placeholder="Title" name="title" value="{$parameters.record->title|escape}"/>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Image<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input data-site-media="homepage-slideshow" name="image" value="{$parameters.record->image|escape}"/>
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					URL
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text"  placeholder="URL" name="url" value="{$parameters.record->url|escape}"/>
				</div>
			</div>
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

		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}