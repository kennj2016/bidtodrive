{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/guest_customers/" class="button1">cancel</a>
			<input class="button1" type="submit" value="save" />
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					name<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input class="input-text" type="text" placeholder="name" name="name" value="{$parameters.record->name|escape}" />
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					email<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input class="input-text" type="text" placeholder="email" name="email" value="{$parameters.record->email|escape}" autocomplete="off" />
				</div>
			</div>
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
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}