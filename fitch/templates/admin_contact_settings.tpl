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
					Subtitle
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="Subtitle" name="subtitle">{$parameters.record->subtitle}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Hero Image
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input data-site-media="hero-images" name="hero_image" value="{$parameters.record->hero_image}"/>
				</div>
			</div>
		</div>

		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					address
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="address" name="address" value="{$parameters.record->address}" />
				</div>
			</div>
		</div>
			
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					city
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="city" name="city" value="{$parameters.record->city}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					state
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="state" name="state" value="{$parameters.record->state}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					zip
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="zip" name="zip" value="{$parameters.record->zip}">
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					phone
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="phone" name="phone" value="{$parameters.record->phone}">
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					form intro
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="form intro" name="form_intro">{$parameters.record->form_intro}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					form submissions
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<textarea type="text" class="input-text" placeholder="form submissions" name="form_submissions">{$parameters.record->form_submissions}</textarea>
				</div>
			</div>
		</div>
		
		<div class="form-field-group">
			<div class="form-field-group-label">
				Metadata
			</div>
			<div class="form-field-group-content">
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
			</div>
		</div>
		
		{include file="includes/admin/admin_creators.tpl"}
		
	</div>
</form>

{include file="includes/admin/revisions.tpl" id="$parameters.record->id"}

{include file="includes/admin/site_bottom.tpl"}
{/strip}