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
			{if !$parameters.record->id}
				<input class="button1" type="submit" name="submit" value="Save" />
			{/if}
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					title<span class="text-red"> *</span>
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					{if $parameters.record->id}
						<div class="input-text">{$parameters.record->title|escape}</div>
					{else}
						<input type="text" class="input-text" placeholder="title" name="title" value="{$parameters.record->title|escape}"/>
					{/if}
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					label
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					{if $parameters.record->id}
						<div class="input-text">{$parameters.record->label|escape}</div>
					{else}
						<input type="text" class="input-text" placeholder="label" name="label" value="{$parameters.record->label|escape}"/>
					{/if}
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
					{if $parameters.record->id}
						<div class="input-text">{$parameters.record->type|escape}</div>
					{else}
						<select name="type">
							{foreach from=$parameters.types item=type}
								<option{if $parameters.record->type == $type} selected="selected"{/if}>{$type|escape}</option>
							{/foreach}
						</select>
					{/if}
				</div>
			</div>
		</div>
		
		<div class="form-field">
			<div class="form-field-label-wrap">
				<div class="form-field-label">
					Readonly
				</div>
			</div>
			<div class="form-field-input-wrap">
				<div class="form-field-input">
					{if $parameters.record->id}
						<div class="input-text">{if $parameters.record->readonly}Yes{else}No{/if}</div>
					{else}
						<select name="readonly">
							<option value="0">No</option>
							<option value="1"{if $parameters.record->readonly} selected="selected"{/if}>Yes</option>
						</select>
					{/if}
				</div>
			</div>
		</div>
		
		{if $parameters.record->id && $parameters.record->type == "images"}
			
			{if $parameters.record->options->sizes}
				{foreach from=$parameters.record->options->sizes item=size}
					<div class="form-field-group">
						<div class="form-field-group-label">
							{$size->title|escape}
						</div>
						<div class="form-field-group-content">
							
							<div class="form-field">
								<div class="form-field-label-wrap">
									<div class="form-field-label">
										Title
									</div>
								</div>
								<div class="form-field-input-wrap">
									<div class="form-field-input">
										<div class="input-text">{$size->title|escape}</div>
									</div>
								</div>
							</div>
							<div class="form-field">
								<div class="form-field-label-wrap">
									<div class="form-field-label">
										Label
									</div>
								</div>
								<div class="form-field-input-wrap">
									<div class="form-field-input">
										<div class="input-text">{$size->label|escape}</div>
									</div>
								</div>
							</div>
							<div class="form-field">
								<div class="form-field-label-wrap">
									<div class="form-field-label">
										Width
									</div>
								</div>
								<div class="form-field-input-wrap">
									<div class="form-field-input">
										<div class="input-text">{$size->width|escape}</div>
									</div>
								</div>
							</div>
							<div class="form-field">
								<div class="form-field-label-wrap">
									<div class="form-field-label">
										Height
									</div>
								</div>
								<div class="form-field-input-wrap">
									<div class="form-field-input">
										<div class="input-text">{$size->height|escape}</div>
									</div>
								</div>
							</div>
							{if $size->save_aspect_ratio}
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											save aspect ratio
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												Yes
											</div>
										</div>
									</div>
								</div>
							{/if}
							{if $size->enlarge_small_images}
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											enlarge small images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												Yes
											</div>
										</div>
									</div>
								</div>
							{/if}
							{if $size->fit_small_images}
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											fit small images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												Yes
											</div>
										</div>
									</div>
								</div>
							{/if}
							{if $size->fit_large_images}
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											fit large images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												Yes
											</div>
										</div>
									</div>
								</div>
							{/if}
							{if $size->background_color}
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Background color
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												{$size->background_color}
											</div>
										</div>
									</div>
								</div>
							{/if}
							
						</div>
					</div>
				{/foreach}
			{/if}
			
		{elseif !$parameters.record->id}
			<div class="name-type value-images">
				<div class="form-field-repeating" data-records="
					{if $parameters.record->options->sizes}
						{$parameters.record->options->sizes|@json_encode|escape}
					{else}
						[]
					{/if}
					" data-default="
						{ldelim}&quot;enlarge_small_images&quot;:true{rdelim}
					" data-prepare="prepareSize">
					<div class="form-field-repeating-footer">
						<a class="button1 form-field-repeating-add" href="#">Add More</a>
					</div>
					<div class="form-field-repeating-content"></div>
					<script type="text/html">
						<div class="form-field-repeating-item">
							
							<div class="form-field-repeating-item-header list-action-hover">
								<div class="left">
									<a class="list-action action-move"></a>
									<span class="form-field-repeating-item-title">
										<span class="default">
											Size #<span class="form-field-repeating-item-position"></span>
										</span>
										<span class="custom" rel="[name*=title]"></span>
									</span>
								</div>
								<div class="right">
									<div class="item">
										<a href="#" class="list-action action-delete form-field-repeating-delete"></a>
									</div>
									<div class="item">
										<a href="#" class="open"></a>
									</div>
								</div>
							</div>
							
							<div class="form-field-repeating-item-content">
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											title<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="title" name="sizes[<%= index %>][title]" value="<%= htmlentities(record.title) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											label<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="label" name="sizes[<%= index %>][label]" value="<%= htmlentities(record.label) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											width<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="width" name="sizes[<%= index %>][width]" value="<%= htmlentities(record.width) %>"/>
										</div>
									</div>
								</div>
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											height<span class="text-red"> *</span>
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="height" name="sizes[<%= index %>][height]" value="<%= htmlentities(record.height) %>"/>
										</div>
									</div>
								</div>
								
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											save aspect ratio
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												<input type="checkbox" name="sizes[<%= index %>][save_aspect_ratio]" value="1" <%= record.save_aspect_ratio ? 'checked="checked"' : '' %> />
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											enlarge small images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												<input type="checkbox" name="sizes[<%= index %>][enlarge_small_images]" value="1" <%= record.enlarge_small_images ? 'checked="checked"' : '' %> />
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											fit small images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												<input type="checkbox" name="sizes[<%= index %>][fit_small_images]" value="1" <%= record.fit_small_images ? 'checked="checked"' : '' %> />
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											fit large images
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<div class="input-text">
												<input type="checkbox" name="sizes[<%= index %>][fit_large_images]" value="1" <%= record.fit_large_images ? 'checked="checked"' : '' %> />
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-field">
									<div class="form-field-label-wrap">
										<div class="form-field-label">
											Background color
										</div>
									</div>
									<div class="form-field-input-wrap">
										<div class="form-field-input">
											<input type="text" class="input-text" placeholder="background color" name="sizes[<%= index %>][background_color]" value="<%= htmlentities(record.background_color) %>"/>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
					</script>
				</div>
			</div>
		{/if}

	</div>
</form>

{include file="includes/admin/site_bottom.tpl"}
{/strip}