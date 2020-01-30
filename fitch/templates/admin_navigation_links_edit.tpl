{strip}

<form class="validate" action="" method="post">
	<div class="section">
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					title<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="title" name="title" value="{$parameters.fields.title|escape}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					link
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<input type="text" class="input-text" placeholder="link" name="link" value="{$parameters.fields.link|escape}" />
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					external
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					<select name="is_external">
						<option value="0">No</option>
						<option value="1"{if $parameters.fields.is_external} selected="selected"{/if}>Yes</option>
					</select>
				</div>
			</div>
		</div>
		
		<div class="clearfix"><input class="button1" type="submit" value="save" /></div>
		
	</div>
</form>

{/strip}