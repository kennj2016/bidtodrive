{strip}
{include file="includes/admin/site_top.tpl"}

<form class="validate" action="" method="post">
	<div class="section">

		<div class="section-title-box">
			<a href="/admin/" class="button1">cancel</a>
			{include file="includes/admin/revisions_action.tpl"}
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					register intro
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="register intro" name="register_intro">{$parameters.record->register_intro}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					seller confirmation message
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="seller registration confirmation message" name="seller_registration_confirmation_message">{$parameters.record->seller_registration_confirmation_message}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					buyer confirmation message
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="buyer registration confirmation message" name="buyer_registration_confirmation_message">{$parameters.record->buyer_registration_confirmation_message}</textarea>
				</div>
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/revisions.tpl" id="$parameters.record->id"}

{include file="includes/admin/site_bottom.tpl"}
{/strip}