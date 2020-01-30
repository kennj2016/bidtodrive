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
					Login Intro
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="login intro" name="login_intro">{$parameters.record->login_intro}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Forgot Password Intro
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="forgot password intro" name="forgot_password_intro">{$parameters.record->forgot_password_intro}</textarea>
				</div>
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/revisions.tpl" id="$parameters.record->id"}

{include file="includes/admin/site_bottom.tpl"}
{/strip}