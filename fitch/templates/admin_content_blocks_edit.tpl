{strip}
{include file="includes/admin/site_top.tpl"}

<script type="text/javascript" src="/fitch/resources/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="/fitch/resources/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="/js/admin/cmd/{$parameters.cmd}.js?v=2"></script>

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/content_blocks/" class="button1">cancel</a>
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
					type
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="type" id="type">
						<option value="">Select a type</option>
						<option value="Terms & Conditions"{if $parameters.record->type == "Terms & Conditions"} selected="selected"{/if}>Terms & Conditions</option>
						<option value="Additional Fees"{if $parameters.record->type == "Additional Fees"} selected="selected"{/if}>Additional Fees</option>
						<option value="Payment/Pickup"{if $parameters.record->type == "Payment/Pickup"} selected="selected"{/if}>Payment/Pickup</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="form-field" id="cb-description">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					description
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea class="input-text ckeditor" placeholder="description" name="description">{$parameters.record->description|escape}</textarea>
				</div>
			</div>
		</div>
		
		<div id="payment-method">
			<div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						Payment Method
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						{$parameters.payment_methods_field->htmlInput()}
					</div>
				</div>
			</div>
			<div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						pickup window
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						<input type="text" class="input-text" placeholder="pickup window" name="pickup_window" value="{$parameters.record->pickup_window|escape}"/>
					</div>
				</div>
			</div>
			<div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						pickup note
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						<textarea class="input-text ckeditor" placeholder="pickup note" name="pickup_note">{$parameters.record->pickup_note|escape}</textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					user
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="user_id">
						<option value="0">select</option>
						{if $parameters.users}
							{foreach from=$parameters.users item=item}
								<option value="{$item->id}"{if $parameters.record->user_id == $item->id} selected="selected"{/if}>{$item->name|escape}</option>
							{/foreach}
						{/if}
					</select>
				</div>
			</div>
		</div>

		{include file="includes/admin/admin_creators.tpl"}

	</div>
</form>

{include file="includes/admin/revisions.tpl" id=$smarty.get.id}

{include file="includes/admin/site_bottom.tpl"}
{/strip}