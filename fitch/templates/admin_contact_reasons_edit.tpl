{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/contact_reasons/" class="button1">cancel</a>
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

		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

{include file="includes/admin/site_bottom.tpl"}
{/strip}