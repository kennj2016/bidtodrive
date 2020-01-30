{strip}

<div class="form-field-group">
	<div class="form-field-group-label">
		Metadata Fields
	</div>
	<div class="form-field-group-content">
		
		{if !$hide_url_title}
			<div class="form-field">
				<div class="form-field-label-wrap">
					<div class="form-field-label">
						URL Title
					</div>
				</div>
				<div class="form-field-input-wrap">
					<div class="form-field-input">
						<input type="text" class="input-text" placeholder="URL Title" name="url_title" value="{$parameters.record->url_title|escape}" />
					</div>
				</div>
			</div>
		{/if}
		
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

{/strip}