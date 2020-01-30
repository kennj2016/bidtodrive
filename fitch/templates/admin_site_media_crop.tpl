{strip}

<div class="section" style="position:relative;z-index:1;">
	<div class="form-field">
		<div class="form-field-label-wrap">
			<div class="form-field-label">
				Size:
			</div>
		</div>
		<div class="form-field-input-wrap">
			<div class="form-field-input">
				<select>
					<option value="">Not Selected</option>
					{if $parameters.sizes}
						{foreach from=$parameters.sizes item=size}
							<option value="{$size->id|escape}">
								{$size->title|escape}
							</option>
						{/foreach}
					{/if}
				</select>
			</div>
		</div>
	</div>
</div>

<div class="cropper" style="position:relative;z-index:0;">
	<img src="/site_media/{$parameters.file->id}/" alt="" />
</div>

<div class="section">
	<div class="clearfix">
		<input type="button" value="save" class="button1" style="margin:0;" />
	</div>
</div>
	
{/strip}